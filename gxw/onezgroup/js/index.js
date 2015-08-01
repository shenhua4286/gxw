isclose=false;
function CloseTopWin(){
 // var x = new Ajax('HTML','');
  if(confirm('您确定要关闭窗口吗？')){
      window.close();
    }
  /*x.get('info.php?type=islogin&'+Math.random(),function(s){
    /*if(s=='Y'){
      if(confirm('您确定要退出登陆吗？')){
        top.location.href='logout.php?channelid='+GroupId;
      }
    }else{
     
   // }
  });*/
}
function OpenLoginDialog(id){
  //LoadFrame("Login","会员登陆","login.php?channel="+id,335,220,0,0,5,0,0,0,1);
}
function OpenGroupDialog(id){
  LoadFrame("Group",GroupName,"group.php?channel="+id+"&client="+client,GroupWidth,GroupHeight,0,0,2,0,0,0,0);
}
function OpenFriend(){
  LoadFrame("Friend","我的好友","friend.php?client="+client,FriendWidth,FriendHeight,0,0,2,0,0,0,1);
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
  var t='私聊('+uid+')';
  try{
    t=$("Group_body").contentWindow.Usrs[uid]['username'];
  }catch(e){}
  LoadFrame("User"+uid,t,"dialog.php?client="+client+"&uid="+uid,UserWidth,UserHeight,0,0,2,0,1,1,1)
}
function thistime(){
  window.status=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt (new Date().getDay());
}
window.onbeforeunload = function() {
  if(isclose)window.event.returnValue  = "您正试图强行关闭或刷新本窗口，该操作可能会对您的账号安全带来一定的隐患，因此本站建议：如需关闭窗口，请点击页面中的退出按钮。";
  if (window.event.reason == false) {
    window.event.cancelBubble = true;
  }
}