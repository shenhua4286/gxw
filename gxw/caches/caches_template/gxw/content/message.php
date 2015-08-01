<?php defined('IN_gxw') or exit('No permission resources.'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>提示信息</title>

<style type="text/css">
<!--
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#333;text-decoration: underline}
.showMsg{background:#fff;border:1px solid #ccc; zoom:1; width:390px; height:220px;position:absolute;top:50%;left:450px;margin:-110px 0 0 -195px;font-family: microsoft yahei}
.showMsg h5{background:#f2f2f2;border-bottom:1px solid #E5E5E5;background-repeat: no-repeat; color:#4c4c4c; height:36px; line-height:40px;*line-height:40px; overflow:hidden; font-size:15px; text-align:center;font-weight: 700}
.showMsg .content{ padding:46px 12px 10px 45px; font-size:14px; height:66px;}
.showMsg .bottom{  margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
.showMsg .ok,.showMsg .guery{background: url(<?php echo IMG_PATH?>/msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
<script type="text/javaScript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
<script language="JavaScript" src="<?php echo JS_PATH;?>admin_common.js"></script>
</head>
<body style="width:980px; margin:0 auto;">
<!-- jerry提示框 -->
<div class="showMsg" style="text-align:center">
	<h5>提示信息</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline; max-width:280px"><?php echo $msg;?></div>
    <div class="bottom">
    
    <?php if($url_forward=='goback' || $url_forward=='') { ?>
	<a href="javascript:history.back();" >[点这里返回上一页]</a>
	<?php } elseif ($url_forward=="close") { ?>
	<input type="button" name="close" value=" 关闭 " onClick="window.close();">
	<?php } elseif ($url_forward=="blank") { ?>
	<?php } elseif (is_array($url_forward)) { ?>
		<?php $n=1; if(is_array($url_forward)) foreach($url_forward AS $k => $v) { ?>
			<a href="<?php echo strip_tags($v);?>" class="blue-bt"><?php echo $k;?></a>
		<?php $n++;}unset($n); ?>
	<?php } elseif ($url_forward) { ?>
	<a href="<?php echo strip_tags($url_forward);?>">如果您的浏览器没有自动跳转，请点击这里</a>
	<?php if(!$ms) { ?>
		<?php $ms=1250;?>
	<?php } ?>
	<script language="javascript">setTimeout("redirect('<?php echo strip_tags($url_forward);?>');",<?php echo $ms;?>);</script> 
	<?php } ?>
	<?php if($dialog) { ?><script style="text/javascript">window.top.location.reload();window.top.art.dialog({id:"<?php echo $dialog;?>"}).close();</script><?php } ?>
        </div>
</div>
<script style="text/javascript">
	function close_dialog() {
		window.top.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();
	}
</script>
</body>
</html>





