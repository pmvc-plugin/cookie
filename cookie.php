<?php

namespace PMVC\PlugIn\cookie;

use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cookie';

class cookie extends PlugIn
{

    public function init()
    {
        $this['params'] = array_replace(
            $this->_defaultCookie(),
            \PMVC\toArray($this['params']) 
        );
    }

    public function set($k, $v, array $cParams=[])
    {
        $cParams = array_replace(
            \PMVC\toArray($this['params']),
            $cParams
        );
        setcookie(
            $k,
            $v,
            time()+$cParams['lifetime'],
            $cParams['path'],
            $cParams['domain'],
            $cParams['secure'],
            $cParams['httponly']
        );
    }

    public function get($k, $default = null)
    {
        return \PMVC\get($_COOKIE, $k, $default);
    }

    private function _defaultCookie()
    {
        return [
            'lifetime'=>86400*7,
            'path'=>'/',
            'domain'=>null,
            'secure'=>false,
            'httponly'=>true
        ];
    }
}
