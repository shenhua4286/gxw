    function alertInfo(pp,img){
        if(typeof(pp)=="string"){
            $('body',top.window.parent.document).append('<div class="alert-box"></div><div class="alert"><h3>温馨提示<div class="gbi"></div></h3><div class="alert-info"> <img class="alert-img" src="'+img+'" alt=""><p>'+pp+'</p></div><div class="make-sure"><div class="sure">我知道了</div></div></div>');
        }else{
            $('body',top.window.parent.document).append('<div class="alert-box"></div><div class="alert"><h3>温馨提示<div class="gbi"></div></h3><div class="alert-info"> <img class="alert-img" src="'+img+'" alt=""><p>'+$(pp).html()+'</p></div><div class="make-sure"><div class="sure">我知道了</div></div></div>');
        }
        $('.gbi,.sure').on("click",function(){
            $('.alert-box').hide();
            $('.alert').hide();
        })
    }
    
