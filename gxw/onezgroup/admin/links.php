<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//�ж��ļ��Ƿ񱻷Ƿ�����
  exit('Access Denied');
}
$Pos=array('����','Ⱥ','˽��');
include("header.php");?>
<a href="?action=addlinks&cid=<?=$cid?>">��Ӷ�������</a><br /><br />
<h1 style="color:#808080">����Ⱥ��<?=$db->select("channel","name","id='$cid'");?></h1>
<form action="save.php?action=dellinks2" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">ѡ��</th>
    <th width="80">չʾλ��</th>
    <th width="80">GIFͼ��</th>
    <th width="80">��������</th>
    <th width="80">���ӵ�ַ</th>
    <th width="80">��ֹ����</th>
    <th>����</th>
  </tr>
<?foreach($links[0] as $rs){
$id=$rs['id'];?>
  <tr align="left">
    <td height="20"><?=SetInput("checkbox","id[]",$id)?></td>
    <td><?=$Pos[$rs["adpos"]]?></td>
    <td><img width="24" height="24" src="<?=$rs["icon"]?>" /></td>
    <td align="left"><a href="index.php?action=editlinks&id=<?=$id?>&cid=<?=$cid?>"><?=$rs["title"]?></a></td>
    <td align="left"><?=$rs["linkurl"]?></td>
    <td align="left"><?=date('Y-m-d H:i:s',$rs["endtime"]);?></td>
    <td align="left"><a href="index.php?action=editlinks&id=<?=$id?>&cid=<?=$cid?>">�༭</a> | <a href="javascript:del(<?=$cid?>,<?=$id?>)" style="color:red">ɾ��</a></td>
  </tr>
<?}?>
</table>
<br />
<?=SetInput("button","button"," ȫѡ ","onclick=\"CheckAll(form,'all')\"")?> 
<?=SetInput("button","button"," ��ѡ ","onclick=\"CheckAll(form,'other')\"")?> 
<?=SetInput("button","button"," ��� ","onclick=\"CheckAll(form,'clear')\"")?> 
<?=SetInput("button","button"," ɾ��ѡ�м�¼ ","onclick=\"if(confirm('��ȷ��Ҫɾ������ѡ�м�¼��')){myform.submit();}\"")?>
</form>
<br /><?=$links[1]?>
<script type="text/javascript">
function del(cid,id){
  if(confirm('��ȷ��Ҫɾ��������¼��')){
    location.href="save.php?action=dellinks&cid="+cid+"&id="+id;
  }
}
function CheckAll(form,s){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.name != 'checkbox'){
      if(s=="all"){
        e.checked=true;
      }else if(s=="clear"){
        e.checked=false;
      }else{
        e.checked=!e.checked;
      }
    }
  }
}
</script>
<?include("footer.php");?>