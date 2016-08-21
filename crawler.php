<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'absolutepath.php';
require_once 'mysqltable.php';

ini_set('max_execution_time', 900);
//var_dump(libxml_use_internal_errors(true));
/*
if (isset($_POST['url']))
{
    ShowAllTegAHref($_POST['url']);
} 


*/

function crawle_site($url)
{
    $host = parse_url($url, PHP_URL_HOST);
    if (!$host)
    {
        return FALSE;
    }
    
    $allRefs = array($host);
    $ch = init_curl();
    for ($currentUrlNum = 0; $currentUrlNum < count($allRefs); ++$currentUrlNum)
    {
        crawle_page($ch, $allRefs, $refs[$currentUrlNum]);
    }
    curl_close($ch);
}

function crawle_page(&$ch, &$links, $cur)
{
    $data = get_data($ch, $cur);
    $arr = get_all_hyperlinks($data);
    echo_links_into_table($arr);
}

function get_data(&$ch, $url)
{
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	return $data;
}

function get_all_hyperlinks($doc)
{
    $arr = null;
    /*preg_match_all("/<a.+?href\=\"(.*?)\".*?>/", $doc, $arr, PREG_PATTERN_ORDER);*/
    preg_match_all("/<a.+?href\=\"(.*?)\".*?>/", $doc, $arr, PREG_PATTERN_ORDER);
    return $arr[1];
}

function echo_links_into_table(&$arr)
{
    echo '<table><tr><th align="left">ID</th><th align="left">URL</th></tr>';
    $j = 0;
    foreach ($arr as $row)
    {
        echo '<tr><td>'.++$j.'</td><td><a href=\"'.$row.'>'.$row.'</a><td></tr>';
    }
    echo '</table>';
}

function add_url(&$links, $url)
{
    if (!in_array($url, $links))
    {
        $links[] = $url;
    }
    
    /*
    foreach ($links as $cur)
    {
        if (get_url_host_and_path($cur) == get_url_host_and_path($url))
        {
           break; 
        }
    }
    $links[] = $url;
    */
}

function init_curl()
{
    $ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    return $ch;
}

function is_this_site($main, $url)
{
    $urlHost = parse_url($url, PHP_URL_HOST);
    return !$urlHost || $urlHost == parse_url($main, PHP_URL_HOST);
}

?>