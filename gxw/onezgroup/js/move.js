self.onError=null;  
//物件拖放开始                     
var ey=0,ex=0,lx=0,ly=0,canDrg=false,thiso=null;//
var x, y,rw,rh;
var divs=document.getElementsByTagName("div");
for (var i=0;i<divs.length;i++){ 
if(divs[i].getAttribute("rel")=="drag"){
divs[i].onmousemove=function(){
thismove(this);//实时得到当前对象与鼠标的值以判断拖动及关闭区域;
}
/*
var c=1;if(document.all)c=0;
divs[i].childNodes[c].onmousedown=function(){
dargit(this,event);
}
*/
//divs[i].onmousedown=function(){
// st(this);
//} 
}
}

function thismove(o){
  rw=parseInt(x)-parseInt(o.style.left);
  rh=parseInt(y)-parseInt(o.style.top);
}
function dargit(e,o){
  if(!isIE || e.button==1){
    thiso = o;
    canDrg = true;
    if(!document.all){
    lx = e.clientX; ly = e.clientY;
    }else{
    lx = event.x; ly = event.y;
    }
    if(document.all) thiso.setCapture();
    
    //st(o);//置前或置后
  }
}

document.onmousemove = function(e){
if(!document.all){ x = e.clientX; y = e.clientY; }else{ x = event.x; y = event.y; }
if(canDrg){
//if(rh<=20 && rw<180 ){//如果要设定拖动区域可以作判断
var ofsx = x - lx;
if(parseInt(thiso.style.left) + ofsx<document.body.clientWidth-28){
  thiso.style.left = parseInt(thiso.style.left) + ofsx;
  lx = x;
}
var ofsy = y - ly;
if(parseInt(thiso.style.top) + ofsy<document.body.clientHeight-28 && parseInt(thiso.style.top) + ofsy>0){
  thiso.style.top = parseInt(thiso.style.top) + ofsy;
  ly = y;
}
//}else{canDrg=false;}
}
}

document.onmouseup=function(){
canDrg=false;//拖拽变量设为false
if(document.all && thiso != null){
//ie下，将清捕获;
thiso.releaseCapture();
thiso = null;
}
}

function set(obj){
obj=obj.parentNode.parentNode;
if(obj.getAttribute("rel"));
//obj.style.zIndex=1;

}
function st(o){

var p = o.parentNode;
if(p.lastChild != o){
p.appendChild(o);
}

if(rh<=20 && rw>=180){
canDrg=false;
//如果选择的是关闭区域;
window.status=rw+"|"+rh;
if(p.firstChild == o) return;
p.insertBefore(o, p.firstChild);
}
}
//物件拖放结束