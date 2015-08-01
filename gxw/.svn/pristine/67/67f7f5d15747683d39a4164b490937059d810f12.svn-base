<?php
include_once( "check.php" );
$only=intval(Char_Cv('only','get'));
$client=intval(Char_Cv('client','get'));
$channelid=intval(Char_Cv('channel','get'));
Channel($channelid);
if($Channel['allowguest']==0 && $userid==$guestname){
  exit('<script>top.location.href="login.php?channel='.$Channel['id'].'";</script>');
}  
if($Channel['maxusr']!=-1 && Online($channelid)>=$Channel['maxusr']){
  API_Logout();
  exit('<script>alert("本群人数已满");
  if(top!==self)top.location.reload();</script>');
}
$today=date('Ymd');
if($Channel['forumid'] && $Channel['lastday']!=$today){
  $api=API_Pub($bbsTitle,$bbsContent);
  list($tid,$url)=$api;
  $arr=array(
    'lasttid'=>$tid,
    'lastday'=>$today,
  );
  if(!$db){
    include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
    db_local();
    $db=new onez_db;
  }
  $db->reset();
  $db->update("channel",$arr,"id='$Channel[id]'");
  if($Conn)$Conn->reset();
  
  @unlink('onezdata/cache/channel/'.$Channel['id'].'.php');
}
if($Channel['username']==$username){
  $grade=28;
}elseif(in_array($username,explode(',',$Channel['masters']))){
  $grade=2;
}elseif($username){
  $grade=1;
}else{
  if($Channel['allowguest']==1){
    $grade=0;
  }else{
    API_Logout();
    exit('<script>if(top!==self)top.location.reload();</script>');
  }
}

@include_once('onezdata/cache/robot.php');
@include_once('plugins/toolbar.php');
if(is_array($ONLOAD))$ONLOAD=implode("\n",$ONLOAD);
if(is_array($SWFLOAD))$SWFLOAD=implode(";",$SWFLOAD);
if(is_array($closeobj))$closeobj=implode(";",$closeobj);
$JS.="\nfunction window_onload(){
  try{\$('inputbox').focus();
  }catch(e){}
  $ONLOAD
}";
$JS.="\nfunction SwfLoad(){".$SWFLOAD."}";
$JS.="\nfunction CloseAllDiv(){\$('UserInfo').style.display='none';".$closeobj."}";
include('header.php');

/*/数据库版
if(!$db){
  include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
  $db=new db;
}
$db->reset();
$msgIndex=(int)$db->select("message","id","token='G$Channel[id]' order by id desc");
*/
//非数据库版
$msgIndex=intval(@readover('onezdata/message/group/'.$Channel['id'].'.txt'));
while(file_exists('onezdata/message/group/'.$Channel['id'].'/'.($msgIndex+1).'.txt')){
  $msgIndex++;
}
@writeover('onezdata/message/group/'.$Channel['id'].'.txt',$msgIndex);

$host=$_SERVER['SERVER_NAME'];
$port=$_SERVER['SERVER_PORT'];
$fp = @fsockopen($host, $port, $errno, $errmsg,10);
@fputs($fp, "GET ".str_replace('group.php','api/auto.php',$PHP_SELF)." HTTP/1.1\r\nHost: $host:$port\r\n\r\n");
@fclose($fp);

