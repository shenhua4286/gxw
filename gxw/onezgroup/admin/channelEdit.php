<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//判断文件是否被非法调用
  exit('Access Denied');
}
include("admin/header.php");?>
<form action="save.php?action=<?=$action?>" method="post" name="myform" onsubmit="return checkform(this)">
<table border="0" cellspacing="1" align="center" class="list">
  <tr>
  <th colspan=2 align="left">&nbsp;基本信息</th>
  </tr>
  <tr>
    <td width="150" align="right" height="20">群名称：</td>
    <td><input type="text" class="a" name="config[name]" value="<?=$channel['name']?>" /> 显示在群的标题处</td>
  </tr>
  <tr>
    <td height="20" align="right">所属用户:</td>
    <td align="left"><input type="text" class="a" name="config[username]" size="30" value="<?=$channel['username']?>"></td>
  </tr>
  <tr>
    <td height="20" align="right"></td>
    <td align="left">
      <input type="checkbox" name="config[allowguest]" value="1" <?if($channel['allowguest']==1)echo' checked'?>> 允许访客进入
      <input type="checkbox" name="config[ifonly]" value="1" <?if($channel['ifonly']==1)echo' checked'?>> 不显示群窗口的边框（标题、最小化、关闭按钮等）
      <br />
      <input type="checkbox" name="config[savehistory]" value="1" <?if($channel['savehistory']==1)echo' checked'?>> 自动保存聊天记录到论坛上（需正确填写“快速发帖版块fid”）
    </td>
  </tr>
  <tr>
    <td height="20" align="right">群风格样式:</td>
    <td align="left"><select name="config[theme]"><?$tplpath='../themes';
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file)) {
          $s=$channel['theme']==$file?' selected':'';
          echo "<option value=\"$file\"$s>$file</option>";
        }
      }
    }
    closedir($dh);?></select></td>
  </tr>
  <tr>
    <td height="20" align="right">最大在线人数:</td>
    <td align="left"><input type="text" class="b" name="config[maxusr]" value="<?=$channel['maxusr']?>"> 人。-1为不限制</td>
  </tr>
  <tr>
    <td height="20" align="right">快速发帖版块fid:</td>
    <td align="left"><input type="text" class="b" name="config[forumid]" value="<?=$channel['forumid']?>"> 0为不使用</td>
  </tr>
  <tr>
    <td height="20" align="right">快速发帖版块描述:</td>
    <td align="left"><input type="text" class="a" name="config[forumname]" value="<?=$channel['forumname']?>"></td>
  </tr>
  <tr>
    <td height="20" align="right">管理员列表:</td>
    <td align="left"><input type="text" class="a" name="config[masters]" value="<?=$channel['masters']?>"> 多个请用逗号分隔</td>
  </tr>
  <tr>
    <td height="20" align="right">过期时间:</td>
    <td align="left"><input type="text" class="a" name="config[exptime]" value="<?=$channel['exptime']<=0?'-1':date('Y-m-d H:i:s',$channel['exptime'])?>"> 如:<font color=red><?=$now?></font>。-1为永不过期</td>
  </tr>
  <tr>
  <th colspan=2 align="left">&nbsp;相关提示语</th>
  </tr>
  <tr>
  <td align="right" height="20">群公告：</td>
  <td><textarea name="config[notice]" rows="10" cols="60"><?=$channel['notice']?></textarea></td>
  </tr>
  <tr>
  <td width="150" align="right" height="20"></td>
  <td><font color=red>{user}</font>表示用户名，如果填写多条则随机抽取</td>
  </tr>
  <tr>
  <td align="right" height="20">有人进入：</td>
  <td><textarea name="config[word_in]" rows="10" cols="60"><?=$channel['word_in']?></textarea></td>
  </tr>
  <tr>
  <td align="right" height="20">有人离开：</td>
  <td><textarea name="config[word_out]" rows="10" cols="60"><?=$channel['word_out']?></textarea></td>
  </tr>
  <tr>
    <td height="30" align="right"></td>
    <td align="left">
      <input type="hidden" name="icon" value="<?=$icon?>">
      <input type="hidden" name="id" value="<?=$id?>">
      <?=setinput("submit","submit",$btn)?> 
    </td>
  </tr>
</table>
</form>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript">
function checkform(theform){
  return true;
}
</script><?include("admin/footer.php");?>