<?php
function mTime(){
  $mtime = explode(' ', microtime());
  return $mtime[1] + $mtime[0];
}
function readover($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}
function writeover($filename,$data,$method="rb+",$iflock=1){
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
}
function mkdirs($dir){
  if(!is_dir($dir)){
    mkdirs(dirname($dir));
    mkdir($dir,0777);
  }
  return ;
}
function oiconv($from,$to,$string){
  if(function_exists('mb_convert_encoding')){
    return mb_convert_encoding($string,$to,$from);
  }else{
    return iconv($from,$to,$string);
  }
}
function StrCode($string,$action='ENCODE'){
  global $_SERVER;
	$action != 'ENCODE' && $string = base64_decode($string);
	$code = '';
	$key  = substr(md5($_SERVER['HTTP_USER_AGENT'].$GLOBALS['db_hash']),8,18);
	$keylen = strlen($key); $strlen = strlen($string);
	for ($i=0;$i<$strlen;$i++) {
		$k		= $i % $keylen;
		$code  .= $string[$i] ^ $key[$k];
	}
	return ($action!='DECODE' ? base64_encode($code) : $code);
}
function AddMsg_Public($msg,$channel='default'){
  mkdirs(ONEZ_ROOT.'./onezdata/message/group/'.$channel);
  $fileId=intval(@readover(ONEZ_ROOT.'./onezdata/message/group/'.$channel.'.txt'))+1;
  writeover(ONEZ_ROOT.'./onezdata/message/group/'.$channel.'.txt',$fileId);
  $file=ONEZ_ROOT.'./onezdata/message/group/'.$channel.'/'.$fileId.'.txt';
  writeover($file,$msg);
}
function AddMsg_User($uid,$msg){
  mkdirs(ONEZ_ROOT.'./onezdata/message/users');
  $file=ONEZ_ROOT.'./onezdata/message/users/'.$uid.'.php';
  !file_exists($file) && writeover($file,'<?php die();?>');
  writeover($file,$msg,"a+");
}
function PostData($url, $post = '', $baseurl='') {
  global $_SERVER,$cookiefile,$_COOKIE;
  if($baseurl=='')$baseurl=$url;
  $limit = 0;$bysocket = FALSE;$ip = '';$timeout = 15;$block = TRUE;
	$return = '';
  $Cookie=array();
	$matches = parse_url($url);
	if($cookiefile && file_exists($cookiefile)){
    @include($cookiefile);
	}else{
    foreach($_COOKIE as $k=>$v){
      $Cookie[]=($k.'='.urlencode($v));
    }
  }
  if(is_array($Cookie)){
    $cookie=implode('; ',$Cookie);
  }
	$matches = parse_url($url);
	!isset($matches['host']) && $matches['host'] = '';
	!isset($matches['path']) && $matches['path'] = '';
	!isset($matches['query']) && $matches['query'] = '';
	!isset($matches['port']) && $matches['port'] = '';
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: $baseurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: $baseurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen($host, $port, $errno, $errstr,5);
	if(!$fp) {
		return '';//note $errstr : $errno \r\n
	} else {
    @fputs($fp,$out); 
    $inheader = 1; 
    while (!feof($fp)) {
      $line = @fgets($fp,1024); //去除请求包的头只显示页面的返回数据
      $return.=$line;
      if($inheader && ($line == "\n" || $line == "\r\n")){
        $inheader = 0;
      }
      if($inheader == 0){
        $tmp.=$line; 
      }
    }
		@fclose($fp);
		if($cookiefile && file_exists($cookiefile)){
      if(preg_match_all("/Set\-Cookie: ([^=]+)=([^;]+);/i",$return,$mat)){
        for($i=0;$i<count($mat[0]);$i++){
          $Cookie[$mat[1][$i]]=$mat[1][$i].'='.$mat[2][$i];
        }
        writeover($cookiefile,'<?$Cookie='.var_export($Cookie,true).';?>');
      }
		}
		return $hdr?$return:$tmp;
	}
}
function osetcookie($var, $value, $life = 0, $prefix = 1) {
	global $time, $_SERVER,$cookiepre;
	$cookiedomain='';
	$cookiepath='/';
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $time + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function GetE($tmpdata,$str,$pos='left',$return=0){
  if(!$str)return $tmpdata;
  $o=explode('[内容]',$str);
  if(count($o)<2)return $str;
  $A='';
  if($return==2)$B=array();
  if($pos=='left'){
		if(strpos($tmpdata,$o[0])){
			if($return==2){
				$a=explode($o[0],$tmpdata);
				unset($a[0]);
				foreach($a as $v){
					$b=current(explode($o[1],$v));
					$B[$b]=$b;
				}
			}else{
				$a=explode($o[0],$tmpdata);
				if(count($a)>1){
					$a=explode($o[1],$a[1]);
					if(count($a)>1){
						$A=current($a);
					}
				}
			}
		}
  }else{
		if(strpos($tmpdata,$o[1])){
			if($return==2){
				$a=explode($o[1],$tmpdata);
				unset($a[count($a)-1]);
				foreach($a as $v){
					$b=end(explode($o[0],$v));
					$B[$b]=$b;
				}
			}else{
				$a=explode($o[1],$tmpdata);
				if(count($a)>1){
					$a=explode($o[0],$a[count($a)-1]);
					if(count($a)>1){
						$A=end($a);
					}
				}
			}
		}
  }
  if($return==1){
		return array($o[0],$A,$o[1]);
  }elseif($return==2){
		return $B;
  }else{
		return $A;
  }
}
function FormatUrl($baseurl,$url){
	if(substr($url,0,7)=='http://'){
		$newurl=$url;
	}else{
		$e=parse_url($baseurl);
		if(substr($url,0,2)=='./'){
			$newurl='http://'.$e['host'].dirname($e['path']).'/'.substr($url,2);
		}elseif(substr($url,0,3)=='../'){
			$f=explode('../',$url);
			$g=explode('/',$e['path']);
			$h=array();
			for($j=0;$j<count($g)-count($f);$j++){
				$h[]=$g[$j];
			}
			$newurl='http://'.$e['host'].implode('/',$h).'/'.str_replace('../','',$url);
		}elseif(substr($url,0,1)=='/'){
			$newurl='http://'.$e['host'].$url;
		}else{
			$newurl='http://'.$e['host'].dirname($e['path']).'/'.$url;
		}
		$newurl=str_replace('\\','',$newurl);
		$newurl=preg_replace('/(\?|\#)(.+?)$/i','',$newurl);
	}
	return $newurl;
}
function Online($ChannelId){
  global $setting;
  $onlinepath="../onezdata/online/$ChannelId";
  $A=array();
  $num=0;
  if(is_dir($onlinepath)){
    $dh=opendir($onlinepath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($onlinepath.'/'.$file)) {
          if(time()-@filemtime($onlinepath.'/'.$file)<(int)$setting['sec_online']){
            $num++;
          }
        }
      }
    }
    closedir($dh);
  }
  return $num;
}
function V($string,$encode=0){
  global $thecharset,${$string};
  $string=${$string};
  if($thecharset && $thecharset!='gbk'){
    $str= oiconv('gbk',$thecharset,$string);
  }else{
    $str= $string;
  }
  $str=str_replace('&','%26',$str);
  return $encode?urlencode($str):$str;
}
function ero($msg1,$msg2="1"){
  if ($msg2=="0"){
    echo "<script language=\"javascript\">alert('".$msg1."');window.close();</script>";
    exit;
  }elseif($msg2=="1"){
    echo "<script language=\"javascript\">alert('".$msg1."');history.go(-1);</script>";
    exit;
  }elseif($msg2=="2"){
    echo "<script language=\"javascript\">alert('".$msg1."');</script>";
  }elseif ($msg2=="3"){
    echo "<script language=\"javascript\">location.href='".$msg1."';</script>";
    exit;
  }else{
    echo "<script language=\"javascript\">alert('".$msg1."');location.href='".$msg2."';</script>";
    exit;
  } 
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

function getaddress($ip,$area=false){
  include_once(ONEZ_ROOT."./include/ip.class.php");
  $p=new IpLocation();
  $l=$p->getlocation($ip);
  //print_r($l);
  $address=$l['country'];
  if($area)$address.=$l['area'];
  return $address;
}

function escape($str) {
	preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v) {
		if(ord($v[0]) < 128)
		$ar[$k] = rawurlencode($v);
		else
		$ar[$k] = "%u".bin2hex(iconv("GB2312","UCS-2",$v));
	}
	return join("",$ar);
}
function unescape($str) {
  $str = rawurldecode($str);
  preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r);
  $ar = $r[0];
  foreach($ar as $k=>$v) {
    if(substr($v,0,2) == "%u")
      $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4)));
    elseif(substr($v,0,3) == "&#x")
      $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1)));
    elseif(substr($v,0,2) == "&#") {
      $ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1)));
    }
  }
  return join("",$ar);
}
function daddslashes($string, $force = 0) {
	if(!$GLOBALS['magic_quotes_gpc'] || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
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

function SetInput($In_type,$In_name,$In_value,$In_other='',$In_size='',$In_maxlen=''){
  switch(true){
    case ($In_type=='text'||$In_type=='password'||$In_type=='file'):
      return "<input type=\"$In_type\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" size=\"$In_size\" maxlength=\"$In_maxlen\" class=\"btn1\" $In_other>";
      break;
    case ($In_type=='button'||$In_type=='submit'||$In_type=='reset'):
      return "<input type=\"$In_type\" class=\"btn1\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" $In_other>";
      break;
    case ($In_type=='radio'||$In_type=='checkbox'):
      return "<input type=\"$In_type\" style=\"border:0\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" $In_other>";
      break;
    case $In_type=='hidden':
      return "<input type=\"$In_type\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\">";
      break;
    case $In_type=='textarea':
      return "<textarea id=\"$In_name\" name=\"$In_name\" wrap=\"virtual\" cols=\"$In_size\" rows=\"$In_maxlen\" $In_other>$In_value</textarea>";
      break;
  }
}
function delhtml($document){
  $document=preg_replace("/\<BR\>/i","\r\n",$document);
  $search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
                   "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
                   //"'([\r\n])[\s]+'",                 // 去掉空白字符
                   "'&(quot|#34);'i",                 // 替换 HTML 实体
                   "'&(amp|#38);'i",
                   "'&(lt|#60);'i",
                   "'&(gt|#62);'i",
                   "'&(nbsp|#160);'i",
                   "'&(iexcl|#161);'i",
                   "'&(cent|#162);'i",
                   "'&(pound|#163);'i",
                   "'&(copy|#169);'i",
                   "'&#(\d+);'e");                    // 作为 PHP 代码运行
  $replace = array ("",
                    "",
                    //"\\1",
                    "\"",
                    "&",
                    "<",
                    ">",
                    " ",
                    chr(161),
                    chr(162),
                    chr(163),
                    chr(169),
                    "chr(\\1)");
  return preg_replace ($search, $replace, $document);
}
function WriteLog($msg){
  global $setting;
  if($setting['nolog'])return;
  writeover(ONEZ_ROOT.'./onezdata/senderr.txt',"\n".$msg,'a+');
}
function cuturl($url) {
	$length = 65;
	$urllink = "<a href=\"".(substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url).'" target="_blank">';
	if(strlen($url) > $length) {
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	$urllink .= $url.'</a>';
	return $urllink;
}
function onezcode($document){
  global $company;
  $search = array (
    "/\[url\]\s*(www.|https?:\/\/|ftp:\/\/|gopher:\/\/|news:\/\/|telnet:\/\/|rtsp:\/\/|mms:\/\/|callto:\/\/|ed2k:\/\/){1}([^\[\"']+?)\s*\[\/url\]/ie",
				"/\[img\](.+?)\[\/img\]/is",
				"/\[url=www.([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms|callto|ed2k){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[qq\]([0-9]{5,10})\[\/qq\]/is",
				"/\[email\]\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*\[\/email\]/i",
				"/\[email=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\](.+?)\[\/email\]/is",
				"/\[color=([^\[\<]+?)\]/i",
				"/\[size=(\d+?)\]/i",
				"/\[size=(\d+(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/i",
				"/\[font=([^\[\<]+?)\]/i",
				"/\[align=([^\[\<]+?)\]/i"
				);
  $replace = array (
				"cuturl('\\1\\2')",
				"<img src=\"\\1\" border=\"0\" onload=\"if(this.width>400){this.width=400};if(this.height>400){this.height=400}\">",
				"<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",
				"<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>",
				"<a href=\"http://wpa.qq.com/msgrd?V=1&amp;Uin=\\1&amp;Site=$company&amp;Menu=yes\" target=\"_blank\"><img src=\"http://wpa.qq.com/pa?p=1:\\1:4\" border=\"0\" alt=\"QQ\" /></a>",
				"<a href=\"mailto:\\1@\\2\">\\1@\\2</a>",
				"<a href=\"mailto:\\1@\\2\">\\3</a>",
				"<font color=\"\\1\">",
				"<font size=\"\\1\">",
				"<font style=\"font-size: \\1\">",
				"<font face=\"\\1\">",
				"<p align=\"\\1\">"
        );
  $document = preg_replace ($search, $replace, $document);
  
  
  $search = array(
				'[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]',
				'[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
				'[list=A]', '[*]', '[/list]', '[indent]', '[/indent]',"\t", '   ', '  '
			);
  $replace =array(
				'</font>', '</font>', '</font>', '</p>', '<b>', '</b>', '<i>',
				'</i>', '<u>', '</u>', '<ul>', '<ol type=1>', '<ol type=a>',
				'<ol type=A>', '<li>', '</ul></ol>', '<blockquote>', '</blockquote>','&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;'
			);
  $document = str_replace ($search, $replace, $document);
  $document = str_replace ("\r\n", "<br>", $document);
  $document = str_replace ("\r", "<br>", $document);
  $document = str_replace ("[br]", "<br>", $document);
  return $document;
}
?>