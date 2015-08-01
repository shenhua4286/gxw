<?php
include_once("include/common.inc.php");
$channel=Char_Cv("channel","get");
switch($action=Char_Cv('action','get')){
  case 'login':
    $usr=Char_Cv("usr");
    $pwd=Char_Cv("pwd");
    $api=API_Login($usr,$pwd);
    if($api!='Y')ero($api);
    exit('<script>top.location.href="index.php?channelid='.$channel.'";</script>');
    break;
}
if(!$groupname)$groupname="会员登陆";
if(!$webtitle=$homename)$webtitle=$groupname;

$banner=$loginbannerurl==''?'<img src="'.$loginbanner.'">':'<a href="'.$loginbannerurl.'" target="_blank"><img src="'.$loginbanner.'" border="0"></a>';
include('header.php');
?>
<div class="loginBanner"><?=$banner?></div>
<form action="login.php?action=login&channel=<?=$channel?>" name="loginform" method="post">
<table class="loginBg" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3" height="30" style="color:red" align="center" id="caption">欢迎使用OnezGroup系统</td>
</tr>
<tr>
<td width="85" height="35" class="formleft"></td>
<td width="80"><input type="text" name="usr" size="28" onkeypress="OnLoginKeyPress('uid')"></td>
<td></td>
</tr>
<tr>
<td height="36" class="formleft"></td>
<td colspan="2"><input type="password" name="pwd" size="28" onkeypress="OnLoginKeyPress('pwd')"></td>
</tr>
<tr>
<td colspan="3" align="left">&nbsp;</td>
</tr>
<tr>
<td colspan="3" height="10"> </td>
</tr>
</table>
</form>
<div class="bottomBtn">
  <div class="btn_hover" onmouseover="BtnDown(this)" onmouseout="BtnOver(this)" onclick="checkform(loginform)">登陆</div>
  <div class="btn_normal" onmouseover="BtnOver(this)" onmouseout="BtnNormal(this)" onclick="window.open('<?=$regurl?>','','')">注册</div>
</div>
</td>
</tr>
</table>
<script type="text/javascript">
function checkform(theform){
  if(theform.usr.value.length<1){
    $('caption').innerHTML="账号不能为空";
    theform.usr.focus();
    return false;
  }
  if(theform.pwd.value.length<1){
    $('caption').innerHTML="密码不能为空";
    theform.pwd.focus();
    return false;
  }
  theform.submit();
}
</script>
<?php include('footer.php');?>