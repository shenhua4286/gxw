<?php
include_once('include/common.inc.php');
@include_once('plugins/robot/limit/config.php');
$action=Char_Cv('action','get');
if($action){//自动接收群信息
  $ChannelId=Char_Cv('ChannelId');//群编号
  $msg=Char_Cv('msg');//用户消息
  $msg=oiconv('utf-8','gbk',$msg);//用户消息
  
  $A=array();
  foreach(explode("\n",$BadWords) as $v){
    $v=Trim($v);
    if($v)$A[]=$v;
  }
  if(str_replace($A,'',$msg)!=$msg){
    echo $jsCode;
  }
  exit();
}
$step=intval(Char_Cv('step'));
$msg=Char_Cv('msg');
if($msg=='?'||$msg=='？'){//如果用户输入问号，重新初始化
  $step='0';
}
$A=array();
switch($step){
  case'0'://第一次
    $A[]='1';
    $A[]='';
    $A[]='您好，欢迎使用Onez智能聊天系统';
    break;
  case'1'://第二次
    $A[]='1';
    $A[]='';
    $A[]='请大家文明聊天';
    break;
}
echo implode("\n",$A);
?>