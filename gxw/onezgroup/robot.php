<?php

include_once( "include/common.inc.php" );

function _exit($msg){
  exit('<script>alert("'.$msg.'");if(top!==self)top.location.href="http://www.onez.cn";</script>');
}
$client=Char_Cv('client','get');
$from=Char_Cv('from','get');
$botid=Char_Cv('botid','get');
file_exists('plugins/robot/'.$botid.'/config.php') || _exit('此用户不存在');
include_once('plugins/robot/'.$botid.'/config.php');
if($Con['theme'])$skin=$Con['theme'];
include('header.php');
?>
<div id="hiddenBox" style="position:absolute;top:-99999px;"></div>
<div class="toolbarbk">
<? if(is_array($links)) { foreach($links as $rs) { if($rs['adpos']=='0' || $rs['adpos']=='2') { ?>
<a href="<?=$rs['linkurl']?>" onfocus="this.blur()" target="_blank"><img src="<?=$rs['icon']?>" alt="<?=$rs['title']?>" /></a>
<? } } } ?>
</div>
<div class="mainTable">
  <div id="boxLeft">
    <div id="dtl"></div><div id="dtc"><div id="alertBox"><?=$Con['tip']?></div></div><div id="dtr"></div>
    <div class="clear"></div>
    <div id="showbox" onclick="CloseAllDiv()"><div><?=$Con['default']?></div></div>
    <div id="toolbox"></div>
    <textarea id="inputbox" onkeydown="input_onkeydown(event)" onkeyup="input_onkeyup(event)" onclick="CloseAllDiv()"></textarea>
    
    <div id="dbl"></div><div id="dbc"></div><div id="dbr"></div>
    <div class="clear"></div>
    <div id="btnbox">
      <div class="btn_hover" onmouseover="BtnDown(this)" onmouseout="BtnOver(this)" onclick="Send()">发送</div>
      <div class="btn_normal" onmouseover="BtnOver(this)" onmouseout="BtnNormal(this)" onclick="window.parent.FrameClose(onez_key)">关闭</div>
    </div>
  </div>
  <div id="FaceA"><img src="<?='plugins/robot/'.$botid.'/face.gif'?>" /></div>
  <?if($Con['myface']==1){?><div id="FaceB"><img src="<?=$user['face']?>" /></div><?}?>
</div>
<div id="HotKey" onclick="SendKey(TheKey=='1'?'2':'1')"></div>
<?=$Con['html']?>
<script type="text/javascript">
InsertFlash('onezdata/toolbar.swf','<?=$FlashVars?>','100%','100%','myToolbar','toolbox');
var from="<?=$from?>";
var nickname="<?=$user['username']?>";
var botid="<?=$botid?>";
var botname="<?=$Con['name']?>";
var homepage="<?=$homepage?>";
var TheKey=getcookie('sendkey');
var e=document.createElement("embed");
e.id="thesound_msg";
e.setAttribute("src","sound/msg.wav");
e.setAttribute("autostart","false");
e.setAttribute("loop","false");
$('hiddenBox').appendChild(e);
<?=$Con['js']?>
</script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/robot.js"></script>
<?php include('footer.php');?>