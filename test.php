<?php

/**
 * @author admin
 * @copyright 2016
 */

require_once 'crawler.php';

//crawle_site('http://arcadefire.com/site/');
//crawle_site('http://airwar.ru/');
//crawle_site('http://interpolnyc.com/');
/*
$ch = init_curl();
$links = null;
crawle_page($ch, $links, 'http://airwar.ru/');
curl_close($ch);
*/
/*
require_once 'absolutepath.php';

echo 'get_absolute_path()<br>';
echo '1 '.(get_absolute_path('http://1/2/3/4/5/6', 'http://0') == 'http://0').'<br>';
echo '2 '.(get_absolute_path('http://1/2/3/4/5/6', '/0') == 'http://1/0').'<br>';
echo '3 '.(get_absolute_path('http://1/2/3/4/5/6', '/0/1') == 'http://1/0/1').'<br>';
echo '4 '.(get_absolute_path('http://1/2/3/4/5/6', '0/1') == 'http://1/2/3/4/5/6/0/1').'<br>';
echo '4.5 '.(get_absolute_path('http://1/2/3/4/5/6.html', '0/1') == 'http://1/2/3/4/5/0/1').'<br>';
echo '5 '.(get_absolute_path('http://1/2/3/4/5/6', '../0') == 'http://1/2/3/4/5/0').'<br>';
echo '6 '.(get_absolute_path('http://1/2/3/4/5/6', '../../0/1') == 'http://1/2/3/4/0/1').'<br>';
echo '7 '.(get_absolute_path('http://1/2/3/4/5/6', '../../') == 'http://1/2/3/4').'<br>';
echo '<br>';

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

echo '<br>'.'Crawl Page'.'<br>';
$arr = explode('/', 'http://aracdefire.com', 4);
echo count($arr);
CrawleSite('http://arcadefire.com/');


print_r(parse_url('http://arcadefire.com/'));
echo "<br>";
print_r(parse_url('arcadefire.com/'));
echo "<br>";
print_r(parse_url('www.arcadefire.com'));
*/
?>