<?php
if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }

if(!empty( $_GET['page'] )){
    $document   = file_get_contents("php://input");
    $document   = preg_replace('@<button[^>]*>[^<]*</button>@siU', '', $document);
    
    if($_GET['page'] == 'menu.html'){
        $document   = preg_replace_callback('@(<a[^>]*href=")([^"]*)("[^>]*>[^<]*</a>)@siU', function($matches){
            $handbook_page  = $matches[2];
            if(strpos($handbook_page, '://') === false){
                $p              = parse_url(htmlspecialchars_decode($handbook_page), PHP_URL_QUERY);
                $query          = ['page' => $handbook_page];
                parse_str($p, $query);
                $handbook_page  = $query['page'];
            }
            $filename   = rtrim($GLOBALS['CONFIG']['HANDBOOK_ROOT'], '/')  . '/' . $handbook_page;
            if(!file_exists($filename)){
                file_put_contents($filename, '文档待编辑');
            }
            return  $matches[1] . $handbook_page . $matches[3];
        }, $document);
        
        $document = preg_replace('@(class="[^"]*)active([^"]*")@siU', "$1$2", $document);
    }
    
    $filename   = rtrim($GLOBALS['CONFIG']['HANDBOOK_ROOT'], '/')  . '/' . $_GET['page'];
    file_put_contents($filename, $document);
    exit("SUCCESS");
}