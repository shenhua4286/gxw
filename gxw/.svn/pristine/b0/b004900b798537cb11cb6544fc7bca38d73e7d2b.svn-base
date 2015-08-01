<?php
//连接数据库
function API_Config(){
  global $_COOKIE;
  return array(
    'userid'=>$_COOKIE['onez_userid'],
    'username'=>$_COOKIE['onez_username'],
  );
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
function API_Info($uid){
  global $db;
  if(!$db){
    include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
    $db=new onez_db;
  }
  $user=$db->record("users","*","uid='$uid'");
  $user=$user[0];
  if(!$user)return array();
  $user['face']=UC_API.'/avatar.php?uid='.$uid.'&size=middle';
  return $user;
}
function API_UserList($uids=''){
  global $db;
  if(!$db){
    include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
    $db=new onez_db;
  }
  $Users=$db->record("users","uid,username,sex",$uids?"uid in ($uids)":'');
  foreach($Users as $k=>$rs){
    if($rs['sex']=='1'){
      $rs['sex']='man';
    }elseif($user['sex']=='2'){
      $rs['sex']='woman';
    }else{
      $rs['sex']='';
    }
    $Users[$k]=array(
      'uid'=>$rs['uid'],
      'username'=>$rs['username'],
      'face'=>UC_API.'/avatar.php?uid='.$rs['uid'].'&size=small',
      'sex'=>$rs['sex'],
      'readme'=>'暂无简介',
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
}
function API_Re($tid,$co){
}
?>