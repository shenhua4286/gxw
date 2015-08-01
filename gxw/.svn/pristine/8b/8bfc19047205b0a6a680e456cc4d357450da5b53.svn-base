<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
@set_time_limit(1000);
header('Content-Type: text/html; charset=gbk');
set_magic_quotes_runtime(0);
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
}

define('IN_ONEZ', TRUE);
define('ONEZ_ROOT', '');

$installfile = basename(__FILE__);
$sqlfile = './install/onez.sql';
$lockfile = './install/install.lock';
$quit = FALSE;

@include './install/install.lang.php';
@include './install/global.func.php';
$magic_quotes_gpc = @get_magic_quotes_gpc();
if($magic_quotes_gpc) {
  $_POST = ostripslashes($_POST);
  $_GET = ostripslashes($_GET);
}
@include './config.inc.php';
@include './include/db_mysql.class.php';
$inslang = defined('INSTALL_LANG') ? INSTALL_LANG : '';
$version = @file_get_contents('version.txt').' '.$lang[$inslang];

if(!defined('INSTALL_LANG') || !function_exists('instmsg') || !is_readable($sqlfile)) {
	exit("安装软件必须上传所有文件");
} elseif(!isset($dbhost)) {
	instmsg('config_nonexistence');
} elseif(!ini_get('short_open_tag')) {
	instmsg('short_open_tag_invalid');
} elseif(file_exists($lockfile)) {
	instmsg('lock_exists');
}

if(function_exists('instheader')) {
	instheader();
}

if(empty($dbcharset) && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8'))) {
	$dbcharset = str_replace('-', '', $charset);
}

$action = $_POST['action'] ? $_POST['action'] : $_GET['action'];
$Attr=array("config.inc.php","onezdata");
if(in_array($action, array('check', 'config'))) {
  foreach($Attr as $v){
    $bool=is_dir($v)?dir_writeable($v):is_writeable($v);
    if($bool) {
      $writeable[$v] = result(1, 0);
      $write_error = 0;
    } else {
      $writeable[$v] = result(0, 0);
      $write_error = 1;
      $quit=true;
    }
	}
}

if(!$action) {

	$onez_license = str_replace('  ', '&nbsp; ', $lang['license']);

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"><?=$lang['show_license']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<table width="98%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr><td class="altbg1">
<table width="99%" cellspacing="1" border="0" align="center">
<tr><td><?=$onez_license?></td></tr>
</table></td></tr></table>
</td></tr>
<tr><td align="center">
<br><form method="post" action="<?=$installfile?>">
<input type="hidden" name="action" value="check">
<input type="submit" class="b" name="submit" value="<?=$lang['agreement_yes']?>" style="height: 25">&nbsp;
<input type="button" class="b" name="exit" value="<?=$lang['agreement_no']?>" style="height: 25" onclick="javascript: window.close();">
</form></td></tr>
<?

} elseif($action == 'check') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['check_config']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$msg = '';
	$curr_os = PHP_OS;

	if(!function_exists('mysql_connect')) {
		$curr_mysql = $lang['unsupport'];
		$msg .= "<li>$lang[mysql_unsupport]</li>";
		$quit = TRUE;
	} else {
		$curr_mysql = $lang['support'];
	}

	$curr_php_version = PHP_VERSION;
	if($curr_php_version < '4.0.6') {
		$msg .= "<li>$lang[php_version_406]</li>";
		$quit = TRUE;
	}

	if(@ini_get(file_uploads)) {
		$max_size = @ini_get(upload_max_filesize);
		$curr_upload_status = $lang['attach_enabled'].$max_size;
	} else {
		$curr_upload_status = $lang['attach_disabled'];
		$msg .= "<li>$lang[attach_disabled_info]</li>";
	}

	$curr_disk_space = intval(diskfreespace('.') / (1024 * 1024)).'M';

	if($quit) {
		$submitbutton = '<input type="button" class="b" name="submit" value=" '.$lang['recheck_config'].' " style="height: 25" onclick="window.location=\'?action=check\'">';
	} else {
		$submitbutton = '<input type="submit" class="b" name="submit" value=" '.$lang['new_step'].' " style="height: 25">';
		$msg = $lang['preparation'];
	}

