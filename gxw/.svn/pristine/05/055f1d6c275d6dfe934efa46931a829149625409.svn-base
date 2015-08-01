<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo L('gxw_logon')?></title>
<link href="{CSS_PATH}/gxw/css/base.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{
	margin:0;
	padding:0;
}

	body{font-family: microsoft yahei;}
	div{overflow:hidden; *display:inline-block;}div{*display:block;}
	.login_box{/*background:url(<?php echo IMG_PATH?>admin_img/login_bg.jpg) no-repeat; */width:602px; height:416px; overflow:hidden; position:absolute; left:50%; top:50%; margin-left:-301px; margin-top:-208px;}
	.login_iptbox{color:#666;font-size:12px;height:30px;left:50%;
margin-left:-280px;position:absolute;width:560px; overflow:visible;}
	.login_iptbox .ipt{height:24px; width:110px; margin-right:22px; color:#fff; background:url(<?php echo IMG_PATH?>admin_img/ipt_bg.jpg) repeat-x; *line-height:24px; border:none; color:#000; overflow:hidden;}
	<?php if(SYS_STYLE=='en'){ ?>
	.login_iptbox .ipt{width:100px; margin-right:12px;}
	<?php }?>
	.login_iptbox label{ *position:relative; *top:-6px;}
	.login_iptbox .ipt_reg{margin-left:12px;width:46px; margin-right:16px; background:url(<?php echo IMG_PATH?>admin_img/ipt_bg.jpg) repeat-x; *overflow:hidden;text-align:left;padding:2px 0 2px 5px;font-size:16px;font-weight:bold;}
	.login_tj_btn{margin-left:16px; border:none; cursor:pointer; padding:0px;}
	.yzm{float:right;color:#888;font-size:12px;padding-right:39px;}
	.yzm img{height:30px;}
	.yzm a{color:#888;font-size:12px;}
	.cr{font-size:12px;font-style:inherit;text-align:center;color:#ccc;width:100%; position:absolute; bottom:58px;}
	.cr a{color:#ccc;text-decoration:none;}
	.gl-dl{padding:10px;}
	.login-info{
		float:left;
	}
	.login-info img{
		display: block;
		padding: 150px 0 0 50px;
	}
	.login-widget{
		padding:40px 80px;
		margin:80px 100px 0 0;
		width:300px;
		height:300px;
		border:1px solid #ddd;
		  margin: 150px auto 0;
	}
	.login-widget-title{
		font-size:24px;
		font-weight:700;
		color:#012c5f;
		margin-left:73px;
		margin-bottom:16px;
	}
	.h38{
		height:18px;
		border:1px solid #ccc;
		padding:8px;
	}
	.w200{
		width:200px;
	}
	.w120{
		width:120px;
	}
	.login-widget form label{
		width:70px;
		display: inline-block;
		font-size:14px;
		color:#333;
	}
	.login-input{
		margin:12px 0;
	}
	.submit-bt{
		width:200px;
		background:#55acef;
		color:#fff;
		font-size: 16px;
		line-height: 40px;
		margin-left:70px;
		box-shadow: none;
		border:none;
		cursor:pointer;
	}
	.submit-bt:hover{
		box-shadow:0px 0px 5px #0B558E inset;
		background: #368DD0;
	}
	.zhucewj{
		width:200px;
		height:50px;
		margin-left:70px;
		margin-top:20px;
	}
	.zhuce{
		display: block;
		float:left;
		color:#666;
	}
	.wangji{
		display: block;
		float:right;
		color:#666;
	}
	.w200 {
	  width: 200px;
	}
	.ipt {
	  height: 18px;
	  border: 1px solid #ccc;
	  padding: 8px;
	}

	#dosubmit {
		background: #2F911A;
		border-radius: 1px;
		/* padding: 5px 10px; */
		color: #fff;
		/* display: inline-block; */
		/* margin-bottom: 15px; */
		border: none;
		cursor: pointer;
		margin-left: 75px;
		padding: 11px 79px;
	}
	.x-header {
	  min-height: 40px;
	  width: 100%;
	  background: #012c5f;
	  overflow: hidden;
	}
	.x-header h1 {
	  font-size: 17px;
	  background: url(<?php echo IMG_PATH?>admin_img/logo30.png) no-repeat;
	  padding-left: 39px;
	}
	.z-title {
	  line-height: 38px;
	  margin-left: 20px;
	  width: 500px;
	  float: left;
	}
	.white {
	  color: #fff;
	}
	.login-nav {
	  float: right;
	  /* width: 375px; */
	  margin-right: 30px;
	}
	.login-nav li a {
	  color: #fff;
	  line-height: 40px;
	  font-size: 14px
	}
	.login-nav li {
	  float: left;
	  margin: 0;
	}
	a{
		text-decoration:none;
	}
	li {
	  list-style-type: none;
	}
	.login-nav span {
	  color: #fff;
	  margin: 0 14px;
	  height: 40px;
	  line-height: 40px;
	  font-size: 14px;
	}
</style>




<script language="JavaScript">
<!--
	if(top!=self)
	if(self!=top) top.location=self.location;
//-->
</script>
</head>


<body onload="javascript:document.myform.username.focus();">

<!-- <div id="login_bg" class="login_box">
	<div class="login_iptbox">
   	 <form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform"><input name="dosubmit" value="" type="submit" class="login_tj_btn" />
   	 <div class="gl-dl"><label><?php echo L('username')?>：</label><input name="username" type="text" class="ipt" value="" /></div>
   	 <div class="gl-dl"><label><?php echo L('password')?>：</label><input name="password" type="password" class="ipt" value="" /></div>
   	 <div class="gl-dl"><label><?php echo L('security_code')?>：</label><input name="code" type="text" class="ipt ipt_reg" onfocus="document.getElementById('yzm').style.display='block'" /></div>
    <div id="yzm" class="yzm"><?php echo form::checkcode('code_img')?><br /><a href="javascript:document.getElementById('code_img').src='<?php echo SITE_PROTOCOL.SITE_URL.WEB_PATH;?>api.php?op=checkcode&m=admin&c=index&a=checkcode&time='+Math.random();void(0);"><?php echo L('click_change_validate')?></a></div>
     </form>
    </div>
    <div class="cr">湖南星通科技</div>
</div> -->


<div class="x-header">
    <h1 class="z-title white">长沙市工业和信息化项目调度系统</h1>
    <div class="login-nav">
        <li><a href="http://localhost/gxw/">首页</a><!-- <span>|</span> --></li>
<!--         <li><a href="">提意见</a><span>|</span></li>
        <li><a href="">帮助</a></li> -->
    </div>
</div>




<div class="login-widget">
    <div class="login-widget-title">管理员登录</div>
    <form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform">
        <input type="hidden" name="forward" id="forward" value="{$forward}">

        <div class="login-input"><label><?php echo L('username')?>：</label>
            <input name="username" type="text" class="ipt" value="" /></div>

        <div class="login-input"><label><?php echo L('password')?>：</label>
            <input name="password" type="password" class="ipt" value="" />
        </div>
            <div class="login-input"><label><?php echo L('security_code')?>：</label>
                <input name="code" style="width:60px;" type="text" class="ipt ipt_reg" onfocus="document.getElementById('yzm').style.display='block'" />
                <div id="yzm" class="yzm"><?php echo form::checkcode('code_img')?><br /><a href="javascript:document.getElementById('code_img').src='<?php echo SITE_PROTOCOL.SITE_URL.WEB_PATH;?>api.php?op=checkcode&m=admin&c=index&a=checkcode&time='+Math.random();void(0);"><?php echo L('click_change_validate')?></a></div>
            </div>
            <div class="login-input">
                 <input name="dosubmit" id="dosubmit" value="登录" type="submit" class="login_tj_btn" /></div>
                 
    </form>
</div>










</body>
</html>