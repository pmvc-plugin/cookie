<?php
namespace PMVC\PlugIn\cookie;

use PHPUnit_Framework_TestCase;

class CookieTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'cookie';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    public function testSetCookie()
    {
        $plug = \PMVC\plug($this->_plug);
        $plug->set('foo', 'bar', [], function(){
            $arr = func_get_args();
            $this->assertEquals('foo', $arr[0], 'key');
            $this->assertEquals('bar', $arr[1], 'value');
            $this->assertTrue(is_numeric($arr[2]), 'time');
            $this->assertEquals('/', $arr[3], 'path');
            $this->assertNull($arr[4], 'domain');
            $this->assertFalse($arr[5], 'secure');
            $this->assertTrue($arr[6], 'httponly');
        });
    }

    public function testGetCookie()
    {
        $key = 'foo';
        $val = 'bar';
        $_COOKIE = [$key=>$val];
        $plug = \PMVC\plug($this->_plug);
        $actual = $plug->get($key);
        $this->assertEquals($val, $actual);
    }
}
