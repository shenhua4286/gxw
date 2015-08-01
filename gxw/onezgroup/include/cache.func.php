<?php
//机器人
function Robot($force=0,$time=1800){
  global $Bot,$BotList;
  if($force==1){
    @unlink(ONEZ_ROOT.'./onezdata/cache/robot.php');
  }
  if(time()-@filemtime(ONEZ_ROOT.'./onezdata/cache/robot.php')>$time){
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
      db_local();
      $db=new onez_db;
    }
    $Bot=$BotList=array();
    $Table=$db->record("robot","*","1",1);
    foreach($Table as $rs){
      unset($Con);
      @include_once(ONEZ_ROOT.'./plugins/robot/'.$rs['botid'].'/config.php');
      if($Con){
        $Bot[$rs['botid']]=array(
                            'name'=>$Con['name'],
                            'width'=>intval($Con['width']),
                            'height'=>intval($Con['height']),
                            'style'=>$Con['style'],
                            'readme'=>$Con['readme'],
                          );
        if(is_array($Con['method'])){
          foreach($Con['method'] as $v){
            $BotList[$v][]=$rs['botid'];
          }
        }else{
          $BotList[$Con['method']][]=$rs['botid'];
        }
      }
    }
    mkdirs(ONEZ_ROOT.'./onezdata/cache');
    writeover(ONEZ_ROOT.'./onezdata/cache/robot.php','<?php
  $Bot='.var_export($Bot,true).';
  $BotList='.var_export($BotList,true).';
  ?>');
  }else{
    include(ONEZ_ROOT.'./onezdata/cache/robot.php');
  }
}
//链接
function Links($force=0,$time=1800){
  global $links;
  if($force==1){
    @unlink(ONEZ_ROOT.'./onezdata/cache/links.php');
  }
  if(time()-@filemtime(ONEZ_ROOT.'./onezdata/cache/links.php')>$time){
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
      $db=new onez_db;
    }
    $links=$db->record("links","adpos,icon,title,linkurl","endtime>".time()." and ifdefault=1 order by id desc");
    mkdirs(ONEZ_ROOT.'./onezdata/links');
    writeover(ONEZ_ROOT.'./onezdata/cache/links.php','<?php
  $links='.var_export($links,true).';
  ?>');
  }else{
    include(ONEZ_ROOT.'./onezdata/cache/links.php');
  }
}
//聊天频道
function Channel(&$channelKey,$force=0,$time=1800){
  global $Channel,$db,$mastername;
  if($force==1){
    @unlink(ONEZ_ROOT.'./onezdata/cache/channel/'.$channelKey.'.php');
  }
  if(!$channelKey || time()-@filemtime(ONEZ_ROOT.'./onezdata/cache/channel/'.$channelKey.'.php')>$time){
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
      db_local();
      $db=new onez_db;
    }
    $Table=$db->record("channel","*","id='$channelKey'",1);
    if(!$Table){
      $Table=$db->record("channel","*","ifdefault=1",1);
      if(!$Table){
        $arr=array(
          'name'=>'官方默认群',
          'username'=>$mastername,
          'level'=>'-1',
          'maxusr'=>'-1',
          'allowguest'=>'0',
          'forumid'=>'0',
          'forumname'=>'',
          'addtime'=>time(),
          'exptime'=>'-1',
          'ifdefault'=>'1',
          'ifonly'=>'0',
          'notice'=>'',
          'theme'=>'QQ2009',
        );
        $db->insert("channel",$arr);
        $Table=$db->record("channel","*","ifdefault=1",1);
      }
    }
    $Channel=$Table[0];
    $Channel['links']=$db->record("links","adpos,icon,title,linkurl","(endtime<1 or endtime>".time().") and cid='$Channel[id]' order by id desc");
    $channelKey=$Channel['id'];
    if(!$channelKey)exit('INIT ERROR!');
    mkdirs(ONEZ_ROOT.'./onezdata/cache/channel');
    writeover(ONEZ_ROOT.'./onezdata/cache/channel/'.$channelKey.'.php','<?php
  $Channel='.var_export($Channel,true).';
  ?>');
  }else{
    include(ONEZ_ROOT.'./onezdata/cache/channel/'.$channelKey.'.php');
  }
}
?>