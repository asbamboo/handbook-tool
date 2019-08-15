<?php 

if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }

$page   = file_get_contents("php://input");

$page       = htmlspecialchars($page);
$filename   = rtrim($GLOBALS['CONFIG']['HANDBOOK_ROOT'], '/')  . '/' . $page;

if(file_exists($filename)){
    unlink($filename);
}

exit("SUCCESS");