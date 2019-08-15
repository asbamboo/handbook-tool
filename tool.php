<?php
session_start();

/**
 * 入口
 * @var Ambiguous $GLOBALS
 */
$GLOBALS['ENTRANCE']    = 'tool.php';

/**
 * config 文件示例
 * - <?php 
 *    return [
 *        'HANDBOOK_ROOT'       => __DIR__ . '/handbook', // 手册存放目录
 *        'HANDBOOK_LOGO'       => __DIR__ . '/handbook/image/logo.png', // logo图片, 可以不设置
 *        'HANDBOOK_TITLE'      => '文档中心', // 文档标题
 *        'HANDBOOK_SECRET_KEY' => '1213', //文档修改秘钥
 *    ];
 * 
 * @var array $CONFIG
 */
$GLOBALS['CONFIG']  = include __DIR__ . '/config.php';

/*
 * 如果手册目录不存在，那么先创建它
 */
if(!is_dir($GLOBALS['CONFIG']['HANDBOOK_ROOT'])){
    @mkdir($GLOBALS['CONFIG']['HANDBOOK_ROOT'], 0755, true);
}

/**
 * 如果设置了logo，那么先把logo复制到相应的位置。
 */
if(isset($GLOBALS['CONFIG']['HANDBOOK_LOGO']) && !file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/logo.png')){
    copy($GLOBALS['CONFIG']['HANDBOOK_LOGO'], $GLOBALS['CONFIG']['HANDBOOK_ROOT'] . '/image/logo.png');
    symlink($GLOBALS['CONFIG']['HANDBOOK_ROOT'] . '/image', $_SERVER['DOCUMENT_ROOT'] . '/image');
}

/**
 * 如果手册首页未初始化，那么先创建它
 */
if(!file_exists($handbook_index_html = rtrim($GLOBALS['CONFIG']['HANDBOOK_ROOT'], '/') . '/index.html')){
    ob_start();
    include __DIR__ . '/template/index.html';
    $handbook_index_content  = ob_get_contents();
    ob_end_clean();
    file_put_contents($handbook_index_html, $handbook_index_content);
}
    
if($_GET['type'] == "key.check"){
    $key    = file_get_contents('php://input');
    if($key == $GLOBALS['CONFIG']['HANDBOOK_SECRET_KEY']){
        $_SESSION['secret_checked'] = true;
        exit('SUCCESS');
    }else{
        exit('OUT');
    }
}else if(empty($_SESSION['secret_checked'])){
    exit('OUT');
}

if(!empty($_GET['type'])){    
    $type   = str_replace('.', '/', $_GET['type']);
    include __DIR__ . '/' . $type . '.php';
}

return;