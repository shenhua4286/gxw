<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config&ac=api" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;�ӿ�����</th>
</tr>
<tr>
<td width="150" align="right" height="20">�ӿ����ͣ�</td>
<td style="color:red;font-weight:bold;font-size:13px"><?=$apitype?></td>
</tr>
<tr>
<td align="right" height="20">�ӿ���ַ��</td>
<td><input type="text" class="a" name="config[apiurl]" value="<?=$setting['apiurl']?>" /> ��Ҫ���ϵĳ�����ַ,��Ҫ��<font color=red>/</font>��β</td>
</tr>
<tr>
<td align="right" height="20">ע���ַ��</td>
<td><input type="text" class="a" name="config[regurl]" value="<?=$setting['regurl']?>" /></td>
</tr>
<tr>
<td align="right" height="20">�û����ϵ�ַ��</td>
<td><input type="text" class="a" name="config[ViewUserUrl]" value="<?=$setting['ViewUserUrl']?>" /> ��<font color=red>*</font>�����û�UID</td>
</tr>
<?if($apitype=='ucenter' || $apitype=='discuz'){
preg_match("/\/\/([\*]+)UCenter Start([\*|\r|\n]+)((.|\n)+?)\/\/([\*]+)UCenter End([\*|\r|\n]+)/i",@readover('../config.inc.php'),$arr);
$uc_config=$arr[3];?>
<tr>
<th colspan=2 align="left">&nbsp;UCenter��Ϣ</th>
</tr>
<tr>
<td align="right" height="20"></td>
<td><textarea name="uc_config" rows="15" cols="60"><?=$uc_config?></textarea></td>
</tr>
<?}?>
<tr>
<td align="right" height="20"></td>
<td><input type="submit" name="submit" value="�����޸�" class="btn1" /></td>
</tr>
</table>
</form>
<?include("footer.php");?>