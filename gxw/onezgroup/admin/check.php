<?
@include_once("../include/common.inc.php");
include_once("../include/db_mysql.class.php");
$db=new onez_db;
foreach(API_Config() as $k=>$v)$$k=$v;
if($mastername!=$username){
  ero('您不是本站管理员，不能进行此项操作','../');
}
$T=$db->record("channel","id,name","ifdefault=1");
$Menu=array(//超级管理菜单
        array('常规设置',
           array(
            'main'=>'管理首页',
            'config'=>'基本设置',
            'api'=>'整合接口设置',
            'sec'=>'间隔设置',
           )
        ),
        array('频道管理',
           array(
            'channels'=>'全部频道列表',
            'addchannel'=>'添加新频道',
            'editchannel&id='.$T[0]['id']=>'<font color=blue>'.$T[0]['name'].'</font>',
           )
        ),
        array('机器人管理',
           array(
            'robots'=>'机器人列表',
           )
        ),
        array('<font color=red>最新版本</font>','http://www.onez.cn/'),
        array('<font color=red>帮助中心</font>','http://www.onez.cn/thread.php?fid=10'),

);
?>