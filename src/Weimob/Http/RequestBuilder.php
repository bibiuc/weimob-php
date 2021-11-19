<?php


namespace Kiduc\Weimob\Http;


use Kiduc\Weimob\Contracts\RouteInterface;

class RequestBuilder
{
    protected $weimobObj;
    protected $interface;
    protected $request;

    public $payload = [ ];
    public $sentargs = [ ];

    public function __construct($weimobObj, $interface, array $payload = [ ], array $sentargs = [ ])
    {
        $this->request = new Request($weimobObj);
        $this->weimobObj = $weimobObj;
        $this->interface = $interface;
        $this->payload = $payload;
        $this->sentargs = $sentargs;
    }

    public function isRedirect()
    {
        return isset($this->interface[RouteInterface::IS_REDIRECT]) ? $this->interface[RouteInterface::IS_REDIRECT] : false;
    }

    public function isNeedOauth()
    {
        return !(isset($this->interface[RouteInterface::NOT_NEED_TOKEN_KEY]) ? $this->interface[RouteInterface::NOT_NEED_TOKEN_KEY] : false);
    }

    public function build()
    {
        $this->request->endpoint = $this->interface[RouteInterface::ENDPOINT_KEY];
        $this->request->method = $this->interface[RouteInterface::METHOD_KEY];
        $this->moveRootToPayload();
        $this->moveArgsToSentargs();
        $this->putArgsIntoEndpoint($this->request->endpoint);
        $this->packagePayload();
        return $this->request;
    }

    public function packagePayload()
    {
        if (is_array($this->payload) && count($this->payload)) {
            $this->request->endpoint = $this->request->endpoint . '?' . $this->httpBuildQuery($this->payload);
            if ($this->request->method !== RouteInterface::GET_METHOD) {
                $this->request->body = $this->getBody();
            }
        }
    }

    public function getBody()
    {
        $payload = json_decode(json_encode($this->payload), true);
        if (isset($payload['accesstoken'])) {
            unset($payload['accesstoken']);
        }
        return json_encode($payload);
    }

    public function putArgsIntoEndpoint(&$endpoint)
    {
        foreach ($this->sentargs as $key => $value) {
            $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
        }
    }

    public function httpBuildQuery($payload)
    {
        $url = [];
        if ($this->isNeedOauth() && isset($payload['accesstoken']) && !empty($payload['accesstoken'])) {
            $url[] = 'accesstoken='.$payload['accesstoken'];
        }
        if ($this->request->method !== RouteInterface::GET_METHOD && !empty($url)) {
            return implode('&', $url);
        }
        if (!array_key_exists(RouteInterface::PARAMS_KEY, $this->interface) || empty($this->interface[RouteInterface::PARAMS_KEY])) {
            return implode('&', $url);
        }
        $keys = $this->interface[RouteInterface::PARAMS_KEY];
        foreach ($keys as $key) {
            if (isset($payload[$key]) && !empty($payload[$key])) {
                $url[]= $key.'='.$payload[$key];
            }
        }
        return implode('&', $url);
    }

    public function moveArgsToSentargs()
    {
        if (!array_key_exists(RouteInterface::ARGS_KEY, $this->interface)) {
            return;
        }
        $args = $this->interface[RouteInterface::ARGS_KEY];
        foreach ($this->payload as $key => $value) {
            if (in_array($key, $args)) {
                $this->sentargs[$key] = $value;
                unset($this->payload[$key]);
            }
        }
    }

    public function moveRootToPayload()
    {
        if (array_key_exists(RouteInterface::ARGS_KEY, $this->interface)) {
            $args = $this->interface[RouteInterface::ARGS_KEY];
        } else if (array_key_exists(RouteInterface::PARAMS_KEY, $this->interface)) {
            $args = $this->interface[RouteInterface::PARAMS_KEY];
        } else {
            return;
        }
        $config = $this->weimobObj;
        foreach ($args as $arg) {
            if (!isset($this->payload[$arg]) && isset($config->$arg)) {
                $this->payload[$arg] = $config->$arg;
            }
        }
    }
}
