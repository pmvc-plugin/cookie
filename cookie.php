<?php

namespace PMVC\PlugIn\cookie;

use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cookie';

/**
 * Why not integrate with \PMVC\plug('get')?
 * Because cookie is one of type by user input, for prevent security issue.
 */
class cookie
    extends PlugIn
{

    public function init()
    {
        $this['params'] = array_replace(
            $this->_defaultCookie(),
            \PMVC\toArray($this['params']) 
        );
    }

    public function set(
        $k,
        $v,
        array $cParams=[],
        callable $func = null
    ) {
        $cParams = array_replace(
            \PMVC\toArray($this['params']),
            $cParams
        );
        if (is_null($func)) {
            $func = 'setcookie';
        }
        call_user_func(
            $func, 
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
