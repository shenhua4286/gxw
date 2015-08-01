<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
 <?php 
$index=0;
 //'formtype'=>'box'
if(is_array($result)){
	foreach($result as $v){
		//print_r($v);
		$index++;
?>
<table width="100%" cellspacing="0" class="table-list">
	<thead>
		<tr>
			<th align="left"><strong><?php echo $index.'、'.$fields[$v['field']]['name']?></strong></th>
			<th width="10%" align="center"><?php echo L('stat_num')?></th>
			<th width='30%' align="center"><?php echo L('thumb_shi')?></th>
		</tr>
	</thead>
<tbody>
<?php
$i = 1;


$settings = string2array($v['setting']);

$setting = $settings['options'];
$options = explode("\n",$setting);
$formtype=$v['formtype'];

if(is_array($options)){
	if($formtype == 'box'){
		foreach($options AS $_k=>$_v){
			$_key = $_kv = $_v;
			if (strpos($_v,'|')!==false) {
				$xs = explode('|',$_v);
				$_key =$xs[0];
				$_kv =$xs[1];
			}
?>
	
	<?php 
		
	?>
		<tr>
		<td> <?php echo intval($_k+1).' 、 '.$_key;?> </td>
		<td align="center"><?php
				$number = 0;
					//表单统计
				foreach ($datas AS $__k=>$__v) {
					if(trim($__v[$v['field']])==trim($_kv))  $number++;
				}
				echo $number;
						?></td>
		<td align="center">
		<?php 
			if($total==0){
				$per=0;
			}else{
				$per=intval($number/$total*100);
			}
		?>
		<div class="vote_bar">
        	<div style="width:<?=$per?>%"><span><?php echo $per;?> %</span> </div>
        </div>
		</td>
		</tr>
	

	<?php 
		}
	}else{
		$number = 0;
		foreach ($datas AS $__k=>$__v) {
			$value=trim($__v[$v['field']]);
			$defaultvalue=trim($settings['defaultvalue']);
			
			if($value != $defaultvalue){
				str_replace($defaultvalue, '', $value);
				$number++;
	?>
	<tr class="<?php if($number >5){?>hidden<?php }?>">
				<td colspan="2" > <?php echo $number.'、'.$value ?> </td>
				<td align="center">
					<!--  
						<a style="color: blue;text-decoration: underline" href="javascript:openList(<?php echo "'{$formid}','{$v['field']}','{$fields[$v['field']]['name']}'" ?>);"><?php echo $number;?></a>				
					 -->
				</td>
				<!-- <td align="center">
				<?php if($total==0){
							$per=0;
							}else{
								$per=intval($number/$total*100);
							}
				?>
				<div class="vote_bar">
		        	<div style="width:<?=$per?>%"><span><?php echo $per;?> %</span> </div>
		        </div>
				</td>
				 -->
		</tr>
	<?php 
			}
		}
		?>
		<tr>
			
			<td>
				<?php 
					if($number >5){
				?>
				<a class="show" href="javascript:;">显示更多</a>
				<?php }?>&nbsp;
			</td>
			<td colspan="2" align="right">
			<a style="color:blue;" href=javascript:openList(<?php echo "'{$formid}','{$v['field']}','{$fields[$v['field']]['name']}'"?>);>
				合计<?php echo $number?>数据
			</a>	
			</td>
		</tr>
<?php
	}
	$i++;
	}
}
?>
	</tbody>
</table>
<div class="bk10"></div>
<?php 
	}
?>
<div class="bk10"></div>
</div>

<script>
$(function(){
	$(".show").click(function(){
		var isShow=$(this).data("show");
		var obj=$(this).parent().parent();
		var siblings=$(obj).siblings(".hidden");
		
		if(!isShow){
			$(siblings).css("display",'table-row');
			$(this).data("show",'2');
			$(this).text("隐藏更多");
		}else{
			$(siblings).css("display",'');
			$(this).data("show",'');
			$(this).text("显示更多");
		}
		
		
	});
});

/**打印**/
function print(){

	
}

function openList(id,field,title) {
	   window.top.art.dialog({id:'openList'}).close();
	   window.top.art.dialog({title:'<?php echo L('stat_formguide')?>--'+"列表", id:'openList', iframe:'?m=formguide&c=formguide&a=viewList&formid='+id+"&field="+field ,width:'600px',height:'400px'}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function stat(id, title) {
    window.top.art.dialog({id:'stat'}).close();
    window.top.art.dialog({title:'<?php echo L('stat_formguide')?>--'+title, id:'stat', iframe:'?m=formguide&c=formguide&a=stat&formid='+id ,width:'700px',height:'500px'}, function(){window.top.art.dialog({id:'edit'}).close()});

}
</script>

</body>
</html>








