<?php
#
function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT charset=$dbcharset" : " TYPE=$type");
}
function ostripslashes($string, $force = 0) {
  if(is_array($string)) {
    foreach($string as $key => $val) {
      $string[$key] = ostripslashes($val, $force);
    }
  } else {
    $string = stripslashes($string);
  }
	return $string;
}

function dir_writeable($dir) {
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function osetcookie($var, $value, $life = 0, $prefix = 1) {
	global $time, $_SERVER,$cookiepre;
	$cookiedomain='';
	$cookiepath='/';
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $time + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function Char_Cv($msg,$method="post",$type=""){
	global $_GET,$_POST;
	$msg = strtolower($method)=="get" ? $_GET[$msg] : $_POST[$msg];
  if($type=="num"){
    if(!is_numeric($msg))$msg=0;
    return $msg;
  }
  $msg = str_replace('|','｜',$msg);
  $msg = str_replace('&amp;','&',$msg);
  $msg = str_replace('&nbsp;',' ',$msg);
  $msg = str_replace('"','&quot;',$msg);
  $msg = str_replace("'",'&#39;',$msg);
  $msg = str_replace("<","&lt;",$msg);
  $msg = str_replace(">","&gt;",$msg);
  $msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
  $msg = str_replace("\r","",$msg);
  $msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}
function dir_clear($dir) {
	global $lang;

	showjsmessage($lang['clear_dir'].' '.$dir);
	$directory = dir($dir);
	while($entry = $directory->read()) {
		$filename = $dir.'/'.$entry;
		if(is_file($filename)) {
			@unlink($filename);
		}
	}
	$directory->close();
	result(1, 1, 0);
}

function instheader() {
	global $dbcharset, $lang, $version;

	echo "<html><head>".
		"<meta http-equiv=\"Content-Type\" content='text/html; dbcharset=gbk'>".
		"<title>Onez智能聊天系统 2.0正式版 安装向导</title>".
		"<link rel=\"stylesheet\" type=\"text/css\" id=\"css\" href=\"install/style.css\"></head>".
		"<body text=\"#000000\">".
		"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"mainTable\" align=\"center\"><tr><td>".
      		"<table width=\"930\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr>".
          	"<td class=\"install\" height=\"30\" valign=\"bottom\"><font color=\"#FF0000\">&gt;&gt;</font> Onez智能聊天系统 2.0正式版 ".
          	"</td></tr><tr><td><hr noshade align=\"center\" width=\"100%\" size=\"1\"></td></tr>";
}

function instfooter() {
	global $version;

	echo "<tr><td><hr noshade align=\"center\" width=\"100%\" size=\"1\"></td></tr>".
        	"<tr><td align=\"center\">".
            	"<b style=\"font-size: 11px\">Powered by <a href=\"http://onez.cn\" target=\"_blank\">onez.cn! $version".
          	"</a> &nbsp; Copyright &copy; <a href=\"http://onez.cn\" target=\"_blank\">Onez Inc.</a> 2001-2007</b><br><br>".
          	"</td></tr></table></td></tr></table>".
		"</body></html>";
}

function instmsg($message, $url_forward = '') {
	global $lang, $msglang;

	instheader();

	$message = $msglang[$message] ? $msglang[$message] : $message;

	if($url_forward) {
		$message .= "<br><br><br><a href=\"$url_forward\">$message</a>";
		$message .= "<script>setTimeout(\"redirect('$url_forward');\", 1250);</script>";
	} elseif(strpos($message, $lang['return'])) {
		$message .= "<br><br><br><a href=\"javascript:history.go(-1);\" class=\"mediumtxt\">$lang[message_return]</a>";
	}

	echo 	"<tr><td style=\"padding-top:100px; padding-bottom:100px\"><table width=\"560\" cellspacing=\"1\" bgcolor=\"#c6a16a\" border=\"0\" align=\"center\">".
		"<tr bgcolor=\"#c6a16a\"><td width=\"20%\" class=\"tr\">错误信息</td></tr>".
  		"<tr align=\"center\" bgcolor=\"#e1eefe\"><td class=\"message\">$message</td></tr></table></tr></td>";

	instfooter();
	exit;
}

function showjsmessage($message) {
	echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
	flush();
	ob_flush();
}

function random($length) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function result($result = 1, $output = 1, $html = 1) {
	global $lang;

	if($result) {
		$text = $html ? '<font color="#0000EE">'.$lang['writeable'].'</font><br>' : $lang['writeable']."\n";
		if(!$output) {
			return $text;
		}
		echo $text;
	} else {
		$text = $html ? '<font color="#FF0000">'.$lang['unwriteable'].'</font><br>' : $lang['unwriteable']."\n";
		if(!$output) {
			return $text;
		}
		echo $text;
	}
}

function redirect($url) {

	echo "<script>".
		"function redirect() {window.location.replace('$url');}\n".
		"setTimeout('redirect();', 0);\n".
		"</script>";
	exit();

}

function runquery($sql) {
	global $lang, $dbcharset, $tablepre, $db;
	$sql = str_replace("\r", "\n", str_replace(' onez_', ' '.$tablepre, $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {

			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				showjsmessage($lang['create_table'].' '.$name.' ... '.$lang['succeed']);
				$db->query(createtable($query, $dbcharset));

			} else {
				$db->query($query);
			}

		}
	}
}

function setconfig($string) {
	if(!get_magic_quotes_gpc()) {
		$string = str_replace('\'', '\\\'', $string);
	} else {
		$string = str_replace('\"', '"', $string);
	}
	return $string;
}

?>