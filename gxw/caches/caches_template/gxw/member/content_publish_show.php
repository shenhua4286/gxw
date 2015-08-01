<?php defined('IN_gxw') or exit('No permission resources.'); ?><!-- 展示页
 -->
<?php $type=isset($_GET['type']) ? $_GET['type']:'basic';?>
<?php include template('member', 'header'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js"
	charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js"
	charset="UTF-8"></script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>jquery-form.js"></script>
<script src="<?php echo JS_PATH;?>inputFormart.js"></script>



<div class="main_page">
	<div class="x-content">
			<div class="main-info">
				<h3 class="frame-name"></h3>
				<div class="table-widget padding10">
					<table>
							<?php $n=1; if(is_array($forminfos)) foreach($forminfos AS $k => $v) { ?> 
									<?php if($v['name']!='栏目') { ?>
										<?php if($v['formtype'] !='textarea') { ?>
											<?php if($index%2==0) { ?><tr><?php } ?>
												<th class="w200 textr">
													<?php echo $v['name'];?>：
												</th>
												<td class="w300 textl noborder"><?php echo $v['form'];?></td>
											
											<?php if($index%2==1) { ?></tr><?php } ?>
											
											<?php $index++;?>
										<?php } else { ?> 
										<!-- textarea独占一行 -->
											<tr>
												<th class="w200 textr" >
													<?php echo $v['name'];?>：
												</th>
												<td  colspan="3" class="w300 textl noborder"><?php echo $v['form'];?></td>
											<tr>
										<?php } ?>
									<?php } ?> 
											
									
							<?php $n++;}unset($n); ?> 
					  </table>		
				</div>
			</div>
	</div>
</div>
