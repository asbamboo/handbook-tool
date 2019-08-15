<?php
if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }

/**
 * 上传附件和上传视频
 * User: Jinqn
 * Date: 14-04-09
 * Time: 上午10:17
 */
include "Uploader.class.php";

$HANDBOOK_TOOL_CONFIG   = include dirname(dirname(__DIR__)) . '/config.php';

/* 上传配置 */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
        symlink($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'] . '/image', $_SERVER['DOCUMENT_ROOT'] . '/image');
        
        $config = array(
            "pathFormat" => rtrim($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'], '/') . '/image/' . ltrim($CONFIG['imagePathFormat'], '/'),
            "maxSize" => $CONFIG['imageMaxSize'],
            "allowFiles" => $CONFIG['imageAllowFiles']
        );
        $fieldName = $CONFIG['imageFieldName'];
        
        break;
    case 'uploadscrawl':
        symlink($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'] . '/image', $_SERVER['DOCUMENT_ROOT'] . '/image');
        $config = array(
            "pathFormat" => rtrim($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'], '/') . '/image/' . ltrim($CONFIG['scrawlPathFormat'], '/'),
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        symlink($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'] . '/video', $_SERVER['DOCUMENT_ROOT'] . '/video');
        $config = array(
            "pathFormat" => rtrim($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'], '/') . '/video/' . ltrim($CONFIG['videoPathFormat'], '/'),
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
    case 'uploadfile':
    default:
        symlink($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'] . '/file', $_SERVER['DOCUMENT_ROOT'] . '/file');
        $config = array(
            "pathFormat" => rtrim($HANDBOOK_TOOL_CONFIG['HANDBOOK_ROOT'], '/') . '/file/' . ltrim($CONFIG['filePathFormat'], '/'),
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
return json_encode($up->getFileInfo());