?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr bgcolor="#c6a16a"><td class="tr"><?=$lang['tips_message']?></td>
</tr><tr>
<td class="message"><?=$msg?></td>
</tr></table><br>
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr class="header"><td></td><td><?=$lang['env_required']?></td><td><?=$lang['env_best']?></td><td><?=$lang['env_current']?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_os']?></td>
<td class="altbg2"><?=$lang['unlimited']?></td>
<td class="altbg1">UNIX/Linux/FreeBSD</td>
<td class="altbg2"><?=$curr_os?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_php']?></td>
<td class="altbg2">4.0.6+</td>
<td class="altbg1">4.3.5+</td>
<td class="altbg2"><?=$curr_php_version?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_attach']?></td>
<td class="altbg2"3><?=$lang['unlimited']?></td>
<td class="altbg1"><?=$lang['enabled']?></td>
<td class="altbg2"><?=$curr_upload_status?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_mysql']?></td>
<td class="altbg2"><?=$lang['support']?></td>
<td class="altbg1"><?=$lang['support']?></td>
<td class="altbg2"><?=$curr_mysql?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_diskspace']?></td>
<td class="altbg2">10M+</td>
<td class="altbg1"><?=$lang['unlimited']?></td>
<td class="altbg2"><?=$curr_disk_space?></td>
</tr></table><br>
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr class="header"><td width="33%"><?=$lang['check_catalog_file_name']?></td><td width="33%"><?=$lang['check_need_status']?></td><td width="33%"><?=$lang['check_currently_status']?></td></tr>
<?
if($Attr){
foreach($Attr as $v){?>
<tr class="option">
<td class="altbg1">./<?=$v?></td>
<td class="altbg2"><?=$lang['writeable']?></td>
<td class="altbg1"><?=$writeable[$v]?></td>
</tr>
<?}}?>
</table></tr></td>
<tr><td align="center">
<br><form method="post" action="<?=$installfile?>">
<input type="hidden" name="action" value="config">
<input type="button" class="b" name="submit" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='<?=$installfile?>'">&nbsp;
<?=$submitbutton?>
</form></td></tr>
<?php

} elseif($action == 'config') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['edit_config']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$inputreadonly = $write_error ? 'readonly' : '';
	$msg = '<li>'.$lang['config_comment'].'</li>';

	if($_POST['saveconfig']) {
		$msg = '';
		$dbhost = setconfig($_POST['dbhost']);
		$dbuser = setconfig($_POST['dbuser']);
		$dbpw = setconfig($_POST['dbpw']);
		$dbname = setconfig($_POST['dbname']);
		$adminemail = setconfig($_POST['adminemail']);
		$tablepre = setconfig($_POST['tablepre']);
		if(empty($dbname)) {
			$msg .= '<li>'.$lang['dbname_invalid'].'</li>';
			$quit = TRUE;
		} else {
			if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
				$errormsg = 'database_errno_'.mysql_errno();
				$msg .= '<li>'.$lang[$errormsg].'</li>';
				$quit = TRUE;
			} else {
				if(mysql_get_server_info() > '4.1') {
					mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET GBK");
				} else {
					mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname`");
				}
				if(mysql_errno()) {
					$errormsg = 'database_errno_'.mysql_errno();
					$msg .= "'<li>$errormsg ".$lang[$errormsg].'</li>';
					$quit = TRUE;
				}

				mysql_close();
			}
		}

		if(strstr($tablepre, '.')) {
			$msg .= '<li>'.$lang['tablepre_invalid'].'</li>';
			$quit = TRUE;
		}

		if(!$quit){
			if(!$write_error) {
				$fp = fopen('./config.inc.php', 'r');
				$configfile = fread($fp, filesize('./config.inc.php'));
				fclose($fp);
        $homepage=preg_replace("/\/([a-zA-Z\.]{4,})$/","","http://".$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']);
				$configfile = preg_replace("/[$]homepage\s*\=\s*[\"'].*?[\"'];/is", "\$homepage = '$homepage';", $configfile);
				$configfile = preg_replace("/[$]dbhost\s*\=\s*[\"'].*?[\"'];/is", "\$dbhost = '$dbhost';", $configfile);
				$configfile = preg_replace("/[$]dbuser\s*\=\s*[\"'].*?[\"'];/is", "\$dbuser = '$dbuser';", $configfile);
				$configfile = preg_replace("/[$]dbpass\s*\=\s*[\"'].*?[\"'];/is", "\$dbpass = '$dbpw';", $configfile);
				$configfile = preg_replace("/[$]dbname\s*\=\s*[\"'].*?[\"'];/is", "\$dbname = '$dbname';", $configfile);
				$configfile = preg_replace("/[$]tbl\s*\=\s*[\"'].*?[\"'];/is", "\$tbl = '$tablepre';", $configfile);

				$fp = fopen('./config.inc.php', 'w');
				fwrite($fp, trim($configfile));
				fclose($fp);
			}
			redirect("$installfile?action=admin");
		}
	}

?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr bgcolor="#c6a16a"><td class="tr"><?=$lang['tips_message']?></td>
</tr><tr>
<td class="message"><?=$msg?></td>
</tr></table><br>
<form method="post" action="<?=$installfile?>">
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr class="header">
<td width="20%"><?=$lang['variable']?></td><td width="30%"><?=$lang['value']?></td><td width="50%"><?=$lang['comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<span class="redfont"><?=$lang['dbhost']?></span></td>
<td class="altbg2"><input type="text" class="a" name="dbhost" value="<?=$dbhost?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbhost_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbuser']?></td>
<td class="altbg2"><input type="text" class="a" name="dbuser" value="<?=$dbuser?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbuser_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbpw']?></td>
<td class="altbg2"><input type="password" class="a" name="dbpw" value="<?=$dbpass?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbpw_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbname']?></td>
<td class="altbg2"><input type="test" class="a" name="dbname" value="<?=$dbname?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbname_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<span class="redfont"><?=$lang['tablepre']?></span></td>
<td class="altbg2"><input type="text" class="a" name="tablepre" value="<?=$tbl?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['tablepre_comment']?></td>
</tr></table><br>
<input type="hidden" name="action" value="config">
<input type="hidden" name="saveconfig" value="1">
<input type="button" name="submit" class="b" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='?action=check'">&nbsp;
<input type="submit" name="submit" class="b" value=" <?=$lang['new_step']?> " style="height: 25">
</form></td></tr>
<?php

} elseif($action == 'admin') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['check_env']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$msg = '<li>'.$lang['add_admin'].'</li>';
	if(!@mysql_connect($dbhost, $dbuser, $dbpass)) {
		$errormsg = 'database_errno_'.mysql_errno();
		$msg .= '<li>'.$lang[$errormsg].'</li>';
		$quit = TRUE;
	} else {
		$curr_mysql_version = mysql_get_server_info();
		if($curr_mysql_version < '3.23') {
			$msg .= '<li>'.$lang['mysql_version_323'].'</li>';
			$quit = TRUE;
		}
	}

	if($_POST['submit']) {
    $apitype=Char_Cv('apitype');
    $apiurl=Char_Cv('apiurl');
    $regurl=Char_Cv('RegUrl');
    $ViewUserUrl=Char_Cv('UserUrl');
    $mastername=Char_Cv('mastername');

		if(!$quit){
      if(!$write_error) {
        $fp = fopen('./config.inc.php', 'r');
        $configfile = fread($fp, filesize('./config.inc.php'));
        fclose($fp);
        $homepage=preg_replace("/\/([a-zA-Z\.]{4,})$/","","http://".$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']);
        $configfile = preg_replace("/[$]homepage\s*\=\s*[\"'].*?[\"'];/is", "\$homepage = '$homepage';", $configfile);
        $configfile = preg_replace("/[$]apitype\s*\=\s*[\"'].*?[\"'];/is", "\$apitype = '$apitype';", $configfile);
        $configfile = preg_replace("/[$]regurl\s*\=\s*[\"'].*?[\"'];/is", "\$regurl = '$regurl';", $configfile);
        $configfile = preg_replace("/[$]ViewUserUrl\s*\=\s*[\"'].*?[\"'];/is", "\$ViewUserUrl = '$ViewUserUrl';", $configfile);
        $configfile = preg_replace("/[$]mastername\s*\=\s*[\"'].*?[\"'];/is", "\$mastername = '$mastername';", $configfile);
        $configfile = preg_replace("/[$]apiurl\s*\=\s*[\"'].*?[\"'];/is", "\$apiurl = '$apiurl';", $configfile);
        
        $configfile = preg_replace("/\/\/([\*]+)UCenter Start([\*]+)((.|\n)+?)\/\/([\*]+)UCenter End([\*]+)/i", "//$1UCenter Start$2\n".$_POST['uc_config']."//$5UCenter End$6", $configfile);
  
        $fp = fopen('./config.inc.php', 'w');
        fwrite($fp, trim($configfile));
        fclose($fp);
        
        $fp = fopen('./onezdata/setting.php', 'w');
        fwrite($fp, '<?php
$setting=array (
  \'theme\' => \'QQ2009\',
  \'homename\' => \'Onez智能聊天系统\',
  \'homepage\' => \''.$homepage.'\',
);
?>');
        fclose($fp);
      }
      redirect("$installfile?action=install");
    }

	}

@preg_match("/\/\/([\*]+)UCenter Start([\*|\r|\n]+)((.|\n)+?)\/\/([\*]+)UCenter End([\*|\r|\n]+)/i",implode('',file('config.inc.php')),$arr);
$uc_config=$arr[3];
?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr bgcolor="#c6a16a"><td class="tr"><?=$lang['tips_message']?></td>
</tr><tr>
<td class="message"><?=$msg?></td>
</tr></table><br>
<form method="post" action="<?=$installfile?>" <?=$alert?>>
<table width="80%" cellspacing="1" bgcolor="#c6a16a" border="0" align="center">
<tr class="header">
<td colspan="2"><?=$lang['add_admin']?></td>
</tr><tr>
<td class="altbg1" width="20%">&nbsp;整合类型</td>
<td class="altbg2" width="80%" style="color:red">
<input type="radio" name="apitype" onclick="document.getElementById('ucBox').style.display='none'" value="phpwind"<?if($apitype=='phpwind')echo' checked'?>> PHPWIND 
<input type="radio" name="apitype" onclick="document.getElementById('ucBox').style.display='block'" value="discuz"<?if($apitype=='discuz')echo' checked'?>> DISCUZ 
<input type="radio" name="apitype" onclick="document.getElementById('ucBox').style.display='block'" value="ucenter"<?if($apitype=='ucenter')echo' checked'?>> UCENTER 
</td>
</tr><tr id="ucBox" style="display:<?=$apitype=='phpwind'?'none':''?>">
<td class="altbg1">&nbsp;UC配置信息</td>
<td class="altbg2">&nbsp;<textarea name="uc_config" rows="20" cols="60"><?=$uc_config?></textarea></td>
</tr><tr>
<td class="altbg1">&nbsp;整合程序的网址</td>
<td class="altbg2">&nbsp;<input type="text" class="a" name="apiurl" value="<?=$apiurl?>" size="60"></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['RegUrl']?></td>
<td class="altbg2">&nbsp;<input type="text" class="a" name="RegUrl" value="<?=$regurl?>" size="60"></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['UserUrl']?></td>
<td class="altbg2">&nbsp;<input type="text" class="a" name="UserUrl" value="<?=$ViewUserUrl?>" size="60"></td>
</tr><tr>
<td class="altbg1">&nbsp;管理员账号</td>
<td class="altbg2">&nbsp;<input type="text" class="a" name="mastername" value="<?=$mastername?>" size="60"> 必须在接口程序上存在</td>
</tr>
</table><br>
<input type="hidden" name="action" value="admin">
<input type="button" name="submit" class="b" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='?action=config'">&nbsp;
<input type="submit" name="submit" class="b" value=" <?=$lang['new_step']?> " style="height: 25">
</form></td></tr>
<?php

} elseif($action == 'install') {
?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['start_install']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td align="center"><br>
<script type="text/javascript">
	function showmessage(message) {
		document.getElementById('notice').value += message + "\r\n";
	}
</script>
<textarea name="notice" style="width: 80%; height: 400px" readonly id="notice"></textarea>

<br><br>
<input type="button" name="submit" class="b" value=" <?=$lang['install_in_processed']?> " disabled style="height: 25" onclick="window.location='admin/index.php'" id="laststep"><br><br>
<br>
</td></tr>
<?php
	instfooter();

	$fp = fopen(ONEZ_ROOT.$sqlfile, 'rb');
	$sql = fread($fp, filesize($sqlfile));
	fclose($fp);
  $db=new onez_db;
	$tablepre=$tbl;
	runquery($sql);
	@touch(ONEZ_ROOT.$lockfile);

	echo '<script type="text/javascript">document.getElementById("laststep").disabled = false; </script>'."\r\n";
	echo '<script type="text/javascript">document.getElementById("laststep").value = \''.$lang['install_succeed'].'\'; </script>'."\r\n";
}
?>