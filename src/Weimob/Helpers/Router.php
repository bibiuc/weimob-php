<?php


namespace Kiduc\Weimob\Helpers;

use \Closure;
use Kiduc\Weimob\Contracts\RouteInterface;
use Kiduc\Weimob\Exception\ValidationException;

class Router
{
    public static $ROUTES = [
        'oauth', 'membership', 'member', 'base'
    ];

    public static $ROUTE_SINGULAR_LOOKUP = [
        'oauth' => 'oauth',
        'base' => 'base',
        'membership' => 'membership',
        'member' => 'member'
    ];

    private $route;
    private $route_class;
    private $methods;

    public function __call($methd, $sentargs) {
        $method = ($methd === 'list' ? 'getList' : $methd );
        if (array_key_exists($method, $this->methods) && is_callable($this->methods[$method])) {
            return call_user_func_array($this->methods[$method], $sentargs);
        } else {
            throw new \Exception('Function "' . $method . '" does not exist for "' . $this->route . '".');
        }
    }


    public static function singularFor($method)
    {
        return (
        array_key_exists($method, Router::$ROUTE_SINGULAR_LOOKUP) ?
            Router::$ROUTE_SINGULAR_LOOKUP[$method] :
            null
        );
    }

    public function __construct($route, $weimobObj)
    {
        $routes = $this->getAllRoutes($weimobObj);

        if (!in_array($route, $routes)) {
            throw new ValidationException(
                "Route '{$route}' does not exist."
            );
        }

        $this->route = strtolower($route);
        $this->route_class = $this->getRouteClass($weimobObj);

        $mets = get_class_methods($this->route_class);
        if (empty($mets)) {
            throw new \InvalidArgumentException('Class "' . $this->route . '" does not exist.');
        }


        // add methods to this object per method, except root
        foreach ($mets as $mtd) {
            if ($mtd === 'root') {
                continue;
            }
            $mtdFunc = function (
                array $params = [ ],
                array $sentargs = [ ]
            ) use (
                $mtd,
                $weimobObj
            ) {
                $interface = call_user_func($this->route_class . '::' . $mtd);
                // TODO: validate params and sentargs against definitions
                $caller = new Caller($weimobObj);
                return $caller->callEndpoint($interface, $params, $sentargs);
            };
            $this->methods[$mtd] = \Closure::bind($mtdFunc, $this, get_class());
        }
    }


    private function getAllRoutes($weimobObj)
    {
        return array_merge(static::$ROUTES, array_keys($weimobObj->custom_routes));
    }

    private function getRouteClass($weimobObj)
    {
        if (isset($weimobObj->custom_routes[$this->route])) {
            return $weimobObj->custom_routes[$this->route];
        }

        return 'Kiduc\\Weimob\\Routes\\' . ucwords($this->route);
    }
}
