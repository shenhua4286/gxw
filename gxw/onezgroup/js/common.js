var isIE = document.all && window.external ? 1 : 0;
var isW3C =typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat'?true:false;
function stopError() {
  return true;
}
window.onerror = stopError;
function getcookie(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	seconds = seconds ? seconds : 8400000;
	var expires = new Date();
	expires.setTime(expires.getTime() + seconds);
	document.cookie = escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}
function $(id) {
	return document.getElementById(id);
}
function LastFocus(e){
 try{
 var r=e.createTextRange();
 r.moveStart('character',e.value.length);
 r.moveEnd('character',0);
 r.select();
 r.focus();
 }catch(e_){}
}
function _attachEvent(obj, evt, func) {
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(obj.attachEvent) {
		obj.attachEvent("on" + evt, func);
	}
}
function getoffset(e){
  var t=e.offsetTop;
  var l=e.offsetLeft;
  while(e=e.offsetParent){
    t+=e.offsetTop;
    l+=e.offsetLeft;
  }
  var rec = new Array(1);
  rec[0] = t;
  rec[1] = l;
  return rec;
}
function InsertFlash(Flash,Vars,Width,Height,ID,BoxName){
  var FlashHtml='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
  FlashHtml+='codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" ';
  FlashHtml+='width="' + Width + '" height="' + Height + '" id="' + ID + '">';
  FlashHtml+='<param name="movie" value="' + Flash + '">';
  FlashHtml+='<param name="quality" value="high">';
  FlashHtml+='<param name="wmode" value="transparent">';
  if(Vars!='')FlashHtml+='<param name="FlashVars" value="'+Vars+'">';
  FlashHtml+='<embed src="' + Flash + '?' + Vars + '" name="' + ID + '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" ';
  FlashHtml+='type="application/x-shockwave-flash" width="' + Width + '" wmode="transparent" height="' + Height + '"></embed>';
  FlashHtml+='</object>';
  $(BoxName).innerHTML=FlashHtml;
}