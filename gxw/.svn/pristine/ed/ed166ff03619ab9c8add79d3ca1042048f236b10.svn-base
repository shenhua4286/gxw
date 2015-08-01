<?php
include_once( "check.php" );
$client=intval(Char_Cv('client','get'));
Links();

$from=Char_Cv('from','get');
$uid=Char_Cv('uid','get');
if(substr($userid,0,1)=='_'){
  $user=array(
    'username'=>$guestname,
    'face'=>'images/guest.gif',
  );
}else{
  $user=API_Info($userid);
}
if(substr($uid,0,1)=='_'){
  $touser=array(
    'uid'=>$uid,
    'username'=>$guestname,
    'face'=>'images/guest.gif',
  );
}else{
  $touser=API_Info($uid);
}

//print_r($touser);

if(!$touser){
  exit('<script>alert("此用户不存在");window.parent.FrameClose("'.$_GET["onezid"].'")</script>');
}

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
$JS.="\nfunction CloseAllDiv(){".$closeobj."}";
include('header.php');
#print_r($touser);
?>
<div id="hiddenBox" style="position:absolute;top:-99999px;"></div>
<div class="toolbarbk">
<? if(is_array($links)) { foreach($links as $rs) { if($rs['adpos']=='0' || $rs['adpos']=='2') { ?>
<a href="<?=$rs['linkurl']?>" onfocus="this.blur()" target="_blank"><img src="<?=$rs['icon']?>" alt="<?=$rs['title']?>" /></a>
<? } } } ?>
</div>
<div class="mainTable">
  <div id="boxLeft">
    <div id="dtl"></div><div id="dtc"><div id="alertBox">交谈中请勿轻信汇款、中奖信息，勿轻易拨打陌生电话。</div></div><div id="dtr"></div>
    <div class="clear"></div>
    <div id="showbox" onclick="CloseAllDiv()"></div>
    <div id="toolbox"></div>
    <textarea id="inputbox" onkeydown="input_onkeydown(event)" onclick="CloseAllDiv()"></textarea>
    
    <div id="dbl"></div><div id="dbc"></div><div id="dbr"></div>
    <div class="clear"></div>
    <div id="btnbox">
      <div class="btn_hover" onmouseover="BtnDown(this)" onmouseout="BtnOver(this)" onclick="Send()">发送</div>
      <?if($client=='1'){?>
      <div class="btn_normal" onmouseover="BtnOver(this)" onmouseout="BtnNormal(this)" onclick="location.href='onez://close'">关闭</div>
      <?}else{?>
      <div class="btn_normal" onmouseover="BtnOver(this)" onmouseout="BtnNormal(this)" onclick="window.parent.FrameClose(onez_key)">关闭</div>
      <?}?>
    </div>
  </div>
  <div id="FaceA"><img src="<?=$touser['face']?>" /></div>
  <div id="FaceB"><img src="<?=$user['face']?>" /></div>
</div>
<div id="HotKey" onclick="SendKey(TheKey=='1'?'2':'1')"></div>
<?=$HTML?>
<script type="text/javascript">
//InsertFlash('onezdata/toolbar.swf','<?=$FlashVars?>','100%','100%','myToolbar','toolbox');
var client="<?=$client?>";
var userid="<?=$userid?>";
var nickname="<?=$user['username']?>";
var touid="<?=$touser['uid']?>";
var touser="<?=$touser['username']?>";
var from="<?=$from?>";
var homepage="<?=$homepage?>";
var sec_update2=<?=(int)($setting['sec_update2']*1000)?>;
var TheKey=getcookie('sendkey');

var e=document.createElement("embed");
e.id="thesound_msg";
e.setAttribute("src","sound/msg.wav");
e.setAttribute("autostart","false");
e.setAttribute("loop","false");
$('hiddenBox').appendChild(e);

<?=$JS?>
</script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
<script type="text/javascript" src="js/onezkey.js"></script>
<?php include('footer.php');?>