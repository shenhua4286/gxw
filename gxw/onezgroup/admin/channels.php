<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//�ж��ļ��Ƿ񱻷Ƿ�����
  exit('Access Denied');
}
include("admin/header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">ȺID</th>
    <th>Ⱥ����</th>
    <th>Ĭ��Ⱥ</th>
    <th>�����û�</th>
    <th>�������</th>
    <th>��������</th>
    <th>�����ο�</th>
    <th>����ʱ��</th>
    <th>����</th>
  </tr>
<?foreach($channels[0] as $rs){
$id=$rs['id'];?>
  <tr align="left">
    <td height="20"><?=$id?></td>
    <td><?=$rs["name"]?></td>
    <td><?=$rs["ifdefault"]==1?'<font color=red>��</font>':'<font color=gray>��</font>'?></td>
    <td><?=$rs["username"]?></td>
    <td><?=$rs["maxusr"]==-1?'<font color=blue>����</font>':$rs["maxusr"]?></td>
    <td><font color=green><?=Online($id)?></font></td>
    <td><?=$rs["allowguest"]==1?'<font color=red>��</font>':'<font color=green>��</font>'?></td>
    <td><?=$rs["exptime"]=-1?'<font color=green>��������</font>':date('Y-m-d H:i:s',$rs["exptime"])?></td>
    <td align="left">
    <?=$rs["ifdefault"]==1?'<a href="save.php?action=setchannel&s=0&id='.$id.'">ȡ��Ĭ��</a>':'<a href="save.php?action=setchannel&s=1&id='.$id.'">��ΪĬ��</a>'?> | 
    <a href="../index.php?channelid=<?=$id?>" target="_blank">����</a> | <a href="index.php?action=links&cid=<?=$id?>">���</a> | <a href="index.php?action=editchannel&id=<?=$id?>">�༭</a> | <a href="javascript:del(<?=$id?>)" style="color:red">ɾ��</a></td>
  </tr>
<?}?>
</table>
</form>
<br /><?=$channels[1]?>
<script type="text/javascript">
function del(id){
  if(confirm('��ȷ��Ҫɾ����Ⱥ��')){
    location.href="save.php?action=delchannel&id="+id;
  }
}
</script>
<?include("admin/footer.php");?>