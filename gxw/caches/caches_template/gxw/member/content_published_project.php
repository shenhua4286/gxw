<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script>
    $(function(){
			
    	/**<?php if(!$pro_type) { ?>
              $(".colselect span").text("全部");
        <?php } ?>
        <?php if(is_numeric($checkStatus) &&  $checkStatus >=0) { ?>
        	$(".checkStatus").val(<?php echo $checkStatus;?>);
        <?php } ?>
                $("#searchbtn").click(function () {
                	var input=$("[name='info[pro_type]']").eq(1);
                	var pro_type=$(input).val();;
                    var checkStatus=$(".checkStatus").val();
                    window.location="index.php?m=member&c=content&a=published&catid=9&t=1&pro_type="+pro_type+"&checkStatus="+checkStatus;
                });
            **/
    })
    
    function submit(id){
    	if (parent.status !=99){
    		alert("请先等待资料审核通过/或提交资料进行审核")
    		return ;
    	}
    	var url="index.php?m=member&c=content&a=submit&id="+id
    	$.get(url,'',function(data){
    		if(data.success){
    			alert('操作成功');
    			location.reload();
    		}else{
    			alert(data.msg);
    		}
    	},'json');
    	
    }
    
    function confirm_delete(id){
    	 if(confirm('确认删除吗？')) $('#myform').submit();
    }
	 	/**添加进度**/
	function add_progress(id, name,date,projectName) {
	 	var winid='add_progress';
		window.top.art.dialog({id:winid}).close();
		window.top.art.dialog({title:name,id:'edit',iframe:'index.php?m=member&c=content&a=publish&catid=13&projectId='+id+"&proDate="+date+"projectName="+projectName,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:winid}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:winid}).close()});
    }
    
</script>
	<form name="myform" id="myform" method="post">
		
	</form>
	<div class="x-content">
		<div class="main-info">
			<div class="blue-tool">
				<?php if($t==135 || $t==103 && $pt==103) { ?>
				<a href="index.php?m=member&c=index&a=project_excel" class="blue-bt red-bt xfr">数据导出</a>
				<?php } ?>
				<?php if(!empty($_GET["pt"])) { ?>
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&menu=1&t=<?php echo $_GET['t'];?>&pt=<?php echo $_GET['pt'];?>" class="blue-bt red-bt xfr">+添加项目</a>
				<?php } else { ?>
				<?php $pt=$_GET["t"];$t=61;?>
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&menu=1&t=<?php echo $t;?>&pt=<?php echo $pt;?>" class="blue-bt red-bt xfr">+添加项目</a>
				<?php } ?>
			</div>
            <!-- <div style="height: 30px; width: 100%; margin: 5px 0; line-height: 30px;">
                <div style="float: left; display: inline-block; height: 30px; line-height: 30px;">
                    <?php echo menu_linkage(3381,'pro_type',$pro_type,1);?>
                </div>
                <span style="line-height: 30px;">项目状态</span>
                <select class="checkStatus">
                    <option value="-1">全部</option>
                    <option  value="1">审核中</option>
                    <option value="99">审核通过</option>
                    <option value="0">审核未通过</option>
                </select>

                <input type="button" value="查找" id="searchbtn">

            </div>
             -->
			<div class="table-widget table-list">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<thead>
						<tr>
							<th class="w50">序号</th>
							<th class="w250">项目名称</th>
							<th class="w150">项目进度</th>
							<th class="w150">项目状态</th>
							<th class="w150">申报时间</th>
							<th class="w150">操&nbsp;&nbsp;&nbsp;&nbsp;作</th>
						
						</tr>
					</thead>
					

				 	<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					<tr>
						<td align="center" class="pdl10">
							<?php echo $index;?>
						</td>
						<td align="left" class="pdl10">
							<a
						href="index.php?m=member&c=content&a=edit&catid=9&isShow=1&id=<?php echo $info['id'];?>&curmb=view&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"
						title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 60);?></a>
					</td>
						<td>
							<a href="javascript:add_progress(<?php echo $info['id'];?>,'添加项目进度','<?php echo date('Y-m',$info['inputtime']);?>','<?php echo $info['title'];?>');">添加</a>
						</td> 
						<td>
							<?php echo L('project'.$info[status],'','mydiy');?>
							
							<?php if($info[status]=='-2') { ?>
								<a href="javascript:submit(<?php echo $info['id'];?>);">提交</a>
							<?php } ?>
						</td>
						<td align="center"><?php echo date('Y-m-d H:m:s',$info['inputtime']);?></td>
						<td align="center">
									<a title="编辑" href="index.php?m=member&c=content&a=edit&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"><font class="edit-bt" color="red">&nbsp;&nbsp;</font></a>
								<?php if($info[status]!='99') { ?>
									<a title="删除" href="javascript:;" onclick="myform.action='index.php?m=member&c=content&a=delete&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>';return confirm_delete();"><font class="del-bt">&nbsp;&nbsp;</font></a>
								<?php } ?>
								
						</td>
					</tr>
					<?php $n++;}unset($n); ?>
				</table>
 				<div id="pages"> <?php echo $pages;?></div>
			</div>
			<?php if(isProgress) { ?>
				</div>
			<?php } ?>
		</div>
	</div>


