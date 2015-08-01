<?php
$Block['file_sql_config']='./../config.inc.php';
//特殊函数
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
function API_Config(){
  global $_COOKIE;
  return array(
    'userid'=>$_COOKIE['onez_userid'] ? $_COOKIE['onez_userid'] :1,
    'username'=>$_COOKIE['onez_username']? iconv('utf-8','gbk',$_COOKIE['onez_username']):'游客',
  );
}
function Conn(){
  global $Block,$Conn;
  if($Conn){
    return $Conn;
  }
  print_r($Block);
  include_once($Block['file_sql_config']);
  include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
  $GLOBALS['tbl'] = $tablepre;
  $GLOBALS['dbhost'] = $dbhost;
  $GLOBALS['dbuser'] = $dbuser;
  $GLOBALS['dbpass'] = $dbpw;
  $GLOBALS['dbname'] = $dbname;
  $GLOBALS['dbcharset'] = $dbcharset?$dbcharset:$charset;
  $GLOBALS['Conn']=new onez_db;
  return $GLOBALS['Conn'];
}
function API_Login($user,$pass){
  global $db,$onlineip;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  $api = uc_user_login($user,$pass,0);
  list($uid,$username,$password,$email)=$api;
  if($uid<0){
    if($uid==-1){
      return '用户不存在，或者被删除';
    }elseif($uid==-2){
      return '用户名或密码不正确';
    }elseif($uid==-3){
      return '安全提问错';
    }
  }
  if(!$db){
    include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
    db_local();
    $db=new onez_db;
  }
  $db->reset();
  if($db->rows("users","uid='$uid'")==0){//创建本地用户
    if($data = uc_get_user($uid,1)) {
      list($uid, $username, $email) = $data;
      $arr=array(
        'uid'=>$uid,
        'username'=>$username,
        'password'=>md5($pass),
        'email'=>$email,
        'infoip'=>$onlineip,
        'infotime'=>time(),
      );
      $db->insert('users',$arr);
    }
  }
  $GLOBALS['cookiepre']='onez_';
  osetcookie('userid',$uid,31536000);
  osetcookie('username',$username,31536000);
  echo uc_user_synlogin($uid);
  echo<<<ONEZ
<p align="center"><br /><br /><br /><br />
<a href="#" onclick="ReLoad()"><font size="2" color="#0000ff">正在同步登录中...</font></a>
</p>
<script type="text/javascript">
function ReLoad(){
  top.location.reload();
}
window.onload=ReLoad;
</script>
ONEZ;
  exit();
  return 'Y';
}
function API_Logout(){
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  $onez=uc_user_synlogout();
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
  $GLOBALS['cookiepre']='onez_';
  osetcookie('userid','',-86400);
  osetcookie('username','',-86400);
  return $onez;
}
function API_Face($uid){
  return UC_API.'/avatar.php?uid='.$uid.'&size=middle';
}

$faceIndex=1;

function API_Info($uid){
  global $db;
    $faceIndex++;
  if(!$db){
    include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
    $db=new onez_db;
  }
  $user=$db->record("member m left join gxw_member_info i on m.userid=i.userid","*","m.userid='$uid'");
  $user=$user[0];
  if(!$user)return array();
  
  $user=array(
      'uid'=>$user['userid'],
      'username'=>$user['nickname'],
      'face'=>$user['basic_logo'] ? $user['basic_logo']: 'images/face/'.$faceIndex.'.png',
      'sex'=>20,
      'readme'=>$user['basic_com_intruduce'],
    );
  return $user;
}

