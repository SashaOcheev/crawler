<?php

/**
 * @author admin
 * @copyright 2016
 */

if ($_POST)
{
    ShowAllTegAHref('url');
} 

function ShowAllTegAHref($postKey)
{
    $dom = new DOMDocument;
    $dom->loadHTML(file_get_contents($_POST[$postKey]));
    foreach ($dom->getElementsByTagName('a') as $node)
    {
        echo $node->nodeValue.': '.$node->getAttribute("href")."<br>";
    }
}

?>