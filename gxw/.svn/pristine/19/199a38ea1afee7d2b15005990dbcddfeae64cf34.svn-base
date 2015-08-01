<?php
include_once( "include/common.inc.php" );
$theskin=Char_Cv('theskin','get');
foreach(API_Config() as $k=>$v)$$k=$v;
function Check(){
  global $userid;
  if(!$userid){
    API_Logout();
    exit('<script>if(top!==self)top.location.reload();</script>');
  }
}
if(!$userid){
  $userid=$_SESSION['onez_userid'];
  $username=32 ;
  if(!$userid){
    $userid='_'.uniqid('');
    //$username=$guestname;
    $_SESSION['onez_userid']=$userid;
    $_SESSION['onez_username']=$username;
  }
}
if(file_exists('onezdata/limit/'.$userid.'.txt')){
  $t=time()-@filemtime('onezdata/limit/'.$userid.'.txt');
  if($t<1800){
    API_Logout();
    exit('<script>alert("您暂时不能进入本群，解封剩余时间：'.intval((1800-$t)/60).'分钟");if(top!==self)top.location.reload();</script>');
  }else{
    @unlink('onezdata/limit/'.$userid.'.txt');
  }
}

if(substr($userid,0,1)=='_'){
  $user=array(
    'userid'=>$userid,
    'username'=>$username,
  );
}

//echo $_COOKIE['onez_username'];
($_SERVER['HTTP_USER_AGENT']=$_SESSION['HTTP_USER_AGENT']) || $_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
($ip=$_SESSION['ip']) || $_SESSION['ip']=$onlineip;

?>