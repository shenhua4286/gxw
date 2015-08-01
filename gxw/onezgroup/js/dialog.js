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

var IsLoaded=0;
function TryResize(){
  if(IsLoaded==0){
    try{ResetSize();}catch(e){}
    setTimeout('TryResize()',100);
  }
}
TryResize();

_attachEvent(window,"resize",ResetSize);
var TimerA;
_attachEvent(window,"load",function(){
  ResetSize();
  IsLoaded=1;
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
//Ajax
function Send(){
  var message=$('inputbox').value;
  message=message.replace(/\n/g,'<br />');
	message=message.replace(new RegExp('<scr'+'ipt[^>]*?>.*?</scr'+'ipt>','g'), "");
	message=message.replace(new RegExp('\<\!\-\-.*?\-\-\>','g'), "");
	message=message.replace('\<\!\-\-', "");
  if(message.length<1){
    $('inputbox').value='';
    $('inputbox').focus();
    return false;
  }
  PrintChat(nickname+'&nbsp;&nbsp;'+Now(),'im_to');
  PrintChat(ubbtohtml(message),'im_content');
  var x=new Ajax('HTML','');
  x.post('api/onez.php?action=send','touser='+encodeURI(touid)+'&msg='+encodeURI(OnezEncode(message,1)),function(s){
  });
  $('inputbox').value='';
  $('inputbox').focus();
}

function ShowMsg(str){
  var t=str.split('|');
  if(t.length!=2)return;
  PrintChat(touser+'&nbsp;&nbsp;'+t[1].replace(Day()+' ',''),'im_from');
  PrintChat(ubbtohtml(unescape(t[0])),'im_content');
}
function Update(){
  if(client=='1')return;
  var msg=top.document.getElementById("Group_body").contentWindow.MsgBox[touid];
  top.document.getElementById("Group_body").contentWindow.MsgBox[touid]=[];
  if(typeof msg=='undefined')msg=[];
  if(msg.length<1)return;
  try{
    for(var i=0;i<msg.length;i++){
      if(msg[i].length>1){
        ShowMsg(msg[i]);
      }
    }
  }catch(e){}
}
var IsBreak=false;
function Update2(){
  if(IsBreak)return;
  IsBreak=true;
  var x=new Ajax('HTML','');
  x.get('api/onez.php?action=update2&t='+Math.random(),function(s){
    IsBreak=false;
    var o=s.split('\n');
    if(o.length>0){
      for(var i=0;i<o.length;i++){
        if(o[i].length>1){
          var hasNew=false;
          var t=o[i].split('\t');
          switch(t[0]){
            case'2':
              PrintChat(t[2]+'&nbsp;&nbsp;'+t[4].replace(Day()+' ',''),'im_from');
              PrintChat(ubbtohtml(OnezDecode(t[3],1)),'im_content');
              break;
            case'3':
              if(t[1].length>1)alert(t[1]);
              if(t[2]=='logout'){
                x = new Ajax('HTML','');
                x.get('info.php?type=logout',function(s){
                  if(s=='Y'){
                    top.location.reload();
                  }
                });
              }else if(t[2]=='close'){
                top.close();
              }
              break;
            case'4':
              if(t[1]=='0'){
                alert(t[3]);
              }else{
                if(from=='bbs'){
                  $('inputbox').value+=t[3];
                }else{
                  top.frames[t[2]+'_body'].document.getElementById('inputbox').value+=t[3];
                }
                LastFocus($('inputbox'));
              }
              break;
          }
        }
        if(hasNew){
          $('thesound_msg').play();
        }
      }
    }
  });
}
if(from=='bbs'){
  TimerA=window.setInterval('Update2()',sec_update2);
}else{
  TimerA=window.setInterval('Update()',800);
}