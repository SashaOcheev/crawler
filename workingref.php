<?php

/**
 * @author admin
 * @copyright 2016
 */

//function CrawleSite($url)

function CrawlePage($cur, $main)
{
    $dom = new DOMDocument;
    $dom->loadHTML(file_get_contents($cur));
    $arr = array();
    foreach ($dom->getElementsByTagName('a') as $node)
    {
        $ref = $node->getAttribute("href");
        if (IsThisSite($main, $ref))
        {
            $arr[] = MakeWorkingRef($cur, $ref, $main);
        }
    }
    return $arr;
}

function MakeWorkingRef($cur, $ref, $main)
{
    if (substr($cur, 0, strlen('http://')) != 'http://' &&
        substr($cur, 0, strlen('https://')) != 'https://')
    {
        return FALSE;
    }
    
    $ref = CleanRef($ref);
    $main = CleanRef($main);
    $cur = CleanRef($cur);
    
    return MakeAbsolute($cur, $ref, $main);
}

function CleanRef($ref)
{
    return rtrim(DelGetQuery(MakeExternal($ref)), '/');
}

function MakeExternal($ref)
{
    $pos = strrpos($ref, '#');
    $pos = ($pos === FALSE) ? strlen($ref) : $pos;
    return substr($ref, 0, $pos);
}

function DelGetQuery($ref)
{
    $pos = strpos($ref, '?');
    $pos = ($pos === FALSE) ? strlen($ref) : $pos;
    return substr($ref, 0, $pos);
}

function MakeAbsolute($cur, $ref, $main = '')
{
    $cur = rtrim($cur, '/');
    $ref = rtrim($ref, '/');
    if ($main == '')
    {
        $main = GetMainAddress($cur);
    }
    
    if (substr($ref, 0, strlen('http://')) == 'http://' ||
        substr($ref, 0, strlen('https://')) == 'https://')
    {
        return $ref;
    }
    
    if (substr($ref, 0, 1) == '/')
    {
        return $main.$ref;
    }
     
    return GetAbsolutePathRelativilyCurrentDir($cur, $ref);
}

function GetMainAddress($ref)
{
    $path = strlen(explode('/', $ref, 4)[3]);
    return substr($ref, 0, strlen($ref) - $path - 1);
}

function GetAbsolutePathRelativilyCurrentDir($cur, $ref)
{
    $arr = explode("../", $ref);
    $level = count($arr) - 1;//количесво надпапок
    $ref = $arr[$level];//последн€€ часть
    $cur = implode('/', explode('/', $cur, -$level));//возврат к нужной папке
    return $cur.'/'.$ref;
}

function IsThisSite($main, $ref)
{
    $isThis = substr($ref, 0, strlen('http://')) != 'http://' &&
              substr($ref, 0, strlen('https://')) != 'https://';
    $main = str_replace('https://', '', $main);
    $main = str_replace('http://', '', $main);
    return $isThis || stristr($ref, $main);
}
?>