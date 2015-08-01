<?
define('IN_ADMIN', TRUE);
include("check.php");
$action=Char_Cv('action','get');
$MenuIndex=Char_Cv('menu','get');
if(!$MenuIndex){
  if($action){
    foreach($Menu as $K=>$V){
      if(is_array($V[1])){
        foreach($V[1] as $k=>$v){
          if($k==$action){
            $MenuIndex=$K;
            break;
          }
        }
      }
    }
  }else{
    $MenuIndex=0;
  }
}
if($action=='editchannel' || $action=='addlinks' || $action=='links' || $action=='editlinks'){
  $MenuIndex=1;
}elseif($action=='vieworder' || $action=='order'){
  $MenuIndex=2;
}elseif($action=='pay'){
  $MenuIndex=3;
}
$ChildMenu=$Menu[$MenuIndex][1];
if(!$action){
  if($MenuIndex==1){
    $action='channels';
  }elseif($MenuIndex==2){
    $action='robots';
  }else{
    $action='main';
  }
}
if(strpos($action,'&')){
  header("location:index.php?action=$action");
  exit();
}
switch($action){
  case'main':
    $title='管理首页';
    include("main.php");
    break;
  case'config':
    $title='基本信息设置';
    include("config.php");
    break;
  case'sec':
    $title='间隔设置';
    include("sec.php");
    break;
  case'api':
    $title='接口设置';
    include("api.php");
    break;
  case'addchannel':
    $title='添加新频道';
    $btn='立即添加';
    $channel=array(
      'theme'=>$skin,
      'maxusr'=>'100',
      'forumid'=>'0',
      'notice'=>'',
    );
    $btn='立即添加';
    include("channelEdit.php");
    break;
  case'channels':
    $title='群频道管理';
    $channels=$db->page("channel","*","1 order by id desc",20,"index.php?action=$action&page=*");
    include("channels.php");
    break;
  case'editchannel':
    $title='编辑频道信息';
    $id=Char_Cv('id','get');
    if(!$id)ero('参数不正确','?action=channels');
    $channel=$db->record("channel","*","id=$id");
    if(!$channel)ero('您要编辑的资料不存在','index.php?action=channels');
    $channel=$channel[0];
    $btn='保存修改';
    include("channelEdit.php");
    break;
  case'links':
    $cid=Char_Cv("cid","get");
    $title='群顶部链接';
    $links=$db->page("links","id,adpos,icon,title,linkurl,endtime","1 order by id desc",20,"index.php?action=$action&page=*");
    include("links.php");
    break;
  case'addlinks':
    $cid=Char_Cv("cid","get");
    unset($adpos,$icon,$title,$linkurl);
    $adpos='0';
    $endtime=date("Y-m-d H:i:s",$time+30*86400);
    $title='添加链接';
    $btn='立即添加';
    $tplpath="../images/link";
    $Icon=array();
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($tplpath.'/'.$file)) {
          if(in_array(end(explode(".",$file)),array('gif','jpg','png'))){
            $Icon[]=$file;
          }
        }
      }
    }
    closedir($dh);
    include("linksEdit.php");
    break;
  case'editlinks':
    $cid=Char_Cv("cid","get");
    $id=Char_Cv('id','get');
    if(!$id)ero('参数不正确','?action=links');
    $links=$db->record("links","adpos,icon,title,linkurl,endtime","id=$id");
    if(!$links)ero('您要编辑的资料不存在','index.php?action=channels');
    foreach($links[0] as $k=>$v){
      $$k=$v;
    }
    $endtime=date('Y-m-d H:i:s',$endtime);
    $ti=$title;
    $title='编辑链接';
    $btn='保存修改';
    $tplpath="../images/link";
    $Icon=array();
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($tplpath.'/'.$file)) {
          if(in_array(end(explode(".",$file)),array('gif','jpg','png'))){
            $Icon[]=$file;
          }
        }
      }
    }
    closedir($dh);
    include("linksEdit.php");
    break;
  case'robots':
    $title='机器人管理';
    $tplpath="../plugins/robot";
    include("robots.php");
    break;
}
?>