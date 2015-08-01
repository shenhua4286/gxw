<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$tmp=$_SERVER['QUERY_STRING'];
!$tmp && die();
list($token,$filename,$filepath)=explode('/',$tmp);
!$filepath && die();
$filepath=preg_replace('/(\.\.|\/)/i','',$filepath);
!$filename && $filename=$filepath;
if($token=='P'){
  $file='onezdata/bbs/pic/'.$filepath;
}elseif($token=='F'){
  $file='onezdata/bbs/file/'.$filepath;
}
!file_exists($file) && die();
$filesize=filesize($file);
header("Cache-control: max-age=31536000");
header("Content-Encoding: none");
header("Content-Length: ".$filesize);
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: ".$filetype);
$fp = fopen( $file, "rb" );
@flock( $fp, 2 );
$attachment = fread( $fp, $filesize );
@fclose( $fp );
echo $attachment;
?>