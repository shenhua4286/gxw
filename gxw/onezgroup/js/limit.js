function Click(event){
	//��ֹ�Ҽ�
	try{
    var obj=isIE ? window.event.srcElement.parentElement : event.target.parentNode;
    if(obj.id=='showbox'){
      return true;
    }
	}catch(e){}
	if(isIE){
    window.event.returnValue = false;
  }else{
    event.preventDefault();
  }
}
function KeyDown(event){
  var keycode=isIE?event.keyCode:event.which;
  var ctrl=isIE?window.event.ctrlKey:event.ctrlKey;
	if(ctrl){//Ctrl+�����
    if(keycode !== 67 && keycode !== 80 && keycode !== 86 && keycode !== 88 && keycode !== 90){//�����ڸ��ơ���ӡ
      try{
        if(isIE){
          window.event.returnValue = false;
        }else{
          event.preventDefault();
        }
        return;
      }catch(e){
      
      }
    }
	}
	//��ֹF5ˢ��
	if (keycode== 116){	
    if(isIE){
      window.event.returnValue = false;
    }else{
      event.preventDefault();
    }
        return;
	}
}
//��ֹ�Ի��������˵��������,���showcontent ������������Ӷ���ҳ����
function Click2(){
	if(isIE){
    window.event.returnValue = false;
  }else{
    event.preventDefault();
  }
	return ;
}
//document.oncontextmenu = Click;
//document.onmousedown = Click2; 
//document.onkeydown = KeyDown;