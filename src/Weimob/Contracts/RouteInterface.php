<?php
namespace Kiduc\Weimob\Contracts;

interface RouteInterface
{
    const ID = 'wid';
    const METHOD_KEY = 'method';
    const ENDPOINT_KEY = 'endpoint';
    const PARAMS_KEY = 'params';
    const ARGS_KEY = 'args';
    const NOT_NEED_TOKEN_KEY = 'without_token';
    const REQUIRED_KEY = 'required';
    const POST_METHOD = 'post';
    const PUT_METHOD = 'put';
    const GET_METHOD = 'get';
    const IS_REDIRECT = 'is_redirect';

    public static function root();

    const WEIMOB_API_ROOT = 'https://dopen.weimob.com/api/1_0';
    const WEIMOB_AUTH_API_ROOT = 'https://dopen.weimob.com/fuwu/b/oauth2';
    const ACCESS_TOKEN_KEY = 'accesstoken';
}
