var InfoHeight=[0,0,0,0];
function SetInfoBox(token){
  if($('infobtn'+token).className=='sel'){
    $('infobtn'+token).className='';
    if(token=='A'){
      $('infoboxA').style.pixelHeight=InfoHeight[0];
      $('infoboxB').style.pixelHeight=InfoHeight[1];
      $('infoboxA').style.display='block';
      $('infoboxB').style.display='block';
    }else if(token=='B'){
      $('infoboxA').style.pixelHeight=InfoHeight[0];
      $('infoboxB').style.pixelHeight=InfoHeight[1];
      $('infoboxA').style.display='block';
      $('infoboxB').style.display='block';
    }
  }else{
    $('infobtn'+token).className='sel';
    if(token=='A'){
      $('infoboxA').style.pixelHeight=InfoHeight[2];
      $('infoboxA').style.display='block';
      $('infoboxB').style.display='none';
    }else if(token=='B'){
      $('infoboxB').style.pixelHeight=InfoHeight[2];
      $('infoboxA').style.display='none';
      $('infoboxB').style.display='block';
    }
  }
}
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
function ResetSize(){
  if(!isIE){
    $('boxLeft').style.height=document.documentElement.clientHeight-getoffset($('boxLeft'))[0]+'px';//主界面高
    $('boxLeft').style.width=document.documentElement.clientWidth-$('boxRight').offsetWidth-$('boxRight').style.marginLeft-$('boxLeft').style.marginLeft-12+'px';//主界面宽
  
    $('dtc').style.width=parseInt($('boxLeft').style.width)-$('dtl').offsetWidth-$('dtr').offsetWidth+'px';//顶边框宽
    
    $('dbc').style.width=parseInt($('boxLeft').style.width)-$('dbl').offsetWidth-$('dbr').offsetWidth+'px';//底边框宽
    $('showbox').style.height=document.documentElement.clientHeight-getoffset($('boxLeft'))[0]-$('toolbox').offsetHeight-$('inputbox').offsetHeight-$('dbl').offsetHeight-$('btnbox').offsetHeight-3+'px';//显示框高
    $('inputbox').style.width=parseInt($('boxLeft').style.width)-2+'px';//输入框宽
    if(InfoHeight[0]==0){
      InfoHeight[0]=$('infoboxA').offsetHeight;
      InfoHeight[1]=document.documentElement.clientHeight-$('borderB').offsetHeight-getoffset($('infoboxB'))[0];
      InfoHeight[3]=document.documentElement.clientHeight-InfoHeight[1];
    }else{
      InfoHeight[1]=document.documentElement.clientHeight-InfoHeight[3];
    }
    InfoHeight[2]=InfoHeight[0]+InfoHeight[1];
    if($('infoboxA').style.display!='none'){
      $('infoboxA').style.height=($('infoboxB').style.display=='none'?InfoHeight[2]:InfoHeight[0])+'px';
    }
    if($('infoboxB').style.display!='none'){
      $('infoboxB').style.height=($('infoboxA').style.display=='none'?InfoHeight[2]:InfoHeight[1])+'px';
    }
    return;
  }
  $('boxLeft').style.pixelHeight=document.documentElement.clientHeight-getoffset($('boxLeft'))[0];//主界面高
  $('boxLeft').style.pixelWidth=document.documentElement.clientWidth-$('boxRight').offsetWidth-$('boxRight').style.marginLeft-$('boxLeft').style.marginLeft-12;//主界面宽

  $('dtc').style.pixelWidth=$('boxLeft').style.pixelWidth-$('dtl').offsetWidth-$('dtr').offsetWidth;//顶边框宽
  
  $('dbc').style.pixelWidth=$('boxLeft').style.pixelWidth-$('dbl').offsetWidth-$('dbr').offsetWidth;//底边框宽
  $('showbox').style.pixelHeight=document.documentElement.clientHeight-getoffset($('boxLeft'))[0]-$('toolbox').offsetHeight-$('inputbox').offsetHeight-$('dbl').offsetHeight-$('btnbox').offsetHeight;//显示框高
  $('inputbox').style.pixelWidth=$('boxLeft').style.pixelWidth-4;//输入框宽
  if(InfoHeight[0]==0){
    InfoHeight[0]=$('infoboxA').offsetHeight;
    InfoHeight[1]=document.documentElement.clientHeight-$('borderB').offsetHeight-getoffset($('infoboxB'))[0];
    InfoHeight[3]=document.documentElement.clientHeight-InfoHeight[1];
  }else{
    InfoHeight[1]=document.documentElement.clientHeight-InfoHeight[3];
  }
  InfoHeight[2]=InfoHeight[0]+InfoHeight[1];
  if($('infoboxA').style.display!='none'){
    $('infoboxA').style.pixelHeight=$('infoboxB').style.display=='none'?InfoHeight[2]:InfoHeight[0];
  }
  if($('infoboxB').style.display!='none'){
    $('infoboxB').style.pixelHeight=$('infoboxA').style.display=='none'?InfoHeight[2]:InfoHeight[1];
  }
}
_attachEvent(window,"resize",ResetSize);
_attachEvent(window,"load",function(){
  var e=document.createElement("embed");
  e.id="thesound_msg";
  e.setAttribute("src","sound/msg.wav");
  e.setAttribute("autostart","false");
  e.setAttribute("loop","false");
  $('hiddenBox').appendChild(e);
  
  SendKey(TheKey=='2'?'2':'1');

  ResetSize();
  IsLoaded=1;
  InfoHeight[0]=$('infoboxA').offsetHeight;
  
  $('infoboxA').style.pixelHeight=InfoHeight[0];
  $('infoboxB').style.pixelHeight=InfoHeight[1];
  TalkToBot('init');
  window_onload();
});
function PrintChat(str,cname,newid){
  var e=document.createElement('div');
  if(cname!='')e.className=cname;
  //if(newid!=undefined)e.id=newid;
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
var curUsr='';

function SelUsr(uid){
  if(curUsr==uid)return;
  try{$('usr_'+curUsr).className=''}catch(e){}
  try{$('bot_'+curUsr).className=''}catch(e){}
  curUsr=uid;
  try{$('usr_'+uid).className='sel'}catch(e){}
  try{$('bot_'+uid).className='sel'}catch(e){}
}
function TalkToBot(msg){
  if(RevcBot==[])return;
  for(var i=0;i<RevcBot.length;i++){
    if(typeof RevcBot[i]!='undefined'){
      var x=new Ajax('HTML','');
      x.post('plugins/robot/'+RevcBot[i]+'/api.php?action=channel','ChannelId='+ChannelId+'&msg='+encodeURI(msg),function(s){
        if(s.length<1)return;
        try{eval(s)}catch(e){}
      });
    }
  }
}
function OpenFriend(uid){
  if(only=='1'){
    if(client=='1'){
      top.location.href='onez://friend';
    }else{
      window.open('friend.php?from=bbs','friend','');
    }
  }else{
    top.OpenFriend();
  }
}
function ToUsr(uid){
//	alert(uid);
  if(isNaN(uid) && uid.substr(0,1)!='_'){
    var s=uid.split('_');
    if(only=='1'){
      if(client=='1'){
    	  parent.location.href='onez://robot|'+s[0];
      }else{
    	  parent.window.open('robot.php?from=bbs&botid='+s[0],'robot'+uid,'');
      }
    }else{
    	parent.ToBot(s[0],s[1],s[2],s[3]);
    }
    return;
  }else{
    if(only=='1'){
      if(client=='1'){
    	  parent.location.href='onez://dialog|'+uid;
      }else{
    	  parent.window.open('dialog.php?from=bbs&uid='+uid,'dialog'+uid,'');
      }
    }else{
    	parent.OpenUserDialog(uid);
    }
  }
}
//------------------
function Onez_Option(uid,s){
  switch(s){
    case'sendmsg':
      ToUsr(uid);
      break;
    case'viewuser':
      //window.open(ViewUserUrl.replace('*',uid),'','');
      ToUsr(uid);
      break;
    case'tickout':
      var x=new Ajax('HTML','');
      x.post('api/onez.php?action=tickout','uid='+uid,function(s){
        if(s=='1'){
          alert('命令已发出');
        }else if(s=='-1'){
          alert('请选择您要踢出的用户');
        }else if(s=='-2'){
          alert('您不能踢出自己');
        }else if(s=='-3'){
          alert('您没有权限');
        }
      });
      break;
    case'addmaster':
      var x=new Ajax('HTML','');
      x.post('api/onez.php?action=addmaster','uid='+uid,function(s){
        if(s=='1'){
          alert('命令已发出');
        }else if(s=='-1'){
          alert('您没有权限');
        }
      });
      break;
    case'addfriend':
      var x=new Ajax('HTML','');
      x.post('api/onez.php?action=addfriend','uid='+uid,function(s){
        if(s=='-1'){
          alert('对方已经是您的好友了');
        }else{
          Friends=','+s+',';
          alert('添加好友成功');
        }
      });
      break;
  }
  $('UserInfo').style.display='none';
}
_attachEvent(window,"mousedown",MyMouseDown);
document.onmousedown=MyMouseDown;

var RightMenus=new Object();
RightMenus['sendmsg']='发消息';
RightMenus['addfriend']='加好友';
RightMenus['viewuser']='资料';
RightMenus['tickout']='踢出';
RightMenus['addmaster']='设为管理员';
function ShowUser(event,id){
  var menus=['sendmsg'];
  if(id.substr(0,3)=='bot'){
    var botid=id.substr(4).split('_')[0];
    var tmp='';
    for(i=0;i<menus.length;i++){
      tmp+='[<a href="#" onclick="Onez_Option(\''+id.substr(4)+'\',\''+menus[i]+'\')" onfocus="this.blur()">'+RightMenus[menus[i]]+'</a>]&nbsp;';
    }
    $('userinfo_face').src=Bots[botid]['face'];
    $('userinfo_name').innerHTML=Bots[botid]['username'];
    $('userinfo_txt').innerHTML=Bots[botid]['readme'];
  }else{
    if(id.substr(4,1)!='_'){
      menus[menus.length]='viewuser';
      if(id.substr(4)!=userid){
        if(Friends.indexOf(','+id.substr(4)+',')==-1){
          menus[menus.length]='addfriend';
        }
        if(parseInt(Usrs[id.substr(4)]['grade'])<grade){//如果对方等级小于自己
          menus[menus.length]='tickout';
          if(grade==28){
            menus[menus.length]='addmaster';
          }
        }
      }
    }
    var tmp='';
    for(i=0;i<menus.length;i++){
      tmp+='[<a href="#" onclick="Onez_Option(\''+id.substr(4)+'\',\''+menus[i]+'\')" onfocus="this.blur()">'+RightMenus[menus[i]]+'</a>]&nbsp;';
    }
    
    $('userinfo_face').src=Usrs[id.substr(4)]['face'];
    $('userinfo_name').innerHTML=Usrs[id.substr(4)]['username'];
    $('userinfo_txt').innerHTML=Usrs[id.substr(4)]['readme'];
  }
  $('userinfo_btns').innerHTML=tmp;
  $('UserInfo').style.top='-999999px';
  $('UserInfo').style.display='block';
  var t=getoffset($(id))[0]-$('UserInfo').offsetHeight-2;
  if(t<0){
    t=getoffset($(id))[0]+$(id).offsetHeight+2;
  }
  $('UserInfo').style.top=t-$('infoboxB').scrollTop+'px';
}
function MyMouseDown(event){
  try{
    if(isIE){
      var obj=window.event.srcElement;
      if(obj.id=='infoboxB'){
        $('UserInfo').style.display='none';
      }else if(obj.parentElement.id=='infoboxB'){
        var uid=obj.id;
        SelUsr(uid.substr(4));
        ShowUser(window.event,uid);
      }else if(obj.parentElement.parentElement.id=='infoboxB'){
        var uid=obj.parentElement.id;
        SelUsr(uid.substr(4));
        ShowUser(window.event,uid);
      }else if(obj.parentElement.parentElement.parentElement.id=='infoboxB'){
        var uid=obj.parentElement.parentElement.id;
        SelUsr(uid.substr(4));
        ShowUser(window.event,uid);
      }
    }else{
      var obj=event.target;
      if(obj.id=='infoboxB'){
        $('UserInfo').style.display='none';
      }else if(obj.parentNode.id=='infoboxB'){
        var uid=obj.id;
        SelUsr(uid.substr(4));
        ShowUser(event,uid);
      }else if(obj.parentNode.parentNode.id=='infoboxB'){
        var uid=obj.parentNode.id;
        SelUsr(uid.substr(4));
        ShowUser(event,uid);
      }else if(obj.parentNode.parentNode.parentNode.id=='infoboxB'){
        var uid=obj.parentNode.parentNode.id;
        SelUsr(uid.substr(4));
        ShowUser(event,uid);
      }
    }
  }catch(e){}
}
var Article=['',''];
function PubArticle(){
  if(forumId.length<1){
    PrintChat('本站尚未开启快速发帖功能','im_info');
    return false;
  }
  var message=$('inputbox').value;
  if(Article[0]==''){
    if(message.length<1){
      $('inputbox').value='';
      $('inputbox').focus();
      return false;
    }
    Article[0]=message;
    PrintChat('<b>您已进入快速发帖模式</b><br />版块：<font color=blue><u>'+forumName+'</u></font><br />主题：<font color=blue><u>'+message+'</u></font><br /><font color=gray>请输入帖子内容，然后再次点“快速发帖”。如果不填任何内容则自动取消</font>','im_info');
    $('sendbtn').disabled=true;
    $('inputbox').value='';
    $('inputbox').focus();
  }else if(Article[1]==''){
    $('sendbtn').disabled=false;
    if(message.length<1){
      Article=['',''];
      PrintChat('您已取消快速发帖','im_info');
      return false;
    }
    Article[1]=message;
    $('inputbox').value='';
    $('inputbox').focus();
    PrintChat('内容：<font color=blue><u>'+message+'</u></font>','im_info');
    PrintChat('正在发送...','im_info');
    var x=new Ajax('HTML','');
    x.post('api/onez.php?action=pub','ChannelId='+ChannelId+'&ti='+encodeURI(Article[0])+'&co='+encodeURI(Article[1]),function(s){
      PrintChat(s=='Y'?'<font color=green>帖子发布成功</font>':s,'im_info');
    });
    Article=['',''];
  }
}
function Re(tid){
  if($('inputbox').value.substr(0,('[RE '+tid+']').length)!='[RE '+tid+']'){
    $('inputbox').value+='[RE '+tid+']';
  }
  LastFocus($('inputbox'));
}
//Ajax
function Send(){
  var message=$('inputbox').value;
  if(message.substr(0,4)=='[RE '){
    var o=message.substr(4).split(']');
    var tid=o[0];
    var tmp='';
    if(!isNaN(tid)){
      message=message.substr(4+tid.length+1);
      if(message.length<1){
        $('inputbox').focus();
        return false;
      }
      $('inputbox').value='';
      $('inputbox').focus();
      var x=new Ajax('HTML','');
      x.post('api/onez.php?action=re','ChannelId='+ChannelId+'&tid='+tid+'&co='+encodeURI(message),function(s){
        PrintChat(s=='Y'?'<font color=green>回复成功</font>':s,'im_info');
      });
      Article=['',''];
      return;
    }
  }
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
  $('inputbox').value='';
  $('inputbox').focus();
  TalkToBot(message);
  var x=new Ajax('HTML','');
  	x.post('api/onez.php?action=send','ChannelId='+ChannelId+'&touser=&msg='+encodeURI(OnezEncode(message,forumId==''?1:0)),function(s){
  });
}
var TimerB=window.setInterval('LoadList()',sec_list);
function LoadList(){
  var x=new Ajax('HTML','');
  x.post('api/onez.php?action=list','ChannelId='+ChannelId,function(s){
    var newuids='';
    var o=s.split(',');
    for(var i=0;i<o.length;i++){
      if(typeof Usrs[o[i]]=='undefined'){
        if(o[i].substr(0,1)=='_'){
          Usrs[o[i]]={'username':'访客','grade':'0','face':'images/guest.gif','sex':'0','readme':'编号:'+o[i]};
          AddUsr(o[i]);
        }else{
          if(newuids!='')newuids+=',';
          newuids+=o[i];
        }
      }else{
        AddUsr(o[i]);
      }
    }
    if(newuids!=''){
      GetUsrsInfo(newuids);
    }
    var obj=isIE ? $('infoboxB').children : $('infoboxB').childNodes;
    for(var i=robotCount;i<obj.length;i++){
      var theid=obj[i].id.substr(4);
      if((','+s).indexOf(','+theid)==-1){
        if(Words['out']!=[])PrintChat(ubbtohtml(Words['out'][parseInt(Words['out'].length*Math.random())]).replace(/\{user\}/g,Usrs[theid]['username']),'im_info');//离开
        $('infoboxB').removeChild(obj[i]);
      }
    }
    $('onlineusr').innerHTML=' ('+obj.length+'人)';
  });
}
LoadList();
function GetUsrsInfo(uids){
  var x=new Ajax('HTML','');
  x.post('api/onez.php?action=userlist','ChannelId='+ChannelId+'&uids='+uids,function(s){
    var o=s.split('\n');
    for(var i=0;i<o.length;i++){
      if(o[i]!=''){
        var t=o[i].split('\t');
        if(typeof Usrs[t[0]]=='undefined'){
          if(t[0]==userid)t[3]='self';
          var g='1';
          if(CreateUsr==t[1]){
            g='28';
          }else if(Masters.indexOf(','+t[1]+',')!=-1){
            g='2';
          }
          Usrs[t[0]]={'username':t[1],'grade':g,'face':t[2],'sex':t[3],'readme':t[4]};
        }
        AddUsr(t[0]);
      }
    }
  });
}
var IsReady=0;
setTimeout('IsReady=1;',5000);
function AddUsr(theuid){
  if($('usr_'+theuid)==null){
	if(typeof Usrs[theuid]=='undefined')return;
    if(typeof Usrs[theuid]['username']=='undefined')return;
    Usrs[theuid]['username']=Usrs[theuid]['username'].substring(0,10);
    var e=document.createElement('li');
    e.id='usr_'+theuid;
    e.innerHTML='<span class="group_'+Usrs[theuid]['grade']+'"></span><span class="face">'+(Usrs[theuid]['face']?('<img src="'+Usrs[theuid]['face']+'" />'):'')+'</span><span class="name '+Usrs[theuid]['sex']+'">'+Usrs[theuid]['username']+'</span>';
    var obj=isIE ? $('infoboxB').children : $('infoboxB').childNodes;
    $('infoboxB').insertBefore(e,obj.length>robotCount ? obj[robotCount] : null);
    if(IsReady==1){
      if(Words['in']!=[])PrintChat(ubbtohtml(Words['in'][parseInt(Words['in'].length*Math.random())]).replace(/\{user\}/g,'<a href="javascript:ToUsr(\''+theuid+'\')">'+(Usrs[theuid]['username'].toString())+'</a>'),'im_info');//进入
    }
  }
}
var MsgBox={};
function ShowMsg(A){
  ToUsr(A[0]);
  var tmp=escape(OnezDecode(A[1]))+'|'+A[2];
  if(client=='1'){
    top.document.title='onez://newmsg|'+A[0]+'|'+tmp;
  }else{
    try{
      top.document.getElementById("User"+A[0]+"_body").contentWindow.ShowMsg(tmp);
    }catch(e){
      if(typeof(MsgBox[A[0]])=='undefined')MsgBox[A[0]]=[];
      MsgBox[A[0]][MsgBox[A[0]].length]=tmp;
    }
  }
}
//------------------
var TimerA=window.setInterval('Update()',sec_update);
var TimerC=window.setInterval('LoadMsg()',sec_msg);
function sec_msg(){
  var x=new Ajax('HTML','');
  x.post('api/onez.php?action=newmsg','ChannelId='+ChannelId,function(s){
    if(s==0 || s==undefined || s=='') return;
    if(client=='1'){
      PrintChat("您有 <font color=red>"+s+"</font> 条未读短消息",'im_info');
      $('thesound_msg').play();
      location.href="onez://sms|短消息提示|您有 <font color=red>"+s+"</font> 条未读短消息";
    }
  });
}
var IsBreak=false;
function Update(){
  if(IsBreak)return;
  var obj=isIE ? $('infoboxB').children : $('infoboxB').childNodes;
  $('onlineusr').innerHTML=' ('+obj.length+'人)';
  IsBreak=true;
  var x=new Ajax('HTML','');
  x.post('api/onez.php?action=update&index='+msgIndex+'&t='+Math.random(),'ChannelId='+ChannelId,function(s){
    IsBreak=false;
    var o=s.split('\n');
    if(o.length>1){
      msgIndex=o[0];
      var msgCount=0;
      for(var i=1;i<o.length;i++){
        if(o[i].length>1){
          var hasNew=false;
          var t=o[i].split('\t');
          switch(t[0]){
            case'1':
              if(t[1]!=userid){
                if(t[1]=='0'){
                  PrintChat(t[2],'im_info');
                }else{
                  if($('usr_'+t[1])==null){
                    GetUsrsInfo(t[1]);
                  }
                  PrintChat('<a href="javascript:ToUsr(\''+t[1]+'\')">'+t[2]+'</a>&nbsp;&nbsp;'+t[4].replace(Day()+' ',''),'im_from');
                  PrintChat(ubbtohtml(OnezDecode(t[3],forumId==''?1:0)),'im_content');
                }
                hasNew=true;
              }
              break;
            case'2':
              if($('usr_'+t[1])==null){
                GetUsrsInfo(t[1]);
              }
              ShowMsg([t[1],t[3],t[4]]);
              hasNew=true;
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
              }else if(t[2]=='clear'){
                Usrs={};
                $('onlineusr').innerHTML=' ('+robotCount+'人)';
                var obj=isIE ? $('infoboxB').children : $('infoboxB').childNodes;
                for(var i=robotCount;i<obj.length;i++){
                  $('infoboxB').removeChild(obj[i]);
                }
                
                LoadList();
              }
              break;
            case'4':
              if(t[1]=='0'){
                alert(t[3]);
              }else{
                if(t[2]=='Group'){
                  $('inputbox').value+=t[3];
                }else{
                  top.document.getElementById(t[2]+"_body").contentWindow.document.getElementById('inputbox').value+=t[3];
                }
                LastFocus($('inputbox'));
              }
              break;
            case'5':
              try{delete Usrs[t[1]];}catch(e){}
              try{$('infoboxB').removeChild($('usr_'+t[1]));}catch(e){}
              LoadList();
              break;
          }
        }
        if(hasNew){
          msgCount++;
        }
      }
      if(msgCount>0){
        $('thesound_msg').play();
        if(client=='1'){
          location.href="onez://msg|系统提示|您有 <font color=red>"+msgCount+"</font> 条消息";
        }
      }
    }
  });
}