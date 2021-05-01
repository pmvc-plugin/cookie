<?php
namespace PMVC\PlugIn\cookie;

use PMVC\TestCase;

class CookieTest extends TestCase
{
    private $_plug = 'cookie';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
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

    public function testParseCookieString()
    {
        $s = '_ga=GA1.3.1214179492.1522211047; _gid=GA1.3.434314545.1522211047; JSESSIONID=0000OxWmIsqfMNlX13LoHEWmWES:19tmdfpi3';
        $plug = \PMVC\plug($this->_plug);
        $actual = $plug->parseCookieString($s);
        $expected = [
            '_ga'=>'_ga=GA1.3.1214179492.1522211047',
            '_gid'=>'_gid=GA1.3.434314545.1522211047',
            'JSESSIONID'=>'JSESSIONID=0000OxWmIsqfMNlX13LoHEWmWES:19tmdfpi3' 
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testParseSetCookieString()
    {
        $s ='JSESSIONID=00005bELXYn2wZ_r60PccMfB5uZ:19tmdfpi3; Path=/; HttpOnly';
        $plug = \PMVC\plug($this->_plug);
        $actual = $plug->parseSetCookieString($s);
        $expected = [
            'JSESSIONID' => 'JSESSIONID=00005bELXYn2wZ_r60PccMfB5uZ:19tmdfpi3'
        ];
        $this->assertEquals($expected, $actual);
    }
}
