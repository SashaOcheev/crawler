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

function ShowAllTegAHref($url)
{
    $main = GetMainAddress($url);
    $table = new SQLTable($main);
    
    CrawlePage($main, $main, $table);
    $table->SetResult();
    echo '<table><tr><th>ID</th><th>URL</th></tr>';
    for ($j = 0; $row = $table->GetRow($j); ++$j)
    {
        echo "<tr><td>$row[0]</td><td><a href=\"$row[1]\">$row[1]</a><td></tr>";
    }
    echo '</table>';
}

function CrawlePage($cur, $main, &$table)
{
    $dom = new DOMDocument;
    $dom->loadHTML(file_get_contents($cur)); //multi-curl
    foreach ($dom->getElementsByTagName('a') as $node)
    {
        $ref = $node->getAttribute("href");
        if (IsThisSite($main, $ref))
        {
            $ref = MakeWorkingRef($cur, $ref, $main);
            if ($table->AddPage($ref))
            {
                CrawlePage($ref, $main, $table); 
            }
        }
    }
}
*/
function crawle_site($url)
{
    $host = parse_url($url, PHP_URL_HOST).'/';
    if (!$host)
    {
        return FALSE;
    }
    
    $allRefs = array($host);
    for ($currentUrlNum = 0; $currentUrlNum < count($allRefs); ++$currentUrlNum)
    {
        crawle_page($allRefs, $$refs[$currentUrlNum]);
    }
}

function crawle_page(&$links, $main, $cur)
{
    
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

function is_this_site($main, $url)
{
    $urlHost = parse_url($url, PHP_URL_HOST);
    return !$urlHost || $urlHost == parse_url($main, PHP_URL_HOST);
}
?>