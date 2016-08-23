<?php

/**
 * @author admin
 * @copyright 2016
 */
 
function delete_mark($url)
{
    /*$pos = strpos($url, '#');
    $pos = ($pos) ? $pos - 1 : strlen($url);*/
    $url = parse_url($url);
    return (isset($url['scheme']) ? $url['scheme'].'://' : '').
           (isset($url['host']) ? $url['host'] : '').
           (isset($url['path']) ? $url['path'] : '').
           (isset($url['query']) ? '?'.$url['query'] : '');
    //return substr($url, 0, $pos);
}
 
function get_absolute_path($cur, $url)
{   
    $parsed_url = parse_url($url);   
    if (isset($parsed_url['host']))
    {
        return rtrim($url, '/');
    }
    
    $parsed_cur = parse_url($cur);
    if ($url[0] == '/')
    {
        return rtrim($parsed_cur['scheme'].'://'.$parsed_cur['host'].$url, '/');
    }
    
    return rtrim(get_abs_path_relativily_cur_dir($cur, $url), '/');  
}

function get_abs_path_relativily_cur_dir($cur, $ref)
{
    $arr = explode("../", $ref);
    $level = count($arr) - 1;//количесво надпапок
    $ref = $arr[$level];//последн€€ часть
    $curPath = parse_url($cur, PHP_URL_PATH);
    $level = (!$level && pathinfo($curPath, PATHINFO_EXTENSION) && strlen($curPath) > 1)
             ? 1 : $level;
    $cur = implode('/', explode('/', $cur, -$level));//возврат к нужной папке
    return $cur.'/'.$ref;
}

?>