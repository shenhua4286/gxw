<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("admin/header.php");?>
<form action="save.php?action=config&ac=sec" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;更新相关</th>
</tr>
<tr>
<td width="150" align="right" height="20">主更新：</td>
<td><input type="text" class="b" name="config[sec_update]" value="<?=$setting['sec_update']?>" /> 秒。在群里多少秒读取下一次消息</td>
</tr>
<tr>
<td align="right" height="20">次更新：</td>
<td><input type="text" class="b" name="config[sec_update2]" value="<?=$setting['sec_update2']?>" /> 秒。在私聊里多少秒读取下一次消息</td>
</tr>
<tr>
<td align="right" height="20">列表更新：</td>
<td><input type="text" class="b" name="config[sec_list]" value="<?=$setting['sec_list']?>" /> 秒。在群里多少秒更新一次列表</td>
</tr>
<tr>
<td align="right" height="20">是否在线：</td>
<td><input type="text" class="b" name="config[sec_online]" value="<?=$setting['sec_online']?>" /> 秒。多少秒不更新显示离线</td>
</tr>
<tr>
<td align="right" height="20">短消息：</td>
<td><input type="text" class="b" name="config[sec_msg]" value="<?=$setting['sec_msg']?>" /> 秒。每隔多少秒检测一次短消息</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;聊天记录</th>
</tr>
<tr>
<td align="right" height="20">定时删除聊天记录：</td>
<td><input type="text" class="a" name="config[delhistory]" style="width:50px" value="<?=$setting['delhistory']?>" /> 秒之前</td>
</tr>
<tr>
<td align="right" height="20">定时删除图片和截图：</td>
<td><input type="text" class="a" name="config[delpic]" style="width:50px" value="<?=$setting['delpic']?>" /> 秒之前</td>
</tr>
<tr>
<td align="right" height="20">定时删除聊天附件：</td>
<td><input type="text" class="a" name="config[delfile]" style="width:50px" value="<?=$setting['delfile']?>" /> 秒之前</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;其他设置</th>
</tr>
<tr>
<td align="right" height="20">过滤字符：</td>
<td><textarea name="config[badwords]" rows="10" cols="60"><?=$setting['badwords']?></textarea><br />
相应的字符将被替换为*号，每行填写一个
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td><input type="submit" name="submit" value="保存修改" class="btn1" /></td>
</tr>
</table>
</form>
<?include("admin/footer.php");?>