function API_UserList($uids=''){
  global $db;
  
  if(!$db){
  	include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
  	$db=new onez_db;
  }
  $Users=$db->record("member m left join gxw_member_info i on m.userid=i.userid","*",'1=1  order by  status desc','0,20');
 // print_r($Users);
 // die;
  foreach($Users as $k=>$rs){
  	$faceIndex++;
    if($rs['gender']=='1'){
      $rs['sex']='man';
    }elseif($user['gender']=='2'){
      $rs['sex']='woman';
    }else{
      $rs['sex']='';
    }
  //  print_r($Users);
    $faceIndex=$faceIndex%4;
    $Users[$k]=array(
      'uid'=>$rs['userid'],
      'username'=>$rs['nickname'],
      'face'=>$rs['basic_logo'] ? $rs['basic_logo']: 'images/face/'.$faceIndex.'.png',
      'sex'=>20,
      'readme'=>$rs['basic_com_intruduce'],
    );
  }
  return $Users;
}
function API_AddFriend($uid){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_friend_add($userid,$uid);
}
function API_DelFriend($uid){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_friend_delete($userid,array($uid));
}
function API_RowFriend($direction=0){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_friend_totalnum($userid);
}
function API_ListFriend($page,$pagesize=10,$totalnum=10,$direction=0){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_friend_ls($userid,$page,$pagesize,$totalnum,$direction);
}
function API_LsFriend(){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  $T=uc_friend_ls($userid,1,999,999);
  $A=array();
  foreach($T as $rs)$A[$rs['friendid']]=$rs['friendid'];
  return implode(',',array_values($A));
}
function API_InMsg(){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_pm_location($userid);
}
function API_NewMsg($more=0){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_pm_checknew($userid,$more);
}
function API_SendMsg($uid,$ti,$co){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_pm_send($userid,$uid,$ti,$co);
}
function API_SetMsg($uids){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_pm_readstatus($userid,$uids);
}
function API_ListMsg(){
  global $userid;
  include_once(ONEZ_ROOT.'./uc_client/client.php');
  return uc_pm_list($userid);
}
function API_Pub($ti,$content){
	global $LINE,$setting,$Channel,$userid,$username,$onlineip;
	ToOnezCode($content);
	#写入主题
	$arr=array(
    'fid'=>$Channel['forumid'],
    'author'=>$username,
    'authorid'=>$userid,
    'subject'=>$ti,
    'dateline'=>time(),
    'lastpost'=>time(),
    'lastposter'=>$username,
	);
	Conn()->insert("threads",$arr);
  $tid=(int)Conn()->select("threads","tid","subject='$ti' order by tid desc");
  if(!$tid)return array();
	@Conn()->query("REPLACE INTO ".Conn()->tbl."favoritethreads (tid, uid, dateline) VALUES ('$tid', '$Channel[forumid]', '".time()."')");
	@Conn()->query("UPDATE ".Conn()->tbl."favoriteforums SET newthreads=newthreads+1 WHERE fid='$Channel[forumid]' AND uid<>'$userid'");
  
	#写入主题内容
	$arr=array(
    'fid'=>$Channel['forumid'],
    'tid'=>$tid,
    'first'=>'1',
    'author'=>$username,
    'authorid'=>$userid,
    'subject'=>$ti,
    'dateline'=>time(),
    'message'=>$content,
    'useip'=>$onlineip,
    'bbcodeoff'=>'0',
    'smileyoff'=>'-1',
    'parseurloff'=>'',
	);
	Conn()->insert("posts",$arr);

	Conn()->query("UPDATE ".Conn()->tbl."members SET posts=posts+('+1') , lastpost='".time()."'  WHERE uid IN ($userid)");
	Conn()->query("UPDATE ".Conn()->tbl."members SET threads=threads+1 WHERE uid='$userid'");
	Conn()->query("UPDATE ".Conn()->tbl."forums SET lastpost='$tid\t$ti\t".time()."\t$username', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='$Channel[forumid]'");
	
  return array($tid,$setting['apiurl'].'/read.php?tid='.$tid);
}
function API_Re($tid,$co){
	global $Channel,$userid,$username,$onlineip;
	ToOnezCode($co);
	$arr=array(
    'fid'=>$Channel['forumid'],
    'tid'=>$tid,
    'first'=>'0',
    'author'=>$username,
    'authorid'=>$userid,
    //'subject'=>$username.' 说:',
    'dateline'=>time(),
    'message'=>$co,
    'useip'=>$onlineip,
    'bbcodeoff'=>'0',
    'smileyoff'=>'-1',
    'parseurloff'=>'',
	);
	Conn()->insert("posts",$arr);

	Conn()->query("UPDATE ".Conn()->tbl."threads SET lastposter='$username', lastpost='".time()."', replies=replies+1 WHERE tid='$tid'");
	Conn()->query("UPDATE ".Conn()->tbl."members SET posts=posts+('+1') , lastpost='".time()."'  WHERE uid IN ($userid)");
	Conn()->query("UPDATE ".Conn()->tbl."forums SET lastpost='$tid\t$ti\t".time()."\t$username', posts=posts+1, todayposts=todayposts+1 WHERE fid='$Channel[forumid]'");
  return 1;
}
?>