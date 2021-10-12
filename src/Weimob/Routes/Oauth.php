<?php
namespace Kiduc\Weimob\Routes;

use Kiduc\Weimob\Contracts\RouteInterface;

class Oauth implements RouteInterface
{

    public static function root()
    {
        return self::WEIMOB_AUTH_API_ROOT;
    }

    public static function authorize() {
        return [
            RouteInterface::NOT_NEED_TOKEN_KEY => true,
            RouteInterface::METHOD_KEY => RouteInterface::GET_METHOD,
            RouteInterface::ENDPOINT_KEY => Oauth::root().'/authorize',
            RouteInterface::IS_REDIRECT => true,
            RouteInterface::PARAMS_KEY => [
                'enter', // vm
                'view', // pc
                'response_type', // code
                'scope', //default
                'client_id', //
                'redirect_uri'
            ],
            RouteInterface::REQUIRED_KEY => [
                'enter', // vm
                'view', // pc
                'response_type', // code
                'scope', //default
                'client_id', //
                'redirect_uri'
            ]
        ];
    }

    public static function token() {
        return [
            RouteInterface::NOT_NEED_TOKEN_KEY => true,
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Oauth::root().'/token',
            RouteInterface::PARAMS_KEY => [
                'code',
                'refresh_token',
                'client_id',
                'client_secret',
                'grant_type', // refresh_token | authorization_code
                'redirect_uri' // no required
            ]
        ];
    }
}
