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
        $w = new  Weimob(null, null, null);
    }

    public function testVersion()
    {
        $this->assertEquals("0.0.2", Weimob::VERSION);
    }

    public function testGetShouldBringRouter()
    {
        $w = new  Weimob('i', 's',  null);
        $this->assertInstanceOf(Router::class, $w->oauth);
        $this->expectException(ValidationException::class);
        $this->assertNull($w->nonexistent);
    }
}
