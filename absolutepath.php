<?php

/**
 * @author admin
 * @copyright 2016
 */
 
function delete_query_and_mark($url)
{
    $url = parse_url($url);
    return (isset($url['scheme']) ? $url['scheme'].'://' : '').
           (isset($url['host']) ? $url['host'] : '').
           (isset($url['path']) ? $url['path'] : '');
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
    $level = count($arr) - 1;//��������� ��������
    $ref = $arr[$level];//��������� �����
    $level = (!$level && pathinfo($cur, PATHINFO_EXTENSION)) ? 1 : $level;
    $cur = implode('/', explode('/', $cur, -$level));//������� � ������ �����
    return $cur.'/'.$ref;
}

?>