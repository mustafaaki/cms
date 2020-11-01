<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('password'))
{
    function passEncrypt($var = '')
    {	
    	$var=sha1(base64_encode(md5(base64_encode($var))));
        return $var;
    }   
}



