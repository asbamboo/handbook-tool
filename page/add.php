<?php 
if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }

$page   = file_get_contents("php://input");

$filename   = rtrim($GLOBALS['CONFIG']['HANDBOOK_ROOT'], '/')  . '/' . $page;

if(!file_exists($filename)){
    file_put_contents($filename, '文档待编辑');
}

exit("SUCCESS");