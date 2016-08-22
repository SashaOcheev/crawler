<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'absolutepath.php';
require_once 'mysqltable.php';

ini_set('max_execution_time', 900);

if (isset($_POST['url']))
{
    crawle_site($_POST['url']);
}


function crawle_site($url)
{
    $url = rtrim($url, '/');
    $setRefs = array($url => NULL);
    $arrRefs = array($url);
    $ch = init_curl();
    $host = parse_url($url, PHP_URL_HOST);
    echo '<table><tr><th align="left">ID</th><th align="left">URL</th></tr>';///////////
    for ($currentUrlNum = 0, $count = 1; $currentUrlNum < $count; ++$currentUrlNum)
    {
        $cur = $arrRefs[$currentUrlNum];
        echo '<tr><td>'.$currentUrlNum.'</td><td><a href="'.$cur.'">'.$cur.'</a><td></tr>';
        if (!is_this_site($host, $cur))
        {
            continue;
        }
        $arr = crawle_page($ch, $cur);
        foreach ($arr as $url)
        {
            if ($url = can_add_url($setRefs, $cur, $url))
            {
                ++$count;
                $setRefs[$url] = NULL;
                $arrRefs[] = $url;
            }
        }
    }
    curl_close($ch);
    echo '</table>';//echo_links_into_table($arrRefs);
    record_in_db('site', $arrRefs);
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

function crawle_page(&$ch, $cur)
{
    $data = get_data($ch, $cur);
    return get_all_hyperlinks($data);
}

function get_data(&$ch, $url)
{
	curl_setopt($ch, CURLOPT_URL, $url);
	return curl_exec($ch);
}

function get_all_hyperlinks(&$doc)
{
    $arr = null;
    preg_match_all("/<a.+?href\=\"(.*?)\".*?>/", $doc, $arr, PREG_PATTERN_ORDER);
    return $arr[1];
}

function can_add_url(&$setRefs, $cur, $url)
{
    $url = delete_query_and_mark($url);
    if (!$url)
    {
        return FALSE;
    }
    $url = get_absolute_path($cur, $url);
    if (array_key_exists($url, $setRefs))
    {
        return FALSE;
    }
    return $url;
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

?>