function setbutton(){
  document.writeln("<div class=\"onez_button\">");
  document.writeln("<div class=\"onez_button_left\"></div>");
  document.writeln("<div class=\"onez_button_center\"></div>");
  document.writeln("<div class=\"onez_button_right\"></div>");
  document.writeln("</div>");
}
function onezbuttonclick(id,type){
  
}
function BtnNormal(obj){
  obj.className="btn_normal";
}
function BtnOver(obj){
  obj.className="btn_hover";
}
function BtnDown(obj){
  obj.className="btn_down";
}