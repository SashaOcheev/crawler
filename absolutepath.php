<?php

/**
 * @author admin
 * @copyright 2016
 */
 
function get_url_host_and_path($url)
{
    return parse_url($url, PHP_URL_HOST).parse_url($url, PHP_URL_PATH);
}
 
function get_absolute_path($cur, $url)
{   
    $parsed_url = parse_url($url);   
    if (isset($parsed_url['host']))
    {
        return $url;
    }
    
    $parsed_cur = parse_url($cur);
    if ($url[0] == '/')
    {
        return $parsed_cur['scheme'].'://'.$parsed_cur['host'].$url;
    }
    
    return rtrim(get_abs_path_relativily_cur_dir($cur, $url), '/');  
}

function get_abs_path_relativily_cur_dir($cur, $ref)
{
    $arr = explode("../", $ref);
    $level = count($arr) - 1;//количесво надпапок
    $ref = $arr[$level];//последн€€ часть
    $level = (!$level && pathinfo($cur, PATHINFO_EXTENSION)) ? 1 : $level;
    $cur = implode('/', explode('/', $cur, -$level));//возврат к нужной папке
    return $cur.'/'.$ref;
}

?>