isclose=false;
function CloseTopWin(){
 // var x = new Ajax('HTML','');
  if(confirm('��ȷ��Ҫ�رմ�����')){
      window.close();
    }
  /*x.get('info.php?type=islogin&'+Math.random(),function(s){
    /*if(s=='Y'){
      if(confirm('��ȷ��Ҫ�˳���½��')){
        top.location.href='logout.php?channelid='+GroupId;
      }
    }else{
     
   // }
  });*/
}
function OpenLoginDialog(id){
  //LoadFrame("Login","��Ա��½","login.php?channel="+id,335,220,0,0,5,0,0,0,1);
}
function OpenGroupDialog(id){
  LoadFrame("Group",GroupName,"group.php?channel="+id+"&client="+client,GroupWidth,GroupHeight,0,0,2,0,0,0,0);
}
function OpenFriend(){
  LoadFrame("Friend","�ҵĺ���","friend.php?client="+client,FriendWidth,FriendHeight,0,0,2,0,0,0,1);
}
function ToBot(botid,botname,w,h){
  if($("Bot"+botid)!==null){
    FrameRes('Bot'+botid);
    return;
  }
  if(w=='' || w=='0' || isNaN(w))w=BotWidth;
  if(h=='' || h=='0' || isNaN(h))h=BotHeight;
  var l=parseInt(Math.random()*(document.body.clientWidth-w));
  var t=parseInt(Math.random()*(document.body.clientHeight-h));
  var pos=botid.indexOf('login')==1?0:5;
  LoadFrame("Bot"+botid,botname,"robot.php?client="+client+"&botid="+botid,w,h,l,t,pos,0,1,1,1)
}
function OpenUserDialog(uid){
  if(isNaN(uid) && uid.substr(0,1)!='_'){
    var s=uid.split('_');
    ToBot(s[0],s[1],s[2],s[3]);
    return;
  }
  if($("User"+uid)!==null){
    FrameRes('User'+uid);
    return;
  }
  var t='˽��('+uid+')';
  try{
    t=$("Group_body").contentWindow.Usrs[uid]['username'];
  }catch(e){}
  LoadFrame("User"+uid,t,"dialog.php?client="+client+"&uid="+uid,UserWidth,UserHeight,0,0,2,0,1,1,1)
}
function thistime(){
  window.status=new Date().toLocaleString()+' ����'+'��һ����������'.charAt (new Date().getDay());
}
window.onbeforeunload = function() {
  if(isclose)window.event.returnValue  = "������ͼǿ�йرջ�ˢ�±����ڣ��ò������ܻ�������˺Ű�ȫ����һ������������˱�վ���飺����رմ��ڣ�����ҳ���е��˳���ť��";
  if (window.event.reason == false) {
    window.event.cancelBubble = true;
  }
}