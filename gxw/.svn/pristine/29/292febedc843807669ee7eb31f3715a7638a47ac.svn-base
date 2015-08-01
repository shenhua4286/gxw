<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//判断文件是否被非法调用
  exit('Access Denied');
}
include("admin/header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">群ID</th>
    <th>群名称</th>
    <th>默认群</th>
    <th>所属用户</th>
    <th>最大人数</th>
    <th>在线人数</th>
    <th>允许游客</th>
    <th>过期时间</th>
    <th>操作</th>
  </tr>
<?foreach($channels[0] as $rs){
$id=$rs['id'];?>
  <tr align="left">
    <td height="20"><?=$id?></td>
    <td><?=$rs["name"]?></td>
    <td><?=$rs["ifdefault"]==1?'<font color=red>√</font>':'<font color=gray>×</font>'?></td>
    <td><?=$rs["username"]?></td>
    <td><?=$rs["maxusr"]==-1?'<font color=blue>不限</font>':$rs["maxusr"]?></td>
    <td><font color=green><?=Online($id)?></font></td>
    <td><?=$rs["allowguest"]==1?'<font color=red>是</font>':'<font color=green>否</font>'?></td>
    <td><?=$rs["exptime"]=-1?'<font color=green>永不过期</font>':date('Y-m-d H:i:s',$rs["exptime"])?></td>
    <td align="left">
    <?=$rs["ifdefault"]==1?'<a href="save.php?action=setchannel&s=0&id='.$id.'">取消默认</a>':'<a href="save.php?action=setchannel&s=1&id='.$id.'">设为默认</a>'?> | 
    <a href="../index.php?channelid=<?=$id?>" target="_blank">进入</a> | <a href="index.php?action=links&cid=<?=$id?>">广告</a> | <a href="index.php?action=editchannel&id=<?=$id?>">编辑</a> | <a href="javascript:del(<?=$id?>)" style="color:red">删除</a></td>
  </tr>
<?}?>
</table>
</form>
<br /><?=$channels[1]?>
<script type="text/javascript">
function del(id){
  if(confirm('您确定要删除此群吗？')){
    location.href="save.php?action=delchannel&id="+id;
  }
}
</script>
<?include("admin/footer.php");?>