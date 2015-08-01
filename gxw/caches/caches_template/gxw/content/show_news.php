<?php defined('IN_gxw') or exit('No permission resources.'); ?>  	<style>
  	.times{
  		margin-bottom:10px;
  	}
  	#btnPrint{
  		margin-top:18px;
  	}
  	a{
  		color:#333;
  	}
  	.tz-neirong{
  		padding-top: 40px;
  		border-left: 1px solid #ccc;
  		padding-left: 20px;
  	}
  	</style>
  	<link rel="stylesheet" href="<?php echo CSS_PATH;?>/gxw2/css/ics.css" />
	<div class="x-content">
	<?php if(!isset($_GET['t'])) { ?> 
	<!--startprint1-->
		<div class="main-info" style="width:900px;">
		
		
		<div class="left-tongzhi">
             <div class="laba-tongzhi">
                <img src="<?php echo CSS_PATH;?>gxw2/img/dalaba.png" alt="">
                <div class="tongzhi-title">
                    通知公告
                </div>
                <div class="tongzhi-title-en">
                    notice
                </div>
            </div>
            <?php $index=0?>
                <?php $n=1;if(is_array(subcat(12))) foreach(subcat(12) AS $v) { ?>
                     <a href="<?php echo $v['url'];?>" class="tongzhi-li  <?php if($catid==$v['catid']) { ?>on<?php } ?>">
                         <?php echo $v['catname'];?>
                    </a>
                    <?php $index++;?>
                <?php $n++;}unset($n); ?>
        </div>
        <?php } ?>
        
		<div class="crumbs tz-neirong">
		        <div class="shortcut cu-span">
		    </div>
			<div class="tool-bar" style="font-size:20px;font-weight:700;text-align:center;color:#333;margin-bottom:10px;">
				<?php echo $title;?>
			</div>
          
			<div class="table-widget wenz" style="width:900px;" id="dy">
			<div class="times"><?php echo $inputtime;?></div>
			<?php echo $content;?>
			<input id="btnPrint" type="button" value="打印" onclick="javascript:preview(1);" />  
			</div>
			
		</div>
		<!--endprint1-->
	</div>
	</div>
	
	<script>  
	function preview(oper)         
	{  
	if (oper < 10)  
	{  
	bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
	sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
	eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
	prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html  
	prnhtmlprnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  
	window.document.body.innerHTML=prnhtml;  
	window.print();  
	window.document.body.innerHTML=bdhtml;  
	} else {  
	window.print();  
	}  
	}  
	</script>  
