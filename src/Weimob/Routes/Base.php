<?php


namespace Kiduc\Weimob\Routes;


use Kiduc\Weimob\Contracts\RouteInterface;

class Base implements RouteInterface
{

    public static function root()
    {
        return RouteInterface::WEIMOB_API_ROOT;
    }

    public static function getInfo()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Member::root().'/open/usercenter/getWeimobUserInfo',
            RouteInterface::PARAMS_KEY => [
                'accesstoken'
            ]
        ];
    }
}
