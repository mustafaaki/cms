<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('myurl'))
{
    function adminbase($url,$slash=true)
    {	
        if($slash)
    	return base_url(managepath.'/'.$url);
        else 
        return base_url(managepath.$url);
    }  
    function alink($href,$text,$title="",$arr=""){
        if($title!=""){
            $title=' title="'.$title.'"';
        }
        if($arr!=""){
            foreach($arr as $x=>$y){
                $att.= ' '.$x.'="'.$y.'"';
            }
        }
        $var= '<a href="'.$href.'"'.$title.$att.'>'.$text.'</a>'; 
        return $var;
    }
    
    function lngfix($url,$lng){
        if(multi_language){
            $url = $lng.'/'.$url;
        }
        return $url;
    }
}



