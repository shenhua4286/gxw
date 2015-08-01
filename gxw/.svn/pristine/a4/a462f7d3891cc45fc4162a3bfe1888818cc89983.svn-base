<?
$Con['title']='保存记录';//标题
$Con['img']='./save.gif';//  ./当前目录,*/模板目录
$Con['onclick']='saveas()';//点击事件名称
$Con['autoclose']='';
$Con['js']="function saveas() {
  try {
    var savestyle='<style type=\"text/css\">body{margin: 0px; padding: 0px 0px 0px 0px; border: 0px;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma;}.im_to{color:#008040;height:18px;line-height:18px;}.im_from{color:#0000ff;height:18px;line-height:18px;}.im_content{color:#000000;padding-left:10px;}.im_tip{color:#0000ff;}.error{color:#7982c1;height:18px;line-height:18px;padding-left:20px;background:url(im_info.gif) no-repeat 2px 1px;}</style>';
    var time=new Date();
    var filename=time.toLocaleDateString();
    filename=filename+\" \"+(document.title.toString().replace(/\s/g,'_'))+\".htm\";
    var winSave=window.open('about:blank','_blank','top=10000');
    winSave.document.open(\"text/html\",\"utf-8\");
		winSave.document.write(\"<html><head><meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset=utf-8\\\" /><base target=\\\"_blank\\\">\"+savestyle+\"</head><body>\"+$(\"showbox\").outerHTML+\"</body></html>\");
    winSave.document.execCommand (\"SaveAs\",true,filename);
    winSave.close();
  }
  catch(e){}
}";
$Con['html']='';//附加HTML
?>