<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<link href="http://article.hnxclm.com/statics/css/dialog.css" rel="stylesheet" type="text/css">
<style media=print type="text/css">   
.noprint{visibility:hidden}   
</style>  

<div class="pad-lr-10">
    <form name="myform" action="?m=formguide&c=formguide&a=listorder" method="post">
        <div class="table-list">
            <table width="90%" cellspacing="0" align="center">
                <thead>
               		<tr class ="noprint" onclick="myprint()"><td colspan="2" align="center" class="aui_footer">
               			<div class="aui_buttons" style="text-align: center;"><button class=" aui_state_highlight" type="button">打印</button></div></td>
               		</tr>
                	<tr>
                     <th width="20" align="left">
                   		 序号
	                  </th>
	                  <th width="35" align="center">
                   		 <?php echo $fields[$field]['name']?>
	                  </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(is_array($datas)){
                	$index=0;
                    foreach($datas as $form){
                    	$index++;
                        ?>
                    <tr>
                         <td align="left"><?php echo $index ?></td>
                         <td align="left"><?php echo $form[$field] ?></td>
                    </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            
        <div id="pages"><?php echo $this->db->pages;?></div>
    </form>
</div>
</body>
</html>
<script type="text/javascript">

	function myprint(){
		window.print();
	}

	
    function edit(id, title) {
        window.top.art.dialog({id:'edit'}).close();
        window.top.art.dialog({title:'<?php echo L('edit_formguide')?>--'+title, id:'edit', iframe:'?m=formguide&c=formguide&a=edit&formid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
            var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
    }
    function stat(id, title) {
        window.top.art.dialog({id:'stat'}).close();
        window.top.art.dialog({title:'<?php echo L('stat_formguide')?>--'+title, id:'stat', iframe:'?m=formguide&c=formguide&a=stat&formid='+id ,width:'700px',height:'500px'}, function(){window.top.art.dialog({id:'edit'}).close()});
    }
</script>