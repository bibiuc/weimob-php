<?php


namespace Kiduc\Weimob\Routes;


use Kiduc\Weimob\Contracts\RouteInterface;

class Member implements RouteInterface
{

    public static function root()
    {
        return RouteInterface::WEIMOB_API_ROOT;
    }

    public function getMemberList()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Member::root().'/mc/member/getMemberList',
            RouteInterface::PARAMS_KEY => [
                'cursor',
                'size'
            ]
        ];
    }

    public function addMemberPointAmount()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Member::root().'/mc/member/addMemberPointAmount',
            RouteInterface::PARAMS_KEY => [
                RouteInterface::ID,
                'amount',
                'addAmountReason',
                'point',
                'addPointReason',
                'channelType',
                'storeId',
                'attachId',
                'requestId',
                'mid'
            ]
        ];
    }
}
