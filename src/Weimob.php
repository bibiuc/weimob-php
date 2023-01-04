<?php


namespace Kiduc;

use Kiduc\Weimob\Helpers\Router;
use Kiduc\Weimob\Contracts\RouteInterface;
use Kiduc\Weimob\Exception\ValidationException;

class Weimob
{
    public $client_id;
    public $client_secret;
    public $custom_routes = [];
    const VERSION = "0.0.9";

    public function __construct($client_id, $client_secret)
    {
        if (!is_string($client_id) || !is_string($client_secret)) {
            throw new \InvalidArgumentException('This Is Not A Valid Weimob Client Secret Key Or A Valid Weimob Client Id Key.');
        }
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }


    public function useRoutes(array $routes)
    {
        foreach ($routes as $route => $class) {
            if (!is_string($route)) {
                throw new \InvalidArgumentException(
                    'Custom routes should map to a route class'
                );
            }

            if (in_array($route, Router::$ROUTES)) {
                throw new \InvalidArgumentException(
                    $route . ' is already an existing defined route'
                );
            }

            if (!in_array(RouteInterface::class, class_implements($class))) {
                throw new \InvalidArgumentException(
                    'Custom route class ' . $class . 'should implement ' . RouteInterface::class
                );
            }
        }

        $this->custom_routes = $routes;
    }

    /**
     * @deprecated
     */
    public static function registerAutoloader()
    {
        trigger_error('Include "src/autoload.php" instead', E_DEPRECATED | E_USER_NOTICE);
        require_once(__DIR__ . '/../src/autoload.php');
    }

    public function __get($name)
    {
        return new Router($name, $this);
    }
}
