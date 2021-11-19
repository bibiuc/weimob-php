<?php
namespace Kiduc\Weimob\Tests;

use PHPUnit\Framework\TestCase;
use Kiduc\Weimob;
use Kiduc\Weimob\Helpers\Router;
use Kiduc\Weimob\Exception\ValidationException;

class WeimobTest extends TestCase
{
    public function testInitializeWithInvalidSecretKey() {
        $this->expectException(\InvalidArgumentException::class);
        $w = new  Weimob(null, null);
    }

    public function testVersion()
    {
        $this->assertEquals("0.0.3", Weimob::VERSION);
    }

    public function testGetShouldBringRouter()
    {
        $w = new  Weimob('i', 's');
        $this->assertInstanceOf(Router::class, $w->oauth);
        $this->expectException(ValidationException::class);
        $this->assertNull($w->nonexistent);
    }
}
