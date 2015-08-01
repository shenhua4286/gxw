<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//判断文件是否被非法调用
  exit('Access Denied');
}
$Pos=array('所有','群','私聊');
include("header.php");?>
<a href="?action=addlinks&cid=<?=$cid?>">添加顶部链接</a><br /><br />
<h1 style="color:#808080">所属群：<?=$db->select("channel","name","id='$cid'");?></h1>
<form action="save.php?action=dellinks2" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">选中</th>
    <th width="80">展示位置</th>
    <th width="80">GIF图标</th>
    <th width="80">链接文字</th>
    <th width="80">链接地址</th>
    <th width="80">截止日期</th>
    <th>操作</th>
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
    <td align="left"><a href="index.php?action=editlinks&id=<?=$id?>&cid=<?=$cid?>">编辑</a> | <a href="javascript:del(<?=$cid?>,<?=$id?>)" style="color:red">删除</a></td>
  </tr>
<?}?>
</table>
<br />
<?=SetInput("button","button"," 全选 ","onclick=\"CheckAll(form,'all')\"")?> 
<?=SetInput("button","button"," 反选 ","onclick=\"CheckAll(form,'other')\"")?> 
<?=SetInput("button","button"," 清除 ","onclick=\"CheckAll(form,'clear')\"")?> 
<?=SetInput("button","button"," 删除选中记录 ","onclick=\"if(confirm('您确定要删除所有选中记录吗？')){myform.submit();}\"")?>
</form>
<br /><?=$links[1]?>
<script type="text/javascript">
function del(cid,id){
  if(confirm('您确定要删除此条记录吗？')){
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