<?php

/**
 * @author admin
 * @copyright 2016
 */

require_once 'workingref.php';

echo 'MakeAbsolute()<br>';
echo '1 '.(MakeAbsolute('http://1/2/3/4/5/6', 'http://0') == 'http://0').'<br>';
echo '2 '.(MakeAbsolute('http://1/2/3/4/5/6', '/0') == 'http://1/0').'<br>';
echo '3 '.(MakeAbsolute('http://1/2/3/4/5/6', '/0/1') == 'http://1/0/1').'<br>';
echo '4 '.(MakeAbsolute('http://1/2/3/4/5/6', '0/1') == 'http://1/2/3/4/5/6/0/1').'<br>';
echo '5 '.(MakeAbsolute('http://1/2/3/4/5/6', '../0') == 'http://1/2/3/4/5/0').'<br>';
echo '6 '.(MakeAbsolute('http://1/2/3/4/5/6', '../../0/1') == 'http://1/2/3/4/0/1').'<br>';
echo '<br>';

echo 'IsThisSite()'.'<br>';
echo '1 '.IsThisSite('http://main.ru', '123').'<br>';
echo '2 '.IsThisSite('http://main.ru', '/123').'<br>';
echo '3 '.IsThisSite('http://main.ru', '../123').'<br>';
echo '4 '.IsThisSite('http://main.ru', 'http://main.ru/1').'<br>';
echo '5 '.(!IsThisSite('http://main.ru', 'http://maisdf')).'<br>';
echo '<br>';

echo '<br>'.'Crawl Page'.'<br>';
$main = 'http://arcadefire.com/';
$cur = 'http://arcadefire.com/';
$res = CrawlePage($cur, $main);
foreach ($res as $ref)
{
    echo "<a href='$ref'>$ref</a><br>";
}
?>