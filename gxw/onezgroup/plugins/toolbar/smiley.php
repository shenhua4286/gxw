<?
$Con['title']='147';//标题
$Con['img']='./smiley.gif';//  ./当前目录,*/模板目录
$Con['onclick']='insertsmiley()';//点击事件名称
$Con['onload']='';//
$Con['autoclose']='smiley_box';
$Con['js']=array();
$Con['js']=<<<ONEZ
_attachEvent($('smiley_box'),"mousedown",SelSmiley);
function insertsmiley(){
  $('smiley_box').style.top='-999999px';
  $('smiley_box').style.display='block';
  $('smiley_box').style.left=getoffset($('showbox'))[1]+1+'px';
  $('smiley_box').style.top=getoffset($('toolbox'))[0]-$('smiley_box').offsetHeight+1+'px';
}
function SelSmiley(a){
  try{
    var obj=document.all?a.srcElement:a.target;
    if(!isIE){
      var x = a.clientX-parseInt($('smiley_box').style.left);
      var y = a.clientY-parseInt($('smiley_box').style.top);
    }else{
      var x = window.event.x-parseInt($('smiley_box').style.left);
      var y = window.event.y-parseInt($('smiley_box').style.top);
    }
    var sIndex=Math.floor(y/29)*15+Math.floor(x/29);
    $('inputbox').value+='[:qq_'+sIndex+']';
  }catch(e){}
  $('smiley_box').style.display='none';
}
ONEZ;


$Con['html']='<img src="images/smiley/qq.gif" id="smiley_box" />';
?>