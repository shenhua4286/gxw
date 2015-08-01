<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config&ac=api" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;接口设置</th>
</tr>
<tr>
<td width="150" align="right" height="20">接口类型：</td>
<td style="color:red;font-weight:bold;font-size:13px"><?=$apitype?></td>
</tr>
<tr>
<td align="right" height="20">接口网址：</td>
<td><input type="text" class="a" name="config[apiurl]" value="<?=$setting['apiurl']?>" /> 您要整合的程序网址,不要以<font color=red>/</font>结尾</td>
</tr>
<tr>
<td align="right" height="20">注册地址：</td>
<td><input type="text" class="a" name="config[regurl]" value="<?=$setting['regurl']?>" /></td>
</tr>
<tr>
<td align="right" height="20">用户资料地址：</td>
<td><input type="text" class="a" name="config[ViewUserUrl]" value="<?=$setting['ViewUserUrl']?>" /> 用<font color=red>*</font>代表用户UID</td>
</tr>
<?if($apitype=='ucenter' || $apitype=='discuz'){
preg_match("/\/\/([\*]+)UCenter Start([\*|\r|\n]+)((.|\n)+?)\/\/([\*]+)UCenter End([\*|\r|\n]+)/i",@readover('../config.inc.php'),$arr);
$uc_config=$arr[3];?>
<tr>
<th colspan=2 align="left">&nbsp;UCenter信息</th>
</tr>
<tr>
<td align="right" height="20"></td>
<td><textarea name="uc_config" rows="15" cols="60"><?=$uc_config?></textarea></td>
</tr>
<?}?>
<tr>
<td align="right" height="20"></td>
<td><input type="submit" name="submit" value="保存修改" class="btn1" /></td>
</tr>
</table>
</form>
<?include("footer.php");?>