<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'absolutepath.php';
require_once 'mysqltable.php';

ini_set('max_execution_time', 900);
/*
if (isset($_POST['url']))
{
    ShowAllTegAHref($_POST['url']);
} 


*/

function crawle_site($url)
{
    $url = rtrim($url, '/');
    $allRefs = array($url);
    $ch = init_curl();
    $host = parse_url($url, PHP_URL_HOST);
    for ($currentUrlNum = 0; $currentUrlNum < count($allRefs); ++$currentUrlNum)
    {
        $cur = $allRefs[$currentUrlNum];
        if (!is_this_site($host, $cur))
        {
            continue;
        }
        $arr = crawle_page($ch, $allRefs, $cur);
        foreach ($arr as $url)
        {
            add_url($allRefs, $cur, $url);
        }
    }
    curl_close($ch);
    echo_links_into_table($allRefs);
}

function crawle_page(&$ch, &$links, $cur)
{
    echo $cur.'<br>';
    $data = get_data($ch, $cur);
    return get_all_hyperlinks($data);
}

function get_data(&$ch, $url)
{
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	return $data;
}

function get_all_hyperlinks(&$doc)
{
    $arr = null;
    preg_match_all("/<a.+?href\=\"(.*?)\".*?>/", $doc, $arr, PREG_PATTERN_ORDER);
    return $arr[1];
}

function echo_links_into_table(&$arr)
{
    echo '<table><tr><th align="left">ID</th><th align="left">URL</th></tr>';
    $j = 0;
    foreach ($arr as $row)
    {
        echo '<tr><td>'.++$j.'</td><td><a href="'.$row.'">'.$row.'</a><td></tr>';
    }
    echo '</table>';
}

function add_url(&$links, $cur, $url)
{
    $url = delete_query_and_mark($url);
    if (!$url)
    {
        return ;
    }
    $url = get_absolute_path($cur, $url);
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

function is_this_site($host, $url)
{
    return parse_url($url, PHP_URL_HOST) == $host;
}

?>