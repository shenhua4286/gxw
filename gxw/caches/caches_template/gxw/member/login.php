<?php defined('IN_gxw') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit" />
<meta charset="UTF-8">
<title>长沙工业信息化调度系统</title>
<link href="<?php echo CSS_PATH;?>/gxw/css/base.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>/gxw2/css/ics.css" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>/gxw2/css/swiper3.07.min.css" />
<script type="text/javascript" src="<?php echo CSS_PATH;?>/gxw2/js/jquery-1.11.2.min.js"></script>
<script src="http://api.map.baidu.com/components?ak=XGnXhb5r9ofOnLy949arfNjP&v=1.0"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>swiper3.07.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>gxw.js"></script>
</head>
<body style="overflow:auto;">
<style>
	.i-header{
		background: transparent;
	}
    .nav-active{
           color: #02A1D0 !important;
           font-weight: 700;
        }
     .x-content{
        background: transparent;
          min-height: 68%;
     }
     .login-widget {
       background: rgba(255, 255, 255, 0.95);
       background: #fff\9;
       border:0;
     }
     .bigbg{
        height:100%;
        background-size: cover;
        top:0;

     }
     .login-widget-title{
     	color: #333;
        font-weight: 400;
        font-size: 20px
     }
	.navbar{
		display: none;
	}
	.ifooter{
		position: absolute;
		bottom: 0;
		left:0;
	}
	.tq {
	  margin-top: 18px;
	  margin-right: 79px;
	}
    .hemin{
        font-size:19px;
        text-indent: 20px;
    }
    body{
        min-height: 849px;
    }
</style>
<script>
	if(self === top){
		location.href="index.php";
	}
</script>
<style>
	.login-widget{
		float:'static'
	}
</style>
    <!-- <div class="login-info" style="margin:0 auto">
        <img src="<?php echo CSS_PATH;?>/gxw/img/login-img.png">
    </div>  -->

    <div class="denglu-bg">
        <div class="login-widget" style="  margin: 0 0 0 191px;">
            <div class="login-widget-title">欢迎登录</div>
            <form target="main"  method="post" action="" onsubmit="loadMenu(27);menu(27);" id="myform" name="myform">
                <input type="hidden" name="forward" id="forward" value="<?php echo $forward;?>">

                <div class="login-input"><label><?php echo L('username');?>：</label>
                    <input type="text" id="username" name="username" size="22" class="h38 w200"></div>

                <div class="login-input"><label>密&nbsp&nbsp&nbsp码：</label>
                    <input type="password" id="password" name="password" size="22" class="h38 w200">
                </div>
                <div class="login-input"><label><?php echo L('checkcode');?>：</label>
                    <input type="text" id="code" name="code" size="22" class="h38 w200" style="width:73px;">
                    <div class="yzm-tu"><?php echo form::checkcode('code_img', '4', '14', 120, 26);?><div class="gh-yzm">单击图片更换验证码</div></div>
                </div>
                    <div class="login-input">
                         <input type="submit" name="dosubmit" id="dosubmit" value="<?php echo L('login');?>" class="submit-bt"></div>
            </form>

            <div class="zhucewj"><a href="index.php?m=member&c=index&a=register" class="zhuce b-hover">注册</a>
                <!-- <a href="" class="wangji b-hover">忘记密码</a>  -->
            </div>
        </div>
    </div>

<!-- <div class="zhanshi">
    <div class="w1200">
        <div class="zs-li">
            <img src="<?php echo IMG_PATH;?>denglu/xiangmu.png" alt="">
           <div class="zs-info">
                <h4>决策的重要依据</h4>
                
                <p>真实的数据填报是本系统顺利运行的基础，也是长沙工业决策的重要依据，您也可以从这里获得指导企业生产经营的海量信息。感谢您的支持！</p>
            </div>
        </div>
        <div class="zs-li">
            <img src="<?php echo IMG_PATH;?>denglu/xxh.png" alt="">
            <div class="zs-info">
                <h4>便捷的沟通渠道</h4>
                <p>长沙工业人自己的交流平台，您可以在这里与行业部门及上下游企业自由交流，发表您的看法。</p>
            </div>
        </div>
        <div class="zs-li">
            <img src="<?php echo IMG_PATH;?>denglu/zixun.png" alt="">
            <div class="zs-info">
                <h4>权威的行业资讯</h4>
                <p>为您提供行业最新资讯以及行业数据,包括行业前景预测,行业分析报告,商机信息。</p>
            </div>
        </div>
    </div>
</div>  -->
<script>
   

    var alertDiv = '<div class="alert-box"><div class="alert"><h3>温馨提示<div class="gbi"></div></h3><div class="alert-info"> <img class="alert-img" src="<?php echo CSS_PATH;?>gxw2/img/mail.png" alt=""><p></p></div><div class="make-sure"><div class="sure">我知道了</div></div></div></div>'




    //alertInfo("长沙市工业和信息化项目库管理系统新版本正式上线试运行，原有账户名不变，密码统一变更为111111，请完善和核对现有企业和项目信息，及时更改密码,欢迎加入QQ群：260226212与我们一起交流","<?php echo CSS_PATH;?>gxw2/img/mail.png");

     
</script>  


