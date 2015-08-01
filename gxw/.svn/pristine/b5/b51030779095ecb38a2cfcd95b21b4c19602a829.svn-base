<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//date_default_timezone_set (PRC);
@ini_set('date.timezone','Asia/Shanghai'); 
@Extension_Loaded('zlib')?ob_start('ob_gzhandler'):ob_start();
ob_implicit_flush(1);
if(function_exists(session_cache_limiter))session_cache_limiter('private, must-revalidate');
session_start();
set_magic_quotes_runtime(0);

define('IN_ONEZ', TRUE);
define('ONEZ_ROOT', substr(dirname(__FILE__), 0, -7));
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}
require_once ONEZ_ROOT.'./include/global.func.php';
require_once ONEZ_ROOT.'./include/cache.func.php';
$magic_quotes_gpc = @get_magic_quotes_gpc();
if($magic_quotes_gpc) {
  $_POST = ostripslashes($_POST);
  $_GET = ostripslashes($_GET);
}

require_once ONEZ_ROOT.'./config.inc.php';
include_once ONEZ_ROOT.'./onezdata/setting.php';
file_exists(ONEZ_ROOT.'./api/code/'.$apitype.'.php') || exit('接口未设置');
include_once ONEZ_ROOT.'./api/code/discuz.php';
if(($apitype=='discuz' || $apitype=='ucenter') && !defined('UC_API')){
  exit('使用Discuz或UCenter整合需设置配置信息（config.inc.php文件中修改）');
}

header('Content-Type: text/html; charset=gbk');


$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$SCRIPT_FILENAME = str_replace('\\\\', '/', ($_SERVER['PATH_TRANSLATED'] ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME']));

if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	$onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	$onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	$onlineip = getenv('REMOTE_ADDR');
} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	$onlineip = $_SERVER['REMOTE_ADDR'];
}
$onlineip = preg_replace("/^([\d\.]+).*/", "\\1", $onlineip);
$time=time()+$timezone*60*60;
$now=date("Y-m-d H:i:s",$time);
$homepage=$setting['homepage'];

!$setting['sec_update'] && $setting['sec_update']=2;
!$setting['sec_update2'] && $setting['sec_update2']=2;
!$setting['sec_online'] && $setting['sec_online']=20;
!$setting['sec_list'] && $setting['sec_list']=20;
!$setting['sec_msg'] && $setting['sec_msg']=60;
!$setting['ViewUserUrl'] && $setting['ViewUserUrl']=$ViewUserUrl;
!$setting['regurl'] && $setting['regurl']=$regurl;
!$setting['apiurl'] && $setting['apiurl']=$apiurl;
!$setting['theme'] && $setting['theme']=$skin;
?>