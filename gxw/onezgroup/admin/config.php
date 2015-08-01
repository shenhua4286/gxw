<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("admin/header.php");?>
<form action="save.php?action=config&ac=config" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;基本设置</th>
</tr>
<tr>
<td width="150" align="right" height="20">网站名称：</td>
<td><input type="text" class="a" name="config[homename]" value="<?=$setting['homename']?>" /> 显示在网站首页</td>
</tr>
<tr>
<td align="right" height="20">程序网址：</td>
<td><input type="text" class="a" name="config[homepage]" value="<?=$setting['homepage']?>" /> 必须正确填写，最后不能以“/”结尾</td>
</tr>
  <tr>
    <td height="20" align="right">默认群风格样式:</td>
    <td align="left"><select name="config[theme]"><?$tplpath='../themes';
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file)) {
          $s=$setting['theme']==$file?' selected':'';
          echo "<option value=\"$file\"$s>$file</option>";
        }
      }
    }
    closedir($dh);?></select></td>
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