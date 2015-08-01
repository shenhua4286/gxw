var trueValue='';
function input_onkeydown(e){
  var keycode=isIE?e.keyCode:e.which;
  var SendStr=false;
  if(TheKey==1 && keycode==13){
    SendStr=true;
  }else if(TheKey==2 && window.event.ctrlKey && keycode==13){
    SendStr=true;
  }
  if(SendStr){
    isIE ? e.returnValue=false : e.preventDefault();
    Send();
  }
}
function input_onkeyup(e){
  if(vType=='password'){
    if(trueValue.length>$('inputbox').value.length){
      trueValue=trueValue.substr(0,$('inputbox').value.length);
    }else if(trueValue.length<$('inputbox').value.length){
      trueValue+=$('inputbox').value.substr(trueValue.length);
    }
    var tmp='';
    for(i=0;i<$('inputbox').value.length;i++){
      tmp+='*';
    }
    $('inputbox').value=tmp;
  }
}
function SendKey(id){
  if(id=='1'){
    $('HotKey').innerHTML='回车键发送消息';
  }else{
    $('HotKey').innerHTML='Ctrl+回车键发送消息';
  }
  TheKey=id;
  setcookie('sendkey',id);
}
SendKey(TheKey=='2'?'2':'1');
function ResetSize(){
  if(!isIE){
    $('boxLeft').style.width=$('FaceA').offsetLeft-12+'px';//主界面宽
  
    $('dtc').style.width=parseInt($('boxLeft').style.width)-$('dtl').offsetWidth-$('dtr').offsetWidth+'px';//顶边框宽
    $('dbc').style.width=parseInt($('boxLeft').style.width)-$('dbl').offsetWidth-$('dbr').offsetWidth+'px';//底边框宽
    $('showbox').style.height=document.documentElement.clientHeight-getoffset($('boxLeft'))[0]-$('toolbox').offsetHeight-$('inputbox').offsetHeight-$('dbl').offsetHeight-$('btnbox').offsetHeight-3+'px';//显示框高
    $('inputbox').style.width=parseInt($('boxLeft').style.width)-2+'px';//输入框宽
    return;
  }
  $('boxLeft').style.pixelWidth=$('FaceA').offsetLeft-12;//主界面宽

  $('dtc').style.pixelWidth=$('boxLeft').style.pixelWidth-$('dtl').offsetWidth-$('dtr').offsetWidth;//顶边框宽
  $('dbc').style.pixelWidth=$('boxLeft').style.pixelWidth-$('dbl').offsetWidth-$('dbr').offsetWidth;//底边框宽
  $('showbox').style.pixelHeight=document.documentElement.clientHeight-getoffset($('boxLeft'))[0]-$('toolbox').offsetHeight-$('inputbox').offsetHeight-$('dbl').offsetHeight-$('btnbox').offsetHeight;//显示框高
  $('inputbox').style.pixelWidth=$('boxLeft').style.pixelWidth-4;//输入框宽
}
try{ResetSize();top.FrameInit(onez_key)}catch(e){}
_attachEvent(window,"resize",ResetSize);
_attachEvent(window,"load",function(){
  ResetSize();
  Send();
  window_onload();
});
function PrintChat(str,cname,newid){
  var e=document.createElement('div');
  if(cname!='')e.className=cname;
  if(newid!='')e.id=newid;
  e.innerHTML=str;
  $('showbox').appendChild(e);
  ScrollControl();
}
function ScrollControl(){
	$('showbox').scrollTop+=50000;
}
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1){
  document.write('<SCRIPT LANGUAGE=VBScript\> \n');
  document.write('on error resume next \n');
  document.write('Sub myToolbar_FSCommand(ByVal command, ByVal args)\n');
  document.write(' call myToolbar_DoFSCommand(command, args)\n');
  document.write('end sub\n');
  document.write('</SCRIPT\> \n');
}
function myToolbar_DoFSCommand(command, args){
  if(args!="undefined" && args!=""){
    if(command=='upload'){
    
    }else if(command=='toolbar'){
      try{eval(args)}catch(e){}
    }
  }
}
function Now(){
	date = new Date();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	return H_+":"+i_+":"+s_;
}
function Day(){
	var date = new Date();
	Y_=date.getYear().toString();
	m_=(date.getMonth()+1).toString();
	d_=(date.getDate()).toString();
	if(m_.length==1)m_="0"+m_;
	if(d_.length==1)d_="0"+d_;
	return Y_+"-"+m_+"-"+d_;
}
var ImgCount=0;
function ubbtohtml(fdata){
  fdata=fdata.replace(new RegExp('\\[:([^_]+)_([0-9]{1,3})\\]','g'),'<img src="images/smiley/$1/$2.gif">');
  fdata=fdata.replace(new RegExp('\\[url\\](www.|http:\/\/){1}([^\[\"\']+?)\\[\/url\\]','gi'),'<a href="$1$2" target="_blank">$1$2</a>');
  fdata=fdata.replace(new RegExp('\\[url=(www.|http:\/\/){1}([^\[\"\']+?)\\](.+?)\\[\/url\\]','gi'),'<a href="$1$2" target="_blank">$3</a>');
  fdata=fdata.replace(new RegExp('\\[P\\/([^\\/]+)\\/([^\\]]+)\\]','g'),'<img src="'+homepage+'/down.php?P/$1/$2" onload="resetImg(this)">');
  fdata=fdata.replace(new RegExp('\\[F\\/([^\\/]+)\\/([^\\]]+)\\]','g'),'<div class="im_file"><a href="'+homepage+'/down.php?F/$1/$2" target="_blank">$1</a></div>');
  fdata=fdata.replace(new RegExp('\\[img\\]([^\[\"\']+?)\.(gif|jpg|bmp|png){1}\\[\/img\\]','gi'),'<img src="$1.$2" onload="resetImg(this)" />');
  return fdata;
}
function resetImg(obj,icount){
  try{
    if(obj.width>300){
      obj.width=300;
    }
    ScrollControl();
  }catch(e){}
}
var curUsr=0;
function SelUsr(uid){
  if(curUsr==uid)return;
  try{$('usr_'+curUsr).className=''}catch(e){}
  curUsr=uid;
  top.Cur_List_Sel_Q=curUsr;
  $('usr_'+uid).className='sel';
}
//Ajax
var step=0;
var vType='';
function Send(){
  var message=vType=='password'?trueValue:$('inputbox').value;
  message=message.replace(/\n/g,'<br />');
	message=message.replace(new RegExp('<scr'+'ipt[^>]*?>.*?</scr'+'ipt>','g'), "");
	message=message.replace(new RegExp('\<\!\-\-.*?\-\-\>','g'), "");
	message=message.replace('\<\!\-\-', "");
	if(message.length>0){
    PrintChat('您&nbsp;&nbsp;'+Now(),'im_to');
    var msg=ubbtohtml(message);
    if(vType=='password')msg='***************************************'.substr(0,msg.length);
    PrintChat(msg,'im_content');
  }
  var x=new Ajax('HTML','');
  x.post('plugins/robot/'+botid+'/api.php','step='+step+'&msg='+encodeURI(message),function(s){
    if(s.length<1)return;
    var o=s.split('\n');
    if(!isNaN(o[0])){
      step=parseInt(o[0]);
      vType=o[1];
      if(o[2]=='eval'){
        try{eval(o[3])}catch(e){}
        if(typeof o[4]!='undefined'){
          PrintChat(botname+'&nbsp;&nbsp;'+Now(),'im_from');
          PrintChat(o[4],'im_content');
        }
      }else{
        PrintChat(botname+'&nbsp;&nbsp;'+Now(),'im_from');
        PrintChat(o[2],'im_content');
      }
    }else{
      PrintChat(s,'im_info');
    }
  });
  $('inputbox').value='';
  $('inputbox').focus();
}