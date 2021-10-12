<?php


namespace Kiduc\Weimob\Helpers;

use Kiduc\Weimob\Http\RequestBuilder;
use Kiduc\Weimob\Routes\Oauth;

class Caller
{
    private $weimobObj;

    public function __construct($weimobObj)
    {
        $this->weimobObj = $weimobObj;
    }

    public function callEndpoint($interface, $payload = [ ], $sentargs = [ ])
    {
        $builder = new RequestBuilder($this->weimobObj, $interface, $payload, $sentargs);
        $request = $builder->build();
        if ($builder->isRedirect()) {
            return $request->endpoint;
        }
        if ($builder->isNeedOauth()) {
            if ($request->isRefreshTokenExpired()) {

                exit;
            }
            if ($request->isAccessTokenExpired()) {

            }
        }
        return $request->send()->wrapUp();
    }
}
