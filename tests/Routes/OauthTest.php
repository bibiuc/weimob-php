<?php


namespace Kiduc\Weimob\Tests\Routes;


use Kiduc\Weimob;
use PHPUnit\Framework\TestCase;

class OauthTest extends TestCase
{
    public function testAuthorize()
    {
        $r = new Weimob('1', '1');
        $url = $r->oauth->authorize([
            'enter' => 'vm',
            'view' => 'pc',
            'response_type' => 'code',
            'scope' => 'default',
            'redirect_uri' => 'https://baidu.com'
        ]);
        $this->assertEquals('https://dopen.weimob.com/fuwu/b/oauth2/authorize?enter=vm&view=pc&response_type=code&scope=default&client_id=1&redirect_uri=https://baidu.com', $url);
    }
}
