<?php
$Block['file_sql_config']=ONEZ_ROOT.'./../data/sql_config.php';
$Block['file_config']=ONEZ_ROOT.'./../data/bbscache/config.php';
$Block['file_showimg']=ONEZ_ROOT.'./../require/showimg.php';
$Block['apipath']='../';
include($Block['file_config']);
function ToOnezCode(&$content){
  global $homepage;
  if(preg_match_all('/\[(P|F)\/([^\/]+)\/([^\]]+)\]/i',$content,$mat)){
    mkdirs(ONEZ_ROOT.'./onezdata/bbs/pic');
    mkdirs(ONEZ_ROOT.'./onezdata/bbs/file');
    foreach($mat[1] as $k=>$v){
      if($v=='P'){
        @copy(ONEZ_ROOT.'./onezdata/pic/'.$mat[3][$k],ONEZ_ROOT.'./onezdata/bbs/pic/'.$mat[3][$k]);
      }elseif($v=='F'){
        @copy(ONEZ_ROOT.'./onezdata/file/'.$mat[3][$k],ONEZ_ROOT.'./onezdata/bbs/file/'.$mat[3][$k]);
      }
    }
  }
  $content=preg_replace('/\[:([^_]+)_([0-9]{1,3})\]/i','[img]'.$homepage.'/images/smiley/$1/$2.gif[/img]',$content);
  $content=preg_replace('/\[P\/([^\/]+)\/([^\]]+)\]/i','[img]'.$homepage.'/bbs.php?P/$1/$2[/img]',$content);
  $content=preg_replace('/\[F\/([^\/]+)\/([^\]]+)\]/i','[url='.$homepage.'/bbs.php?F/$1/$2]$1[/url]',$content);
}
function Conn(){
  global $Block,$Conn;
  if($Conn){
    return $Conn;
  }
  include_once($Block['file_sql_config']);
  include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
  $GLOBALS['tbl'] = $PW;
  $GLOBALS['dbhost'] = $dbhost;
  $GLOBALS['dbuser'] = $dbuser;
  $GLOBALS['dbpass'] = $dbpw;
  $GLOBALS['dbname'] = $dbname;
  $GLOBALS['dbcharset'] = $charset;
  $GLOBALS['Conn']=new onez_db;
  return $GLOBALS['Conn'];
}



