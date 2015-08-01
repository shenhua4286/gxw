<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<!--  -->
<style>
/*隐藏标题*/
    .title{
        display: none;
    }
</style>
    <div class="x-content">
        <div class="" style="width:1190px;">
       <?php if(!isset($_GET['t'])) { ?> 
        <!--通知侧边栏开始  -->
        <div class="left-tongzhi">
             <div class="laba-tongzhi">
                <img src="<?php echo CSS_PATH;?>gxw2/img/dalaba.png" alt="">
                <div class="tongzhi-title">
                  <?php echo $CATEGORYS[$catid]['catname'];?>
                </div>
                <div class="tongzhi-title-en">
                    notice
                </div>
            </div>
            <?php $index=0?>
                <?php $n=1;if(is_array(subcat($catid))) foreach(subcat($catid) AS $v) { ?>
                     <a href="<?php echo $v['url'];?>" class="tongzhi-li  <?php if($catid==$v['catid']) { ?>on<?php } ?>">
                         <?php echo $v['catname'];?>
                    </a>
                    <?php $index++;?>
                <?php $n++;}unset($n); ?>
        </div>
		<?php } ?>
        <!--通知侧边栏end  -->
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=02d5d90bb748274ba7a92c206ca7793d&action=lists&catid=%24catid&num=10&order=id&moreinfo=%271%27+DESC&page=%24page\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 10;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'id','moreinfo'=>'\'1\' DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'id','moreinfo'=>'\'1\' DESC','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
                
            <div class="table-widget table-list tz-widget">
                <!-- 通知列表头部的面包屑和搜索  开始 -->
                    <div class="tz-mianbaoxie relative">
                        <div class="blue-block"></div>
                       <a onclick="parent.menu(4);">首页</a>
                       >
                        <a href="index.php?m=content&c=index&a=lists&catid=<?php echo $catid;?>"> <?php echo $CATEGORYS[$catid]['catname'];?></a>
                    </div>
                    <div class="tz-search">
                        <img class="tz-search-bt" src="<?php echo CSS_PATH;?>gxw2/img/tz-search.png">
                        <p>本栏目信息检索关键词</p>
                        <div class="tz-search-box">
                            <input type="text" class="tz-search-input">
                            <input type="button" class="tz-search-sub" value="搜索">
                        </div>
                        
                    </div>
                    <!-- 通知列表头部的面包屑和搜索  end -->
                    <div class="tz-list">
                    <?php $index=0;?>
                    <?php $n=1;if(is_array($data)) foreach($data AS $info) { ?>

                        <?php $CAT = $CATEGORYS[$info[catid]];?>
                    <?php $index++;?>
                        <li>
                        <i class="li-disc"></i>  <!-- 小点 -->
                            <a href="<?php echo $info['url'];?>"><span>【<?php echo $CAT['catname'];?>】</span><?php echo str_cut($info['title'], 180);?></a>
                            <p>来源:<?php echo $info['copyfrom'];?><b><?php echo date('Y-m-d',$info['inputtime']);?></b></p>
                        </li>
                    <?php $n++;}unset($n); ?>
                    </div>
                    <div id="pages" class="tz-pages"> <?php echo $pages;?></div>


                
<!--                <table  cellspacing="0" cellpadding="0" class="textc">
                    <thead>
                        <tr>
                            <th class="w50">序号</th>
                            <th class="w300">信息名称</th>
                            <th class="w150">发布时间</th>
                        </tr>

                    </thead>
                
                    <?php $index=0;?>
                    <?php $n=1;if(is_array($data)) foreach($data AS $info) { ?>
                    <?php $index++;?>
                    <tr>
                        <td align="left" class="pdl10">
                            <?php echo $index;?>
                        </td>
                        <td align="left" class="pdl10">
                            <a href="<?php echo $info['url'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"  title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 100);?></a>
                        </td>
                        <td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
                    </tr>
                    <?php $n++;}unset($n); ?>
                    
                </table>
                <div id="pages"> <?php echo $pages;?></div> -->
            </div>
        </div>
        </div>
    </div>