#进入欢迎语
if($Channel['word_in']){
  $Words['in']=array();
  foreach(explode("\n",$Channel['word_in']) as $v){
    $v=Trim($v);
    if($v)$Words['in'][]=var_export($v,true);
  }
  $Words['in']=implode(',',$Words['in']);
}
#退出欢迎语
if($Channel['word_out']){
  $Words['out']=array();
  foreach(explode("\n",$Channel['word_out']) as $v){
    $v=Trim($v);
    if($v)$Words['out'][]=var_export($v,true);
  }
  $Words['out']=implode(',',$Words['out']);
}
?>
<div id="hiddenBox" style="position:absolute;top:-99999px;"></div>
<div class="toolbarbk">
<?if($Channel['username']==$username){?><a href="admin" onfocus="this.blur()" target="_blank"><img src="images/icon/Admin.gif" alt="进入管理" /></a><?}?>
<?if(substr($userid,0,1)!='_'){?><a href="#" onfocus="this.blur()" onclick="OpenFriend()"><img src="images/icon/Friend.gif" alt="我的好友" /></a><?}?>
<? if(is_array($Channel['links'])) { foreach($Channel['links'] as $rs) { if($rs['adpos']=='0' || $rs['adpos']=='1') { ?>
<a href="<?=$rs['linkurl']?>" onfocus="this.blur()" target="_blank"><img src="<?=$rs['icon']?>" alt="<?=$rs['title']?>" /></a>
<? } } } ?>
</div>
<div class="mainTable" id="mainTable">
  <div id="boxLeft">
    <div id="dtl"></div><div id="dtc"><div id="alertBox">交谈中请勿轻信汇款、中奖信息，勿轻易拨打陌生电话。</div></div><div id="dtr"></div>
    <div class="clear"></div>
    <div id="showbox" onclick="CloseAllDiv()"></div>
    <div id="toolbox"></div>
    <textarea id="inputbox" onkeydown="input_onkeydown(event)" onclick="CloseAllDiv()"></textarea>
    
    <div id="dbl"></div><div id="dbc"></div><div id="dbr"></div>
    <div class="clear"></div>
    <div id="btnbox">
      <div class="btn_hover" onmouseover="BtnDown(this)" onmouseout="BtnOver(this)" id="sendbtn" onclick="Send()">发送</div>
      <?if($Channel['forumid']){?>
      <div class="btn_normal" onmouseover="BtnOver(this)" onmouseout="BtnNormal(this)" title="快速发布帖子到“<?=$Channel['forumname']?>”版块" onclick="PubArticle()">快速发帖</div>
      <?}?>
    </div>
  </div>
  <div id="boxRight">
    <div class="t"></div>
    <div class="infobtn"><a href="javascript:void(0)" id="infobtnA" onclick="SetInfoBox('A')" onfocus="this.blur()">群动态</a></div>
    <div id="infoboxA" class="infobox"><div><?=onezcode($Channel['notice'])?></div></div>
    <div class="b"></div>
    <div class="lineA"></div>
    <div class="t"></div>
    <div class="infobtn"><a href="javascript:void(0)" id="infobtnB" onclick="SetInfoBox('B')" onfocus="this.blur()">群成员<span id="onlineusr"></span></a></div>
    <ul id="infoboxB" class="infobox" ondblclick="LoadList()">
    
      <?if(is_array($BotList[3])){ foreach($BotList[3] as $v){?>
        <li id="bot_<?=$v?>_<?=$Bot[$v]['name']?>_<?=$Bot[$v]['width']?>_<?=$Bot[$v]['height']?>"><span class="group_o"></span><span class="face"><img src="plugins/robot/<?=$v?>/face.gif" /></span><span class="name robot" style="<?=$Bot[$v]['style']?>"><?=$Bot[$v]['name']?></span></li>
      <?}}?>
    </ul>
    <div id="borderB" class="b"></div>
  </div>
</div>
<div id="HotKey" onclick="SendKey(TheKey=='1'?'2':'1')"></div>
<div id="UserInfo" class="Float">
  <img id="userinfo_face" class="face" src="" />
  <div id="userinfo_name" class="name"></div>
  <div id="userinfo_txt" class="txt"></div>
  <div id="userinfo_btns" class="masterbtns"></div>
</div>
<?=$HTML?>
<script type="text/javascript">
var Usrs={};
var Bots={};
//InsertFlash('onezdata/toolbar.swf','<?=$FlashVars?>','100%','100%','myToolbar','toolbox');
<?if(is_array($BotList[3])){ foreach($BotList[3] as $v){?>
Bots['<?=$v?>']={'username':'<?=$Bot[$v]['name']?>','grade':'2','face':'plugins/robot/<?=$v?>/face.gif','sex':'woman','readme':<?=var_export($Bot[$v]['readme'],true)?>};
<?}}?>
var IsLoaded=0;
function TryResize(){
  if(IsLoaded==0){
    try{ResetSize();}catch(e){}
    setTimeout('TryResize()',100);
  }
}
TryResize();

var Words={'in':[<?=$Words['in']?>],'out':[<?=$Words['out']?>]};
var userid="<?=$userid?>";
var nickname="<?=$username?>";
var homepage="<?=$homepage?>";
var grade=<?=$grade?>;
var ViewUserUrl='<?=$setting['ViewUserUrl']?>';
var msgIndex="<?=$msgIndex?>";
var only="<?=$only?>";
var client="<?=$client?>";
var ChannelId="<?=$Channel['id']?>";
var forumId="<?=$Channel['forumid']?>";
var forumName="<?=$Channel['forumname']?>";
var CreateUsr="<?=$Channel['username']?>";
var Masters=",<?=$Channel['masters']?>,";
var sec_update=<?=(int)($setting['sec_update']*1000)?>;
var sec_list=<?=(int)($setting['sec_list']*1000)?>;
var sec_online=<?=(int)($setting['sec_online']*1000)?>;
var sec_msg=<?=(int)($setting['sec_msg']*1000)?>;
var Friends=",<?=API_LsFriend()?>,";
var RevcBot=[<?=is_array($BotList[5])?("'".implode("','",$BotList[5])."'"):''?>];
var robotCount=<?=is_array($BotList[3])?count($BotList[3]):0?>;
var TheKey=getcookie('sendkey');
<?=$JS?>
</script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/group.js"></script>
<script type="text/javascript" src="js/onezkey.js"></script>
<?php include('footer.php');?>