function API_Config(){
  global $_COOKIE,$Block;
  $cookie=array(
    'userid'=>$_COOKIE['onez_userid'],
    'username'=>$_COOKIE['onez_username'],
  );
  if(!$cookie['userid']){
    $cookiepre=substr(md5($GLOBALS['db_sitehash']),0,5);
    $winduser=$_COOKIE[$cookiepre.'_winduser'];
    list($winduid,$windpwd,$safecv) = explode("\t",addslashes(StrCode($winduser,'DECODE')));
    if($winduid){
      $cookie['userid']=$winduid;
      $cookie['username']=Conn()->select("members","username","uid='$winduid'");
      $GLOBALS['cookiepre']='onez_';
      osetcookie('userid',$cookie['userid'],31536000);
      osetcookie('username',$cookie['username'],31536000);
    }
  }
  return $cookie;
}
function API_Login($user,$pass){
  global $Block,$setting,$onlineip,$_COOKIE,$_SERVER;
  $pwd=md5($pass);
  $user=Conn()->record("members","uid,username,password,safecv","username='$user' and password='$pwd'");
  if(!$user)return false;
  $winduid=$user[0]['uid'];
  $windpwd=md5($_SERVER['HTTP_USER_AGENT'].$pwd.$GLOBALS['db_hash']);
  $safecv=$user[0]['safecv'];
  $username=$user[0]['username'];
  $winduser=StrCode(stripSlashes("$winduid\t$windpwd\t$safecv"),"ENCODE");
  $GLOBALS['cookiepre'] = substr(md5($GLOBALS['db_sitehash']),0,5).'_';
  osetcookie('winduser',$winduser,31536000);
  osetcookie('ck_info',$GLOBALS['db_ckpath']."\t".$GLOBALS['db_ckdomain'],31536000);
  osetcookie('lastvisit','',0);
  $GLOBALS['cookiepre']='onez_';
  osetcookie('userid',$winduid,31536000);
  osetcookie('username',$username,31536000);
  return 'Y';
}
function API_Logout(){
  global $setting,$onlineip,$Block,$db_hash,$db_sitehash;
  $GLOBALS['db_hash'] = $db_hash;
  $GLOBALS['cookiepre']=substr(md5($db_sitehash),0,5).'_';
  osetcookie('winduser','',-86400);
  $GLOBALS['cookiepre']='onez_';
  osetcookie('userid','',-86400);
  osetcookie('username','',-86400);
  
  $onez.=<<<ONEZ
<p align="center"><br /><br /><br /><br />
<a href="#" onclick="ReLoad()"><font size="2" color="#0000ff">正在同步退出中...</font></a>
</p>
<script type="text/javascript">
function ReLoad(){
  top.location.href='$url';
}
window.onload=ReLoad;
</script>
ONEZ;
  return $onez;
}
function API_Face($uid,$icon=null){
  global $setting,$onlineip,$Block;
  include_once($Block['file_showimg']);
  $GLOBALS['attachpath'] = $GLOBALS['db_attachurl'] != 'N' ? $GLOBALS['db_attachurl'] : $GLOBALS['db_attachname'];
  $GLOBALS['imgdir']		= ONEZ_ROOT.'./'.$Block['apipath'].$GLOBALS['db_picpath'];
  $GLOBALS['attachdir']	= ONEZ_ROOT.'./'.$Block['apipath'].$GLOBALS['db_attachname'];
  $GLOBALS['attachpath']	= $GLOBALS['db_attachname'];
  if ($GLOBALS['db_http'] != 'N') {
    $GLOBALS['imgpath'] = $GLOBALS['db_http'];
  } else {
    $GLOBALS['imgpath'] = $GLOBALS['db_picpath'];
  }
  if(empty($icon))$icon=Conn()->select("members","icon","uid='$uid'");
  $img=showfacedesign($icon,1,'m');
  return strncmp($img[0],'http',4) == 0?$img[0]:($setting['apiurl'].'/'.$img[0]);
}
function API_Info($uid){
  $user=Conn()->record("members","*","uid='$uid'");
  $user=$user[0];
  if(!$user)return array();
  $user['face']=API_Face('',$user['icon']);
  return $user;
}
function API_UserList($uids=''){
  global $db;
  $Users=Conn()->record("members","uid,username,gender,icon,introduce",$uids?"uid in ($uids)":'');
  foreach($Users as $k=>$rs){
    if($rs['gender']=='1'){
      $rs['sex']='man';
    }elseif($user['gender']=='2'){
      $rs['sex']='woman';
    }else{
      $rs['sex']='';
    }
    $Users[$k]=array(
      'uid'=>$rs['uid'],
      'username'=>$rs['username'],
      'face'=>API_Face('',$rs['icon']),
      'sex'=>$rs['sex'],
      'readme'=>$rs['introduce'],
    );
  }
  return $Users;
}
function API_AddFriend($uid){
  global $userid;
  if($userid==$uid)return -1;
  if(Conn()->rows("friends","uid='$userid' and friendid='$uid'")>0)return -2;
  $arr=array(
    'uid'=>$userid,
    'friendid'=>$uid,
    'joindate'=>time(),
    'iffeed'=>1,
  );
  Conn()->insert("friends",$arr);
  return 1;
}
function API_DelFriend($uid){
  Conn()->delete("friends","uid='$userid'");
  return 1;
}
function API_RowFriend($direction=0){
  global $userid;
  return Conn()->rows("friends","uid='$userid'");
}
function API_ListFriend($page,$pagesize=10,$totalnum=10,$direction=0){
  global $userid;
  $page<1 && $page=1;
  $Table=Conn()->record("friends f left join ".(Conn()->tbl)."members m on m.uid=f.friendid","f.*,m.username","f.uid='$userid' limit ".(($page-1)*$pagesize).",$pagesize");
  return $Table;
}
function API_LsFriend(){
  global $userid;
  $A=array();
  $Table=Conn()->record("friends","*","uid='$userid'");
  foreach($Table as $rs)$A[$rs['friendid']]=$rs['friendid'];
  if(!$A)$A=array();
  return implode(',',array_values($A));
}
function API_InMsg(){
  global $setting;
  header("location:".$setting['apiurl']."/message.php?action=write&touid=1");
  return 1;
}
function API_NewMsg($more=0){
  global $userid;
  return Conn()->rows("msg","touid='$userid' and ifnew=1");
}
function API_SendMsg($uid,$ti,$co){
  global $userid;
  $arr=array(
    'touid'=>$uid,
    'fromuid'=>$userid,
    'username'=>$username,
    'ifnew'=>1,
    'mdate'=>time(),
  );
  Conn()->insert("msg",$arr);
  $mid=Conn()->select("msg","mid","1 order by mid desc");
  $arr=array(
    'mid'=>$mid,
    'title'=>$ti,
    'content'=>$co,
  );
  Conn()->insert("msg",$arr);
}
function API_SetMsg($mids){
  global $userid;
  return Conn()->update("msg",array('ifnew'=>0),"touid='$userid' and mid in (".implode(',',$mids).")");;
}
function API_ListMsg(){
}

