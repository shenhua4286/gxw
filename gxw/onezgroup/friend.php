<?php
include_once( "check.php" );
$action=Char_Cv('action','get');
if($action=='del'){
  $uid=Char_Cv('uid','get');
  API_DelFriend($uid);
}
include('header.php');
$maxperpage=10;
$thispage=Char_Cv("page","get");
if ($thispage=="" || !is_numeric($thispage)){
  $thispage=1;
}
$thispage=intval($thispage);
$totalput=API_RowFriend();
if (($totalput %$maxperpage)==0){
  $PageCount=intval($totalput /$maxperpage);
}else{
  $PageCount=intval($totalput /$maxperpage+1);
} 
if($PageCount<$thispage)$thispage=$PageCount;
$Table[0]=API_ListFriend($page,$maxperpage,$totalput);
if($strs && substr($strs,0,1)!='&')$strs='&'.$strs;
for ($A=$k=$thispage>3 && $PageCount>5 ? $thispage - 2 : 1; $k<=($A+5>$PageCount ? $PageCount : $A+5); $k=$k+1){
  $ms=$ms."[<a href='".$pagename."?page=".$k.$strs."'>".($k==$thispage?'<b>'.$k.'</b>':$k)."</a>] "."\r\n";
}
$pagelist="��¼����:$totalput ҳ��: <b>$thispage</b>/{$PageCount} ÿҳ: $maxperpage <a href='".$pagename."?page=1".$strs."'>��ҳ</a> <a href='".$pagename."?page=".($$thispage>1?$thispage-1:1).$strs."'>��һҳ</a> ".$ms." <a href='".$pagename."?page=".($thispage<$PageCount?$thispage+1:$PageCount).$strs."'>��һҳ</a> <a href='".$pagename."?page=".$PageCount.$strs."'>βҳ</a>";
$Table[1]=$pagelist;
?>
<div id="friendbody">
<table cellpadding="0" cellspacing="0" width="100%" class="friendlist">
	<tr>
		<th>UID</th>
		<th>�ǳ�</th>
		<th>״̬</th>
		<th>����</th>
	</tr>
<?$k=0;
foreach($Table[0] as $rs){
$k++;
$class=$k % 2==0 ?'a':'b';
$online='����';
if(time()-@filemtime('onezdata/online/0/'.$rs['friendid'])<(int)$setting['sec_online']){
  $class.=' online';
  $online='����';
}
?>
	<tr>
		<td class="<?=$class?>"><?=$rs['friendid']?></td>
		<td class="<?=$class?>"><img src="<?=API_Face($rs['friendid'])?>" align="absmiddle" /> <?=$rs['username']?></td>
		<td class="<?=$class?>"><?=$online?></td>
		<td class="<?=$class?>"><a href="#" onclick="delFriend('<?=$rs['friendid']?>','<?=$rs['username']?>')" class="del">ɾ��</a> <a href="#" onclick="ToUsr('<?=$rs['friendid']?>')" class="send">����Ϣ</a> </td>
	</tr>
<?}?>
</table>
<div class="bottomBtn" id="btnbox">
  <?=$Table[1]?>
</div>
</div>
<script type="text/javascript">
var only="<?=$only?>";
var client="<?=$client?>";
_attachEvent(window,"load",function(){
  $('friendbody').style.height=document.documentElement.clientHeight-$('btnbox').offsetHeight+10+'px';
});
function ToUsr(uid){
  if(only=='1'){
    if(client=='1'){
      top.location.href='onez://dialog|'+uid;
    }else{
      window.open('dialog.php?from=bbs&uid='+uid,'dialog'+uid,'');
    }
  }else{
    top.OpenUserDialog(uid);
  }
}
function delFriend(uid,uname){
  if(confirm("��ȷ��Ҫɾ�����ѡ�"+uname+"����")){
    location.href="?action=del&page=<?=$page?>&uid="+uid;
  }
}
</script>
<?php include('footer.php');?>