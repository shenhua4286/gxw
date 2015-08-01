<?php
include_once('../include/common.inc.php');
if(time()-@filemtime('../onezdata/cache/auto.txt')<500)exit();
mkdirs('../onezdata/cache');
@touch('../onezdata/cache/auto.txt');
#删除聊天记录
if($setting['delhistory']){
  $onlinepath="../onezdata/message/group";
  if(is_dir($onlinepath)){
    $dh=opendir($onlinepath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($onlinepath.'/'.$file)) {
          $dh2=opendir($onlinepath.'/'.$file);
          while ($file2=readdir($dh2)) {
            if($file2!="." && $file2!="..") {
              if(!is_dir($onlinepath.'/'.$file.'/'.$file2)) {
                if(time()-@filemtime($onlinepath.'/'.$file.'/'.$file2)>$setting['delhistory']){
                  @unlink($onlinepath.'/'.$file.'/'.$file2);
                }
              }
            }
          }
          closedir($dh2);
        }
      }
    }
    closedir($dh);
  }
}
#删除图片
if($setting['delpic']){
  $onlinepath="../onezdata/pic";
  $A=array();
  if(is_dir($onlinepath)){
    $dh=opendir($onlinepath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($onlinepath.'/'.$file)) {
          if(time()-@filemtime($onlinepath.'/'.$file)>$setting['delpic']){
            @unlink($onlinepath.'/'.$file);
          }
        }
      }
    }
    closedir($dh);
  }
}
#删除文件
if($setting['delfile']){
  $onlinepath="../onezdata/file";
  $A=array();
  if(is_dir($onlinepath)){
    $dh=opendir($onlinepath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($onlinepath.'/'.$file)) {
          if(time()-@filemtime($onlinepath.'/'.$file)>$setting['delfile']){
            @unlink($onlinepath.'/'.$file);
          }
        }
      }
    }
    closedir($dh);
  }
}
?>