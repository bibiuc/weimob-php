<?php


namespace Kiduc\Weimob\Routes;


use Kiduc\Weimob\Contracts\RouteInterface;

class Member implements RouteInterface
{

    public static function root()
    {
        return RouteInterface::WEIMOB_API_ROOT;
    }

    public static function getMemberList()
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

    public static function addMemberPointAmount()
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

    public static function removeMemberPointAmount()
    {

        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Member::root().'/mc/member/useMemberPointAmountOffLine',
            RouteInterface::PARAMS_KEY => [
                RouteInterface::ID,
                'amount',
                'point',
                'reason',
                'storeId',
                'channelType',
                'attachId',
                'requestId',
                'mid'
            ]
        ];
    }
}
