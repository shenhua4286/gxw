<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//�ж��ļ��Ƿ񱻷Ƿ�����
  exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">��ʶ</th>
    <th>����������</th>
    <th>��������;</th>
    <th>״̬</th>
    <th>����</th>
  </tr>
<?
$dh=opendir($tplpath);
while ($file=readdir($dh)) {
  if($file!="." && $file!="..") {
    if(is_dir($tplpath.'/'.$file)) {
    unset($Con);
    include($tplpath.'/'.$file.'/config.php');
    if($Con){
$installed=$db->rows("robot","botid='$file'")>0;
    ?>
  <tr align="left">
    <td height="20" style="<?=is_numeric($file)?'color:red':'color:green'?>"><?=$file?></td>
    <td><?=$Con["name"]?></td>
    <td><?=$Con["readme"]?></td>
    <td><?=$installed?'<font color=green>�Ѱ�װ</font>':'<font color=gray>δ��װ</font>'?></td>
    <td><?=$installed?'<a href="../robot.php?botid='.$file.'" target="_blank">�Ի�</a> | <a href="javascript:uninstall(\''.$file.'\')">ж��</a>':'<a href="javascript:install(\''.$file.'\')">��װ</a>'?></td>
  </tr>
<?
}
        }
      }
    }
    closedir($dh);?>
</table>
<script type="text/javascript">
function uninstall(id){
  if(confirm('��ȷ��Ҫж�ش˲����')){
    location.href="save.php?action=robot&s=uninstall&botid="+id;
  }
}
function install(id){
  if(confirm('��ȷ��Ҫ��װ�˲����')){
    location.href="save.php?action=robot&s=install&botid="+id;
  }
}
</script>
<?include("footer.php");?>