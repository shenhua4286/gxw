self.onError=null;
var Onez_Status=new Array();
try{
  var LineCount=parseInt(document.body.clientWidth/120);
  for(i=0;i<=OnezDivCount;i++){
    var Onez_L=(i % LineCount)*120;
    var Onez_T=document.body.clientHeight-parseInt(i / LineCount + 1)*FTLH;
    Onez_Status[i]=new Array(Onez_L,Onez_T,0);//Left,Top,Used
  }
}catch(e){

}
for(i=0;i<=OnezDivCount;i++){
  document.writeln("<div id=\"onezdiv"+i+"\" style=\"display:none\"></div>");
}
var CurZ=1;
var CurCount=0;
window.onload=function(){
  var LineCount=parseInt(document.body.clientWidth/120);
  for(i=0;i<=OnezDivCount;i++){
    var Onez_L=(i % LineCount)*120;
    var Onez_T=document.body.clientHeight-parseInt(i / LineCount + 1)*FTLH;
    Onez_Status[i]=new Array(Onez_L,Onez_T,0);//Left,Top,Used
  }
}
function OnezVars(){
  this.state=0;
  this.max=0;
  this.left=0;
  this.top=0;
  this.MinIndex=0;
  this.DivIndex=0;
}
function LoadFrame(idtbl,caption,url,W,H,L,T,pos,state,min,max,close){
  //表格位置
  if(pos==1){//上左
    var myl=0;
    var myt=0;
  }else if(pos==2){//上中
	var myl=(document.body.scrollLeft+document.body.clientWidth-W)/2;
    var myt=0;
  }else if(pos==3){//上右
    var myl=screen.Width-W;
    var myt=0;
  }else if(pos==4){//中左
    var myl=0;
    var myt=(document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH)/2;
  }else if(pos==5){//正中
    var myl=(document.body.scrollLeft+document.body.clientWidth-W)/2;
    var myt=(document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH)/2;
  }else if(pos==6){//中右
    var myl=document.body.scrollLeft+document.body.clientWidth-W;
    var myt=(document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH)/2;
  }else if(pos==7){//下左
    var myl=0;
    var myt=document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH;
  }else if(pos==8){//下中
    var myl=(document.body.scrollLeft+document.body.clientWidth-W)/2;
    var myt=document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH;
  }else if(pos==9){//下右
    var myl=document.body.scrollLeft+document.body.clientWidth-W;
    var myt=document.body.scrollTop+document.body.clientHeight-H-FTLH-FBBLH;
  }else{
    var myl=L;
    var myt=T;
  }
  if(myt<0){
    myt=0;
  }
  var myw=W;
  var myh=H;
  var mytabel=$(idtbl);
  if(url==""){
    var theurl="about:blank";
  }else{
    var theurl=url.indexOf("?")==-1 ? url + "?onezid="+idtbl : url + "&onezid="+idtbl;
    theurl+='&theskin='+theskin;
  }
  
  if(mytabel!=null){
    CurZ++;
    mytabel.style.zIndex=CurZ;
    //窗体状态；正常、最小化、最大化
    if(state==1){//最小化
      if(eval(idtbl+"_vars").state==0){
        eval(idtbl+"_vars").left=mytabel.style.pixelLeft;
        eval(idtbl+"_vars").top=mytabel.style.pixelTop;
      }
      for(i=0;i<=OnezDivCount;i++){
        if(Onez_Status[i][2]==0){
          var myl=Onez_Status[i][0];
          var myt=Onez_Status[i][1];
          Onez_Status[i][2]=1;
          eval(idtbl+"_vars").MinIndex=i;
          break;
        }
      }
      myw=120;
      myh=0;
      if(caption.length>4){
        caption=caption.substring(0,4)+".";
      }
      $(idtbl+"_caption").innerHTML=caption;
      $(idtbl+"_main").style.display="none";
      $(idtbl+"_bottom").style.display="none";
      mytabel.style.zIndex=999+CurZ;
      eval(idtbl+"_vars").state=1;
    }else if(state==2){
      if(eval(idtbl+"_vars").state==1){
        if(eval(idtbl+"_vars").max==1){
          var myl=0;
          var myt=0;
          myw=document.body.clientWidth;
          myh=document.body.scrollTop+document.body.clientHeight-FTLH-FBBLH;
          eval(idtbl+"_vars").state=2;
        }else{
          var myl=eval(idtbl+"_vars").left;
          var myt=eval(idtbl+"_vars").top;
          eval(idtbl+"_vars").state=0;
        }
        $(idtbl+"_caption").innerHTML=caption;
        Onez_Status[eval(idtbl+"_vars").MinIndex][2]=0;
      }else if(eval(idtbl+"_vars").state==2){
        var myl=eval(idtbl+"_vars").left;
        var myt=eval(idtbl+"_vars").top;
        eval(idtbl+"_vars").max=0;
        eval(idtbl+"_vars").state=0;
      }else{
        eval(idtbl+"_vars").left=mytabel.style.pixelLeft;
        eval(idtbl+"_vars").top=mytabel.style.pixelTop;
        var myl=0;
        var myt=0;
        myw=document.body.clientWidth;
        myh=document.body.clientHeight-FTLH-FBBLH;
        eval(idtbl+"_vars").max=1;
        eval(idtbl+"_vars").state=2;
      }
      $(idtbl+"_main").style.display="";
      $(idtbl+"_bottom").style.display="";
      $(idtbl+"_table1").width=myw;
      $(idtbl+"_table1").height=myh;
      $(idtbl+"_table2").width=myw-FTLW-FTRW;
    }else{
      eval(idtbl+"_vars").state=0;
    }
    $(idtbl+"_title").width=myw-FTLW-FTRW;
    $(idtbl+"_table").width=myw;
    mytabel.style.left=myl+'px';
    mytabel.style.top=myt+'px';
    mytabel.style.display="";
    
    
    try{$(idtbl+"_body").contentWindow.ResetSize()}catch(e){}
    return true;
  }
  if(CurCount>=OnezDivCount-1 && idtbl!=="oneztipwindow"){
    alert("当前窗口已达到最大数,请关闭部分窗口后重试");
    return false;
  }
  CurZ++;
  eval(idtbl+"_vars=new OnezVars();");
  tmponez=("<img src=\"images/loading.gif\" id=\""+idtbl+"_wait\" style=\"position: absolute;left:"+(document.body.clientWidth/2-16)+"px;top:"+(document.body.clientHeight/2-16)+"px;z-index:"+CurZ+"\" /><div id=\""+idtbl+"\" style=\"display:; position: absolute;left:"+(myl-10000)+"px;top:"+myt+"px;z-index:"+CurZ+"\" onmousedown=\"SetTop("+idtbl+")\">");
  tmponez+=("<table id=\""+idtbl+"_table\" class=\"OnezTable\" width=\""+myw+"\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" onselectstart=\"return false\">");
  tmponez+=("<tr>");
  tmponez+=("<td width=\""+FTLW+"\" height=\""+FTLH+"\" class=\"tl\"> </td>");
  tmponez+=("<td id=\""+idtbl+"_title\" width=\""+(myw-FTLW-FTRW)+"\" class=\"tc\" valign=\"top\">");
  tmponez+=("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");
  tmponez+=("<tr>");
  tmponez+=("<td id=\""+idtbl+"_caption\" title=\""+caption+"\" class=\"caption\" onmousedown=\"if("+idtbl+"_vars.max==0){dargit(event,"+idtbl+")}\" ondblclick=\"if("+max+"==1){FrameMax('"+idtbl+"','"+caption+"','',"+myw+","+myh+","+myl+","+myt+","+pos+",2,"+min+","+max+","+close+")}\">"+caption+"&nbsp;</td>");
  if(min==1){
    tmponez+=("<td width=\""+MinW+"\" valign=\"top\"><a href=\"javascript:void(0)\" class=\"min\" style=\"width:"+MinW+"px;height:"+MinH+"px\" onclick=\"FrameMin('"+idtbl+"','"+caption+"','',"+myw+","+myh+","+myl+","+myt+","+pos+",1,"+min+","+max+","+close+")\"></a></td>");
  }
  if(max==1){
    tmponez+=("<td width=\""+MaxW+"\" valign=\"top\"><a href=\"javascript:void(0)\" class=\"max\" style=\"width:"+MaxW+"px;height:"+MaxH+"px\" onclick=\"FrameMax('"+idtbl+"','"+caption+"','',"+myw+","+myh+","+myl+","+myt+","+pos+",2,"+min+","+max+","+close+")\"></a></td>");
  }
  if(close==1){
    tmponez+=("<td width=\""+CloseW+"\" valign=\"top\"><a href=\"javascript:void(0)\" class=\"close\" style=\"width:"+CloseW+"px;height:"+CloseH+"px\" onclick=\"FrameClose('"+idtbl+"')\"></a></td>");
  }
  tmponez+=("</tr>");
  tmponez+=("</table>");
  tmponez+=("</td>");
  tmponez+=("<td width=\""+FTRW+"\" class=\"tr\"> </td>");
  tmponez+=("</tr>");
  tmponez+=("<tr>");
  tmponez+=("<td colspan=\"3\" id=\""+idtbl+"_main\">");
  tmponez+=("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");
  tmponez+=("<tr>");
  tmponez+=("<td width=\""+FBLW+"\" class=\"cl\"> </td>");
  tmponez+=("<td id=\""+idtbl+"_table1\" class=\"cc\" width=\""+(myw-FBLW-FBRW)+"\" height=\""+myh+"\"><iframe id=\""+idtbl+"_body\" style=\"WIDTH: 100%; HEIGHT: 100%;position:relative;top:-4px;border:0\" frameborder=\"0\" marginWidth=\"0\" marginHeight=\"0\" src=\""+theurl+"\"></iframe></td>");
  tmponez+=("<td width=\""+FBRW+"\" class=\"cr\"></td>");
  tmponez+=("</tr>");
  tmponez+=("</table>");
  tmponez+=("</td>");
  tmponez+=("</tr>");
  tmponez+=("<tr>");
  tmponez+=("<td colspan=\"3\" id=\""+idtbl+"_bottom\">");
  tmponez+=("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");
  tmponez+=("<tr>");
  tmponez+=("<td width=\""+FBBLW+"\" class=\"bl\" height=\""+FBBLH+"\"></td>");
  tmponez+=("<td id=\""+idtbl+"_table2\" class=\"bc\" width=\""+(myw-FBBLW-FBBRW)+"\"> </td>");
  tmponez+=("<td width=\""+FBBRW+"\" class=\"br\"></td>");
  tmponez+=("</tr>");
  tmponez+=("</table>");
  tmponez+=("</td>");
  tmponez+=("</tr>");
  tmponez+=("</table>");
  tmponez+=("</div>");
  for(i=0;i<=OnezDivCount;i++){//写入空白层
    if($("onezdiv"+i).innerHTML.length==0){
      $("onezdiv"+i).innerHTML=tmponez;
      $("onezdiv"+i).style.display="";
      eval(idtbl+"_vars").DivIndex=i;
      CurCount++;
      break;
    }
  }
}
function FrameInit(idtbl){
  var l=isIE?$(idtbl).style.pixelLeft:parseInt($(idtbl).style.left.slice(0,-2),10);
  if(l>0)return;
  try{
    isIE ? $(idtbl).style.pixelLeft+=10000 : $(idtbl).style.left=(l+10000+'px');
    var obj=isIE ? $(idtbl+'_wait').parentElement: $(idtbl+'_wait').parentNode;
    obj.removeChild($(idtbl+'_wait'));
  }catch(e){}
}
function FrameRes(idtbl){
  try{$("minwins").removeChild($("min_"+idtbl))}catch(e){}
  CurZ++;
  $(idtbl).style.zIndex=CurZ;
  $(idtbl).style.display='block';
}
//最小化
function FrameMin(idtbl,caption,url,W,H,L,T,pos,state,min,max,close){
  try{$("minwins").removeChild($("min_"+idtbl))}catch(e){}
  var e=document.createElement('li');
  e.id='min_'+idtbl;
  e.innerHTML='<a href="#" onclick="FrameRes(\''+idtbl+'\')">'+caption+'</a>';
  $("minwins").appendChild(e);
  $(idtbl).style.display='none';
}
//最大化
function FrameMax(idtbl,caption,url,W,H,L,T,pos,state,min,max,close){
  LoadFrame(idtbl,caption,url,W,H,L,T,pos,state,min,max,close);
}
//关闭
function FrameClose(idtbl,issys){
  if(idtbl=="Group"){
    CloseTopWin();
    return;
  }
  var TheIndex=eval(idtbl+"_vars").DivIndex;
  $("onezdiv"+TheIndex).innerHTML="";
  $("onezdiv"+TheIndex).style.display="none";
  CurCount--;
}
//设置为最顶端
function SetTop(obj){
  if(obj.style.zIndex==CurZ||obj.style.zIndex>999){
    return;
  }
  CurZ++;
  obj.style.zIndex=CurZ;
}
//设置图标
function SetIcon(idtbl,icon){
  var obj=$(idtbl+"_caption");
  if(icon){
    obj.style.paddingLeft="20px";
    obj.style.backgroundImage="url(images/icon/"+icon+".gif)";
    obj.style.backgroundPosition="0 6px";
    obj.style.backgroundRepeat="no-repeat";
  }else{
    obj.style.paddingLeft="5px";
    obj.style.backgroundImage="";
  }
}