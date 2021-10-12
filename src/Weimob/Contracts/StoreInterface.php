<?php


namespace Kiduc\Weimob\Contracts;


interface StoreInterface
{
    public function setAccessToken(string $access_token);

    public function setRefreshToken(string $refresh_token);

    public function getAccessToken();

    public function getRefreshToken();
}
