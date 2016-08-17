<?php

/**
 * @author admin
 * @copyright 2016
 */
require_once 'workingref.php';

ini_set('max_execution_time', 900);
//var_dump(libxml_use_internal_errors(true));

if ($_POST)
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

?>