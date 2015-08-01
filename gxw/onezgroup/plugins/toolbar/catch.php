<?
$Con['title']='截屏';//标题
$Con['img']='./catch.gif';//  ./当前目录,*/模板目录
$Con['onclick']='Catch()';//点击事件名称
$Con['autoclose']='';
$Con['js']="
function Catch(){
  location.href='onez://catch|'+onez_key;
}";
$Con['html']='';//附加HTML
?>