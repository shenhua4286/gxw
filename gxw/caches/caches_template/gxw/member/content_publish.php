<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?> 
<?php $isShow=$_GET['isShow'];?>
<script type="text/javascript">
                <!--
                var charset = '<?php echo CHARSET;?>';
                var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
                //-->
            </script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>content_addtop.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--

//-->
$(function(){
	
	$('th:contains("上")').each(function(){
		var s = this.innerHTML;
		s = s.replace("上","<?php echo date('n',strtotime('-1 month'));?>");
		this.innerHTML = s;
	});
	
	<?php if($catid==15) { ?>
		$("textarea").css("color","#777")
		var focusOn = false;
		$("textarea").focus(function(){
			if(focusOn==false){
				$(this).val('');
			}
			focusOn=true;
			$(this).css("color","#333")
		});
	<?php } ?>
});
</script>
<style>
	.main_page{
		width:1200px;
		margin:0 auto;

	}
	.frame-name{
		font-size: 16px;
		font-weight: 400;
		color: #222;
		padding-bottom: 23px;
		margin-top: -10px;
	}
</style>
<div class="main_page">
	<div class="x-content">
		<form method="post" action="" id="myform" name="myform">
			<div class="main-info">
				<?php if($catid==15) { ?>
				<div class="blue-tool"><a href="index.php?m=member&c=content&a=published&catid=<?php echo $catid;?>" class="blue-bt red-bt xfr">我的提问记录</a></div>
				<?php } ?>
				<?php if($catid==17) { ?>
				<div class="blue-tool"><a href="index.php?m=member&c=content&a=published&catid=<?php echo $catid;?>" class="blue-bt red-bt xfr">我的反馈记录</a></div>
				<?php } ?>
				<?php if($catid==19) { ?>
				<div class="blue-tool"><a href="index.php?m=member&c=content&a=published&catid=<?php echo $catid;?>" class="blue-bt red-bt xfr">我的申请记录</a></div>
				<?php } ?>				
				<h3 class="frame-name"></h3>
				<div class="table-widget padding10">
					<table>
						<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
						<!--<?php print_r($forminfos[pro_type])?>-->
                        <input type="hidden" name="info[yearMonth]" id="yearMonth" value="<?php echo date('Y-m-d',SYS_TIME);?>" size="10" class="date" readonly="">
                         <!--  <tr>
                          	<th class="w150 textr">所属月份：</th>
                              <td class="w600 textl noborder"><?php echo date('Y年m月',SYS_TIME);?></td>
                          </tr> -->
							
							<?php $n=1; if(is_array($forminfos)) foreach($forminfos AS $k => $v) { ?> 
									<?php if($v['name']!='栏目') { ?>
									<tr>
										<th class="w150 textr"><?php if($v['star']) { ?> <font color="red">*</font><?php } ?>
											<?php echo $v['name'];?>：
										</th>
										<td class="w600 textl noborder"><?php echo $v['form'];?>
										<?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></td>
									</tr>
									<?php } ?> 
							<?php $n++;}unset($n); ?> 
						<?php if(!$isShow) { ?>
						<tr>
							<th></th>
							<td>
								<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
								<input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>"> 
								<input name="id" type="hidden" value="<?php echo $id;?>"> 
								<input type="hidden"  name="t" value="<?php echo $t;?>"/>
								<input type="hidden"  name="pt" value="<?php echo $pt;?>"/>
								<input type="hidden"  name="menu" value="<?php echo $_GET['menu']?>"/>
								<input name="dosubmit" type="submit" id="dosubmit" value="保存" class="button red-bt">
							</td>
						
						</tr>
						<?php } ?>
					  </table>				 
				</div>
			</div>
		 </form>

	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
			var isSubmit=false;
            $(function() {
                $.formValidator.initConfig({
                    formid: "myform",
                    autotip: true,
                    onerror: function(msg,obj){
                    	alert(msg);
                    },onsuccess:function(){
                    	<?php if($catid==10) { ?>
                            var img=$(".picList").find("img");
                            if(img.length==0){
                                alert("请上传产品图片");
                                return false;
                            }
                        <?php } ?>

                    	if(!isSubmit){
                    		isSubmit=true;
                    		return true;
                    	}else{
                    		//console.log("重复提交");
                    	}
                    	return false;
                    }
                });
                <?php echo $formValidator;?>
            });
            </script>
<?php if($isShow) { ?>
<script src="<?php echo JS_PATH;?>inputFormart.js"></script>
<?php } ?> 

