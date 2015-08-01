<?php
if(!defined('IN_ONEZ') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("admin/header.php");
$onezdata='Y';
mkdirs('../onezdata/onez/cn');
if(!is_dir('../onezdata/onez/cn')){
  $onezdata='无创建子目录的权限';
}else{
  @touch('../onezdata/onez/cn/index.htm');
  if(!file_exists('../onezdata/onez/cn/index.htm')){
    $onezdata='无写文件的权限';
  }else{
    @unlink('../onezdata/onez/cn/index.htm');
    if(file_exists('../onezdata/onez/cn/index.htm')){
      $onezdata='无删除文件的权限';
    }else{
      @rmdir('../onezdata/onez/cn');
      @rmdir('../onezdata/onez');
      if(is_dir('../onezdata/onez')){
        $onezdata='无删除子目录的权限';
      }
    }
  }
}
?>

<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;运行环境分析</th>
</tr>
<tr>
<td width="150" align="right" height="20">相关函数：</td>
<td>iconv:<?=function_exists('iconv')?'<font color=green>支持</font>':'<font color=red>不支持</font>'?></td>
</tr>
<tr>
<td align="right" height="20">读写权限：</td>
<td>/onezdata目录 <?=$onezdata=='Y'?'<font color=green>正常</font>':'<font color=red>'.$onezdata.'</font>'?></td>
</tr>
</table>
<?include("admin/footer.php");?>