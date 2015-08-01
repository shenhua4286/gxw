<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {//判断文件是否被非法调用
  exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
  <tr align="center">
    <th width="50">标识</th>
    <th>机器人名称</th>
    <th>机器人用途</th>
    <th>状态</th>
    <th>操作</th>
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
    <td><?=$installed?'<font color=green>已安装</font>':'<font color=gray>未安装</font>'?></td>
    <td><?=$installed?'<a href="../robot.php?botid='.$file.'" target="_blank">对话</a> | <a href="javascript:uninstall(\''.$file.'\')">卸载</a>':'<a href="javascript:install(\''.$file.'\')">安装</a>'?></td>
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
  if(confirm('您确定要卸载此插件吗？')){
    location.href="save.php?action=robot&s=uninstall&botid="+id;
  }
}
function install(id){
  if(confirm('您确定要安装此插件吗？')){
    location.href="save.php?action=robot&s=install&botid="+id;
  }
}
</script>
<?include("footer.php");?>