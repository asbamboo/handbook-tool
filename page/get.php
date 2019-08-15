<?php
if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }

if(!empty( $_GET['page'] )){
    $html   = rtrim( $GLOBALS['CONFIG']['HANDBOOK_ROOT'] , '/') . '/' . $_GET['page'];
    
    if(!file_exists($html)){
        $html   = rtrim( $GLOBALS['CONFIG']['HANDBOOK_ROOT'] , '/') . '/' . $_GET['page'] . '.html';
    }
    
    if(!file_exists($html)){
        $html   = dirname(__DIR__ ). "/template/{$_GET['page']}.html";
    }
    
    exit(include $html);
}