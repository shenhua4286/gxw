<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//判断文件是否被非法调用
  exit('Access Denied');
}
include("admin/header.php");?>
<script type="text/javascript" src="../js/title.js"></script>
<style type="text/css">
#icon img{
  float:left;
  margin:4px;
  width:16px;
  height:16px;
  filter:gray;
  cursor:pointer;
}
#icon img.sel{
  filter:;
  margin:3px;
  border:1px solid #ff0000;
}
</style>
<h1 style="color:#808080">所属群：<?=$db->select("channel","name","id='$cid'");?></h1>
<form action="save.php?action=<?=$action?>" method="post" name="myform" onsubmit="return checkform(this)">
<table border="0" cellspacing="1" align="center" class="list">
  <tr>
    <td width="150" height="20" align="right"><font color="red">*</font> 展示位置:</td>
    <td align="left"><input type="radio" name="adpos" value="0"<?if($adpos=="0")echo" checked"?>>所有 <input type="radio" name="adpos" value="1"<?if($adpos=="1")echo" checked"?>>仅群顶部 <input type="radio" name="adpos" value="2"<?if($adpos=="2")echo" checked"?>>仅私聊对话框顶部 </td>
  </tr>
  <tr>
    <td height="20" align="right">GIF图标:</td>
    <td align="left" id="icon">
<?$curIcon=0;
for($i=0;$i<count($Icon);$i++){
if(end(explode("/",$icon))==$Icon[$i]){
  $s=' class="sel"';
  $curIcon=$i;
}else{
  $s='';
}
?>
<img src="../images/link/<?=$Icon[$i]?>" id="icon<?=$i?>"<?=$s?> onclick="SelIcon(<?=$i?>)" title="<img src=../images/link/<?=$Icon[$i]?>>" />
<?}?></td>
  </tr>
  <tr>
    <td height="20" align="right">链接文字:</td>
    <td align="left"><input type="text" class="a" name="title" size="30" value="<?=$ti?>"></td>
  </tr>
  <tr>
    <td height="20" align="right"><font color="red">*</font> 链接地址:</td>
    <td align="left"><input type="text" class="a" name="linkurl" size="30" value="<?=$linkurl?>"></td>
  </tr>
  <tr>
    <td height="20" align="right">截止日期:</td>
    <td align="left"><input type="text" class="a" name="endtime" size="30" value="<?=$endtime?>"></td>
  </tr>
  <tr>
    <td height="30" align="right"></td>
    <td align="left">
      <input type="hidden" name="icon" value="<?=$icon?>">
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="hidden" name="cid" value="<?=$cid?>">
      <?=setinput("submit","submit",$btn)?> 
    </td>
  </tr>
</table>
</form>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript">
var curIcon=<?=$curIcon?>;
function SelIcon(id){
  try{$('icon'+curIcon).className=''}catch(e){}
  $('icon'+id).className='sel';
  curIcon=id;
  myform.icon.value=$('icon'+curIcon).src;
}
SelIcon(curIcon);
function checkform(theform){
  var isSel=false;
  for (var i=0;i<theform.elements.length;i++){
    var t = theform.elements[i];
    if(t.name=="adpos"){
      if(t.checked){
        isSel=true;
        break;
      }
    }
  }
  if(!isSel){
    alert("请正确选择展示位置");
    return false;
  }
  if(theform.linkurl.value.length<1){
    alert("链接地址不能为空");
    theform.linkurl.focus();
    return false;
  }
  return true;
}
</script><?include("admin/footer.php");?>