function API_Pub($ti,$content){
	global $LINE,$setting,$Channel,$userid,$username,$onlineip;
	ToOnezCode($content);
	#写入主题
	$arr=array(
    'fid'=>$Channel['forumid'],
    'icon'=>'0',
    'author'=>$username,
    'authorid'=>$userid,
    'subject'=>$ti,
    'ifcheck'=>'1',
    'type'=>'0',
    'postdate'=>time(),
    'lastpost'=>time(),
    'lastposter'=>$username,
    'hits'=>'1',
    'replies'=>'0',
    'topped'=>'0',
    'digest'=>'0',
    'special'=>'0',
    'state'=>'0',
    'ifupload'=>'0',
    'ifmail'=>'0',
    'anonymous'=>'0',
    'ptable'=>'',
    'ifmagic'=>'0',
    'ifhide'=>'0',
    'tpcstatus'=>'12',
    'modelid'=>'0',
	);
	Conn()->insert("threads",$arr);
  $tid=(int)Conn()->select("threads","tid","subject='$ti' order by tid desc");
  if(!$tid)return array();
  
	#写入主题内容
	$arr=array(
    'tid'=>$tid,
    'aid'=>'0',
    'userip'=>$onlineip,
    'ifsign'=>'1',
    'buy'=>'',
    'ipfrom'=>getaddress($onlineip),
    'tags'=>'',
    'ifconvert'=>'1',
    'ifwordsfb'=>'2',
    'content'=>$content,
    'magic'=>'',
	);
	Conn()->insert("tmsgs",$arr);
	Conn()->query("UPDATE ".Conn()->tbl."memberdata SET  postnum=postnum+'1', todaypost=todaypost+'1', monthpost=monthpost+'1', lastpost='".time()."' WHERE uid= '$userid' ");
	Conn()->query("UPDATE ".Conn()->tbl."forumdata SET tpost=tpost+'1',article=article+'1',topic=topic+'1' ,lastpost= '$ti\t$username\t".time()."\tread.php?tid=$tid&page=e#a'  WHERE fid= '$Channel[forumid]' ");
	Conn()->query("REPLACE INTO ".Conn()->tbl."usercache SET  uid='$userid', type='topic',expire='".(time()+86400*7)."', value='a:3:{s:7:\"subject\";s:14:\"$ti\";s:7:\"content\";s:14:\"$content\";s:8:\"postdate\";i:".time().";}'");
	
  return array($tid,$setting['apiurl'].'/read.php?tid='.$tid);
}
function API_Re($tid,$co){
	global $Channel,$userid,$username,$onlineip;
	ToOnezCode($co);
	$arr=array(
    'pid'=>'',
    'fid'=>$Channel['forumid'],
    'tid'=>$tid,
    'aid'=>'0',
    'author'=>$username,
    'authorid'=>$userid,
    'icon'=>'0',
    'postdate'=>time(),
    'subject'=>'',
    'userip'=>$onlineip,
    'ifsign'=>'1',
    'ipfrom'=>getaddress($onlineip),
    'ifconvert'=>'2',
    'ifwordsfb'=>'2',
    'ifcheck'=>'1',
    'content'=>$co,
    'anonymous'=>'0',
    'ifhide'=>'0',
	);
	Conn()->insert("posts",$arr);
  $pid=(int)Conn()->select("posts","pid","1 order by tid desc");
	Conn()->query("UPDATE ".Conn()->tbl."threads SET replies=replies+1,hits=hits+1, lastposter='$username', lastpost='".time()."' WHERE tid= '$tid'");
	Conn()->query("UPDATE ".Conn()->tbl."memberdata SET  postnum=postnum+1, todaypost=todaypost+1, monthpost=monthpost+1, lastpost='".time()."' WHERE uid= '1' ");
	Conn()->query("UPDATE ".Conn()->tbl."forumdata SET tpost=tpost+'1',article=article+'1' ,lastpost= 'Re:\t$username\t".time()."\tread.php?tid=$tid&page=e#a'  WHERE fid= '$Channel[forumid]' ");
  $value=(int)Conn()->select("elements","value","type='replysort' and mark='$Channel[forumid]'");
  $value++;
	Conn()->query("REPLACE INTO ".Conn()->tbl."elements (type,mark,id,value,addition,special) VALUES  ('replysort','$Channel[forumid]','$tid','$value','','0') , ('replysortday','$Channel[forumid]','$tid','$value','".time()."','0') ");
  return 1;
}
?>