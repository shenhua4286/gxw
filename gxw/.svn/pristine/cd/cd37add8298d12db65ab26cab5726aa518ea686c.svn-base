<?php
/**
 * 企业前台录入操作类
 */
defined ( 'IN_gxw' ) or exit ( 'No permission resources.' );
pc_base::load_app_class ( 'foreground' );
pc_base::load_sys_class ( 'format', '', 0 );
pc_base::load_sys_class ( 'form', '', 0 );
pc_base::load_app_func ( 'global', 'member' );

/**
 *
 * @author toto
 *        
 */
class content extends foreground {
	private $times_db;
	function __construct() {
		parent::__construct ();
	}
	
	
	public function publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache ( 'grouplist' );
		$priv_db = pc_base::load_model ( 'category_priv_model' ); // 加载栏目权限表数据模型
		                                                       
		// 判断企业组是否允许录入
		if (! $grouplist [$memberinfo ['groupid']] ['allowpost']) {
			showmessage ( L ( 'member_group' ) . L ( 'publish_deny' ), HTTP_REFERER );
		}
		// 判断每日录入数
		$this->content_check_db = pc_base::load_model ( 'content_check_model' );
		$todaytime = strtotime ( date ( 'y-m-d', SYS_TIME ) );
		$_username = $this->memberinfo ['username'];
		$allowpostnum = $this->content_check_db->count ( "`inputtime` > $todaytime AND `username`='$_username'" );
		if ($grouplist [$memberinfo ['groupid']] ['allowpostnum'] > 0 && $allowpostnum >= $grouplist [$memberinfo ['groupid']] ['allowpostnum']) {
			showmessage ( L ( 'allowpostnum_deny' ) . $grouplist [$memberinfo ['groupid']] ['allowpostnum'], HTTP_REFERER );
		}
		$siteids = getcache ( 'category_content', 'commons' );
		header ( "Cache-control: private" );
		if (isset ( $_POST ['dosubmit'] )) {
			
			$catid = intval ( $_POST ['info'] ['catid'] );
			// 判断此类型用户是否有权限在此栏目下提交录入
			if (! $priv_db->get_one ( array (
					'catid' => $catid,
					'roleid' => $memberinfo ['groupid'],
					'is_admin' => 0,
					'action' => 'add' 
			) ))
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
			
			$siteid = $siteids [$catid];
			//echo $catid;die;
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			$category = $CATEGORYS [$catid];
			$modelid = $category ['modelid'];
			//echo $modelid;die;
			if (! $modelid)
				showmessage ( L ( 'illegal_parameters' ), HTTP_REFERER );
			$this->content_db = pc_base::load_model ( 'content_model' );
			$this->content_db->set_model ( $modelid );
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields ();
			//var_dump($fields_sys);die;
			$this->content_db->table_name = $table_name . '_data';
			
			$fields_attr = $this->content_db->get_fields ();
			$fields = array_merge ( $fields_sys, $fields_attr );
			$fields = array_keys ( $fields );
			$info = array ();
			foreach ( $_POST ['info'] as $_k => $_v ) {
				if ($_k == 'content') {
					$info [$_k] = remove_xss ( strip_tags ( $_v, '<p><a><br><img><ul><li><div>' ) );
				} elseif (in_array ( $_k, $fields )) {
					$info [$_k] = new_html_special_chars ( trim_script ( $_v ) );
				}
			}
			$_POST ['linkurl'] = str_replace ( array (
					'"',
					'(',
					')',
					",",
					' ',
					'%' 
			), '', new_html_special_chars ( strip_tags ( $_POST ['linkurl'] ) ) );
			$post_fields = array_keys ( $_POST ['info'] );
			$post_fields = array_intersect_assoc ( $fields, $post_fields );
			$setting = string2array ( $category ['setting'] );
			if ($setting ['presentpoint'] < 0 && $memberinfo ['point'] < abs ( $setting ['presentpoint'] ))
				showmessage ( L ( 'points_less_than', array (
						'point' => $memberinfo ['point'],
						'need_point' => abs ( $setting ['presentpoint'] ) 
				) ), APP_PATH . 'index.php?m=pay&c=deposit&a=pay&exchange=point', 3000 );
				
				// 判断企业组录入是否需要审核
			if ($grouplist [$memberinfo ['groupid']] ['allowpostverify'] || ! $setting ['workflowid']) {
				$info ['status'] = 99;
			} else {
				$info ['status'] = $catid==9 ? -2:1;
			}
			$info ['username'] = $memberinfo ['username'];
			
			if (isset ( $info ['title'] ))
				$info ['title'] = safe_replace ( $info ['title'] );
			$this->content_db->siteid = $siteid;
			
			$id = $this->content_db->add_content ( $info );
			// 检查录入奖励或扣除积分
			if ($info ['status'] == 99) {
				$flag = $catid . '_' . $id;
				if ($setting ['presentpoint'] > 0) {
					pc_base::load_app_class ( 'receipts', 'pay', 0 );
					receipts::point ( $setting ['presentpoint'], $memberinfo ['userid'], $memberinfo ['username'], $flag, 'selfincome', L ( 'contribute_add_point' ), $memberinfo ['username'] );
				} else {
					pc_base::load_app_class ( 'spend', 'pay', 0 );
					spend::point ( $setting ['presentpoint'], L ( 'contribute_del_point' ), $memberinfo ['userid'], $memberinfo ['username'], '', '', $flag );
				}
			}
			// 缓存结果
			/*
			$model_cache = getcache ( 'model', 'commons' );
			
			$infos = array ();
			foreach ( $model_cache as $modelid => $model ) {
				if ($model ['siteid'] == $siteid) {
					$datas = array ();
					$this->content_db->set_model ( $modelid );
					$datas = $this->content_db->select ( array (
							'username' => $memberinfo ['username'],
							'sysadd' => 0 
					), 'id,catid,title,url,username,sysadd,inputtime,status', 100, 'id DESC' );
					if ($datas)
						$infos = array_merge ( $infos, $datas );
				}
			} 
			setcache ( 'member_' . $memberinfo ['userid'] . '_' . $siteid, $infos, 'content' );
			
			if ($catid == 13) {
				showmessage ( L ( 'contributors_success' ), HTTP_REFERER );
			}
			*/
			// 缓存结果 END
			//index.php?&menu=1&m=member&c=content&a=published&catid=9&t=35&pt=41
			$menu=$_POST['menu'];
			$t=$_POST['t'];
			$pt=$_POST['pt'];
			if(isset($t)){
				$url="index.php?m=member&c=content&a=published&catid={$catid}&t={$t}&pt={$pt}&menu={$menu}";
			}else{
				$url=HTTP_REFERER;			
			}
			//$http_referer=$_POST['http_referer'];
			//$listUrl=APP_PATH . 'index.php?m=member&c=content&a=published&catid=' . $catid ;
			//返回至上一个页面
			//$url=isset($http_referer) && !isset($menuu) ? $http_referer: $listUrl;
			//是否从左侧菜单进入
			//$url=isset($menu) ? HTTP_REFERER:$url;
			
			if ($info ['status'] == 99) {
				showmessage ( L ( 'contributors_success' ),$url);
			} else {
				if($catid==9){
					showmessage ( '保存成功，请记得提交项目', $url);
				}else{
					showmessage ( L ( 'contributors_checked' ), $url);
				}
			}
		} else {
			
			
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L ( 'news', '', 'content' );
			$sitelist = getcache ( 'sitelist', 'commons' );
			if (! isset ( $_GET ['siteid'] ) && count ( $sitelist ) > 1) {
				include template ( 'member', 'content_publish_select_model' );
				exit ();
			}
			// 设置cookie 在附件添加处调用
			param::set_cookie ( 'module', 'content' );
			$siteid = intval ( $_GET ['siteid'] );
			if (! $siteid)
				$siteid = 1;
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			foreach ( $CATEGORYS as $catid => $cat ) {
				if ($cat ['siteid'] == $siteid && $cat ['child'] == 0 && $cat ['type'] == 0 && $priv_db->get_one ( array (
						'catid' => $catid,
						'roleid' => $memberinfo ['groupid'],
						'is_admin' => 0,
						'action' => 'add' 
				) ))
					break;
			}
			$catid = $_GET ['catid'] ? intval ( $_GET ['catid'] ) : $catid;
			if (! $catid)
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
				
				// 判断本栏目是否允许录入
			if (! $priv_db->get_one ( array (
					'catid' => $catid,
					'roleid' => $memberinfo ['groupid'],
					'is_admin' => 0,
					'action' => 'add' 
			) ))
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
			$category = $CATEGORYS [$catid];
			if ($category ['siteid'] != $siteid)
				showmessage ( L ( 'site_no_category' ), '?m=member&c=content&a=publish' );
			$setting = string2array ( $category ['setting'] );
			
			if ($setting ['presentpoint'] < 0 && $memberinfo ['point'] < abs ( $setting ['presentpoint'] ))
				showmessage ( L ( 'points_less_than', array (
						'point' => $memberinfo ['point'],
						'need_point' => abs ( $setting ['presentpoint'] ) 
				) ), APP_PATH . 'index.php?m=pay&c=deposit&a=pay&exchange=point', 3000 );
			if ($category ['type'] != 0)
				showmessage ( L ( 'illegal_operation' ) );
			$modelid = $category ['modelid'];
			$model_arr = getcache ( 'model', 'commons' );
			$MODEL = $model_arr [$modelid];
			unset ( $model_arr );
			
			require CACHE_MODEL_PATH . 'content_form.class.php';
			$content_form = new content_form ( $modelid, $catid, $CATEGORYS );
			$forminfos_data = $content_form->get ();
			$forminfos = array ();
			foreach ( $forminfos_data as $_fk => $_fv ) {
				if ($_fv ['isomnipotent'])
					continue;
				if ($_fv ['formtype'] == 'omnipotent') {
					foreach ( $forminfos_data as $_fm => $_fm_value ) {
						if ($_fm_value ['isomnipotent']) {
							$_fv ['form'] = str_replace ( '{' . $_fm . '}', $_fm_value ['form'], $_fv ['form'] );
						}
					}
				}
				$forminfos [$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			// 去掉栏目id
			unset ( $forminfos ['catid'] );
			$workflowid = $setting ['workflowid'];
			header ( "Cache-control: private" );
			$template = $MODEL ['member_add_template'] ? $MODEL ['member_add_template'] : 'content_publish';
			$lists = array ();
			/**
			 * 添加项目进度*
			 */
			if ($catid == '13') {
				
				$pagesize = 5;
				$page = max ( intval ( $_GET ['page'] ), 1 );
				$this->content_db = pc_base::load_model ( 'content_model' );
				
				
				$where = "username = '{$_username}'  and catid= {$catid}" ;
				
				if (isset($_GET['projectId'])){
					
					$where.=" and projectId= {$_GET['projectId']}";
				}
				
				$sql1 = "select * from gxw_project_progress WHERE " . $where;
				$infos = $this->content_db->mylistinfo ( $sql1, 'yearMonth desc', $page );
				
				
				$progress_date=new progress_date();
				$proDate=$progress_date->proDate;
				$startDate=$progress_date->startDate;
				$dates=$progress_date->dates;
				$monthCount=$progress_date->monthCount;
				$month=$progress_date->month;
				
				
				foreach ( $infos as $info ) {
					$yearMonth = $info ['yearMonth'];
					$lists [$yearMonth] = $info;
				}
			}
		
			if (isset($_GET['ajax'])){
					include template ('member', 'projectProgres_form' );
			}else{
				include template ( 'member', $template );
			}
			
		}
	}
	
	
	/***内容查看页**/
	public function show() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache ( 'grouplist' );
		$priv_db = pc_base::load_model ( 'category_priv_model' ); // 加载栏目权限表数据模型
		 
		$show_header = $show_dialog = $show_validator = '';
		$temp_language = L ( 'news', '', 'content' );
		$sitelist = getcache ( 'sitelist', 'commons' );
		if (! isset ( $_GET ['siteid'] ) && count ( $sitelist ) > 1) {
			include template ( 'member', 'content_publish_select_model' );
			exit ();
		}
			// 设置cookie 在附件添加处调用
			param::set_cookie ( 'module', 'content' );
			$siteid = intval ( $_GET ['siteid'] );
			if (! $siteid)
				$siteid = 1;
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			foreach ( $CATEGORYS as $catid => $cat ) {
				if ($cat ['siteid'] == $siteid && $cat ['child'] == 0 && $cat ['type'] == 0 && $priv_db->get_one ( array (
						'catid' => $catid,
						'roleid' => $memberinfo ['groupid'],
						'is_admin' => 0,
						'action' => 'add'
				) ))
					break;
			}
			$catid = $_GET ['catid'] ? intval ( $_GET ['catid'] ) : $catid;
			if (! $catid)
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
				$category = $CATEGORYS [$catid];
				$modelid = $category ['modelid'];
				$model_arr = getcache ( 'model', 'commons' );
				$MODEL = $model_arr [$modelid];
				unset ( $model_arr );
					
				require CACHE_MODEL_PATH . 'content_form.class.php';
				$content_form = new content_form ( $modelid, $catid, $CATEGORYS );
				$forminfos_data = $content_form->get ();
				$forminfos = array ();
				foreach ( $forminfos_data as $_fk => $_fv ) {
					if ($_fv ['isomnipotent'])
						continue;
					if ($_fv ['formtype'] == 'omnipotent') {
						foreach ( $forminfos_data as $_fm => $_fm_value ) {
							if ($_fm_value ['isomnipotent']) {
								$_fv ['form'] = str_replace ( '{' . $_fm . '}', $_fm_value ['form'], $_fv ['form'] );
							}
						}
					}
					$forminfos [$_fk] = $_fv;
				}
				//$formValidator = $content_form->formValidator;
				// 去掉栏目id
				unset ( $forminfos ['catid'] );
				$workflowid = $setting ['workflowid'];
				header ( "Cache-control: private" );
				$template = $MODEL ['member_add_template'] ? $MODEL ['member_add_template'] : 'content_publish';
				$lists = array ();
				/**
				 * 添加项目进度*
				*/
				if ($catid == '13') {
	
					$pagesize = 5;
					$page = max ( intval ( $_GET ['page'] ), 1 );
					$this->content_db = pc_base::load_model ( 'content_model' );
	
	
					$where = "username = '{$_username}'  and catid= {$catid}" ;
	
					if (isset($_GET['projectId'])){
							
						$where.=" and projectId= {$_GET['projectId']}";
					}
	
					$sql1 = "select * from gxw_project_progress WHERE " . $where;
					$infos = $this->content_db->mylistinfo ( $sql1, 'yearMonth desc', $page );
	
	
					$progress_date=new progress_date();
					$proDate=$progress_date->proDate;
					$startDate=$progress_date->startDate;
					$dates=$progress_date->dates;
					$monthCount=$progress_date->monthCount;
					$month=$progress_date->month;
	
	
					foreach ( $infos as $info ) {
						$yearMonth = $info ['yearMonth'];
						$lists [$yearMonth] = $info;
					}
				}
				
				if (isset($_GET['ajax'])){
					include template ('member', 'projectProgres_form' );
				}else{
					include template ( 'member', $template );
				}
		}
	
	
	
	public function ajax_publish(){
		Global $page,$proDate,$lists;
		$_username = $this->memberinfo ['username'];
		$catid = $_GET ['catid'] ? intval ( $_GET ['catid'] ) : $catid;
		//TODO
		
		echo '33';
		//include template ( 'member', 'projectProgres_form' );
	}
	
	
	
	
	public function published() {
		$memberinfo = $this->memberinfo;
		$groupid=$memberinfo['groupid'];
		$sitelist = getcache ( 'sitelist', 'commons' );
		if (! isset ( $_GET ['siteid'] ) && count ( $sitelist ) > 1) {
			include template ( 'member', 'content_publish_select_model' );
			exit ();
		}
		
		$_username = $this->memberinfo ['username'];
		$_userid = $this->memberinfo ['userid'];
		$catid = intval ( $_GET ['catid'] );
		$siteid = intval ( $_GET ['siteid'] );
		$pro_type = $_GET ['pro_type'];
		$checkStatus = $_GET ['checkStatus'];
		
		if (! $siteid)
			$siteid = 1;
		$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
		$siteurl = siteurl ( $siteid );
		$pagesize = 20;
		$page = max ( intval ( $_GET ['page'] ), 1 );
		$workflows = getcache ( 'workflow_' . $siteid, 'commons' );
		$this->content_check_db = pc_base::load_model ( 'content_check_model' );
		// $info['L_3381']=3434;
		$this->content_db = pc_base::load_model ( 'content_model' );
		$steps=$_GET['steps'];//是否是审核
		$type=$_GET['type'];//是否是审核

		if(empty($memberinfo['area'])){
			$memberinfo['area']=0;
		}
		/**
		 * 企业项目*
		 */
		if ($catid == 9) {
			$where.="p.catid= {$catid} ";
			/**获取用户的区域，若用户没有区域即为gxw账户***/
			$area = $memberinfo ['area'] ? $memberinfo ['area'] :$_POST['info']['area'];
			
			
			//if ($memberinfo ['groupid'] < 15) {//gxw帐号，不需要区域查询
				if($area){
					$where .= "and  m.area = '$area'";
				}
			//}
			$title=isset($_POST['title']) ? $_POST['title']:'';
			if($title){
				$where .= "and  p.title like '%$title%'";
			}
			$steps=is_numeric($_REQUEST['steps']) ? $_REQUEST['steps']:1;
			
			if($groupid >12){//企业以上用户
					$where .= " and p.status =".$steps;
			}else{
				$where .= " and p.username = '{$_username}'";
			}
			
			$sql1 = "select p.*,l.`name`,m.nickname complayName,(select pg.title From gxw_project_progress pg where pg.projectId=p.id order by pg.id desc LIMIT 0,1) progressName from  gxw_project p  ".
					"LEFT JOIN gxw_linkage l ON p.pro_type=l.linkageid ".
					"LEFT JOIN gxw_member m ON m.username=p.username ".
					"WHERE " . $where;
			//echo $sql1;
			$datas = $this->content_db->mylistinfo ( $sql1, 'p.id desc', $page );
			$pages = $this->content_db->pages;
		} 	
		// 企业产品
		else if ($catid == 10) {
			
			$where.="p.catid= {$catid} ";
			
		if ($memberinfo ['groupid'] < 15) {//gxw帐号，不需要区域查询
				if(!empty($area)){
					$where .= "and  m.area = '$area'";
				}
			}

			$title=isset($_POST['title']) ? $_POST['title']:'';
			if($title){
				$where .= "and  p.title like '%$title%'";
			}
			
			$steps=is_numeric($_REQUEST['steps']) ? $_REQUEST['steps']:1;
			
			if($groupid >12){//企业以上用户
					$where .= " and p.status =".$steps;
			}else{
				$where .= " and p.username = '{$_username}'";
			}
			
			
			$sql1 = "select a.*,p.*,m.nickname complayName from gxw_products_data a ".
					"LEFT JOIN  gxw_products p on p.id=a.id  ".
					"LEFT JOIN  gxw_member m ON m.username=p.username ".
					"WHERE " . $where;
			//echo $sql1;die;
			$datas = $this->content_db->mylistinfo ( $sql1, 'a.id desc', $page );
			$pages = $this->content_db->pages;
		} 		// 系统消息
		else if ($catid == 12) {
			$where = " catid= {$catid} ";
			$sql1 = "select * from gxw_notice_data a LEFT JOIN  gxw_notice b on b.id=a.id  WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'a.id desc', $page );
			$pages = $this->content_db->pages;
		} 		// 系统消息
		else if ($catid == 13) {
			$where = " pr.catid= {$catid} ";
			$sql1 = "select pr.*,p.title projectTitle From gxw_project_progress pr left join gxw_project p on pr.projectId=p.id   WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'pr.id desc', $page );
			$pages = $this->content_db->pages;
		} 		// 系统消息
		else if ($catid == 14) {
			$where = " pr.catid= {$catid} and username = '{$_username}'";
			$sql1 = "select * From gxw_month_products pr  WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'pr.id desc', $page );
			$pages = $this->content_db->pages;
		} 		// 系统消息
		else if ($catid == 16) {	
			$where = " pr.catid= {$catid} and username = '{$_username}'";
			$sql1 = "select * From gxw_month_dashi pr  WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'pr.id desc', $page );
			$pages = $this->content_db->pages;						
		} else if($catid==19){ 
			$where = " pr.catid= {$catid} and username = '{$_username}'";
			$sql1 = "select * From gxw_info_application pr  WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'pr.id desc', $page );
			$pages = $this->content_db->pages;		
		}else if($catid==20){ 
			$where = " n.catid= {$catid}";
			$sql1 = "select * From gxw_news n left join gxw_news_data d on n.id=d.id WHERE " . $where;
			$datas = $this->content_db->mylistinfo ( $sql1, 'n.id desc', $page );
			$pages = $this->content_db->pages;		
		}else if($catid==29){
			$sql1="select r.*,d.data from gxw_shop_recommend r left join gxw_shop_recommend_data d on r.id=d.id";
			$datas = $this->content_db->mylistinfo ( $sql1, 'r.id desc', $page );
			$pages = $this->content_db->pages;
			
		}else{
			$infos = $this->content_check_db->listinfo ( array (
					'username' => $_username,
					'siteid' => $siteid,
					'catid' => $catid 
			), 'inputtime DESC', $page );
			foreach ( $infos as $_v ) {
				$arr_checkid = explode ( '-', $_v ['checkid'] );
				$_v ['id'] = $arr_checkid [1];
				$_v ['modelid'] = $arr_checkid [2];
				$_v ['url'] = $_v ['status'] == 99 ? go ( $_v ['catid'], $_v ['id'] ) : APP_PATH . 'index.php?m=content&c=index&a=show&catid=' . $_v ['catid'] . '&id=' . $_v ['id'];
				if (! isset ( $setting [$_v ['catid']] ))
					$setting [$_v ['catid']] = string2array ( $CATEGORYS [$_v ['catid']] ['setting'] );
				$workflowid = $setting [$_v ['catid']] ['workflowid'];
				$_v ['flag'] = $workflows [$workflowid] ['flag'];
				$datas [] = $_v;
			}
			$pages = $this->content_check_db->pages;
		}
		
		if(isset($type)){
			include template ( 'member', 'content_published_'.$type );
		}else{
			include template ( 'member', 'content_published' );
		}
	}	
	/**
	 * 编辑内容
	 */
	public function edit() {
		$_username = $this->memberinfo ['username'];
		$memberinfo = $this->memberinfo;
		if (isset ( $_POST ['dosubmit'] )) {
			$catid = $_POST ['info'] ['catid'] = intval ( $_POST ['info'] ['catid'] );
			$siteids = getcache ( 'category_content', 'commons' );
			$siteid = $siteids [$catid];
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			$category = $CATEGORYS [$catid];
			if ($category ['type'] == 0) {
				$id = intval ( $_POST ['id'] );
				$catid = $_POST ['info'] ['catid'] = intval ( $_POST ['info'] ['catid'] );
				$this->content_db = pc_base::load_model ( 'content_model' );
				$modelid = $category ['modelid'];
				$this->content_db->set_model ( $modelid );
				// 判断企业组录入是否需要审核
				$memberinfo = $this->memberinfo;
				$grouplist = getcache ( 'grouplist' );
				$setting = string2array ( $category ['setting'] );
				if (! $grouplist [$memberinfo ['groupid']] ['allowpostverify'] || $setting ['workflowid']) {
					$_POST ['info'] ['status'] = - 2;
				}
				$info = array ();
				foreach ( $_POST ['info'] as $_k => $_v ) {
					if ($_k == 'content') {
						$_POST ['info'] [$_k] = strip_tags ( $_v, '<p><a><br><img><ul><li><div>' );
					} elseif (in_array ( $_k, $fields )) {
						$_POST ['info'] [$_k] = new_html_special_chars ( trim_script ( $_v ) );
					}
				}
				$_POST ['linkurl'] = str_replace ( array (
						'"',
						'(',
						')',
						",",
						' ',
						'%' 
				), '', new_html_special_chars ( strip_tags ( $_POST ['linkurl'] ) ) );
				
				$this->content_db->edit_content ( $_POST ['info'], $id );
				$forward = $_POST ['forward'];
				showmessage ( L ( 'update_success' ), $forward );
			}
		} else {
			$steps=$_GET['steps'];
			if(!$steps){
				$steps=1;
			}
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L ( 'news', '', 'content' );
			// 设置cookie 在附件添加处调用
			param::set_cookie ( 'module', 'content' );
			$id = intval ( $_GET ['id'] );
			if (isset ( $_GET ['catid'] ) && $_GET ['catid']) {
				$catid = $_GET ['catid'] = intval ( $_GET ['catid'] );
				param::set_cookie ( 'catid', $catid );
				$siteids = getcache ( 'category_content', 'commons' );
				$siteid = $siteids [$catid];
				$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
				$category = $CATEGORYS [$catid];
				if ($category ['type'] == 0) {
					$modelid = $category ['modelid'];
					$this->model = getcache ( 'model', 'commons' );
					$this->content_db = pc_base::load_model ( 'content_model' );
					$this->content_db->set_model ( $modelid );
					
					$this->content_db->table_name = $this->content_db->db_tablepre . $this->model [$modelid] ['tablename'];
					
					
					
					if($memberinfo['groupid'] > 12){ //企业以上用户
						$whereArray= array (
								'id' => $id,
								'sysadd' => 0
						);
					}else{
						$whereArray= array (
								'id' => $id,
								'username' => $_username,
								'sysadd' => 0
						);
					}
					$r = $this->content_db->get_one ($whereArray);
					
					if (! $r)
						showmessage ( L ( 'illegal_operation' ) );
						/* if($r['status']==99) showmessage(L('has_been_verified')); */
					$this->content_db->table_name = $this->content_db->table_name . '_data';
					$r2 = $this->content_db->get_one ( array (
							'id' => $id 
					) );
					$data = array_merge ( $r, $r2 );
					require CACHE_MODEL_PATH . 'content_form.class.php';
					$content_form = new content_form ( $modelid, $catid, $CATEGORYS );
					
					$forminfos_data = $content_form->get ( $data );
					$forminfos = array ();
					foreach ( $forminfos_data as $_fk => $_fv ) {
						if ($_fv ['isomnipotent'])
							continue;
						if ($_fv ['formtype'] == 'omnipotent') {
							foreach ( $forminfos_data as $_fm => $_fm_value ) {
								if ($_fm_value ['isomnipotent']) {
									$_fv ['form'] = str_replace ( '{' . $_fm . '}', $_fm_value ['form'], $_fv ['form'] );
								}
							}
						}
						$forminfos [$_fk] = $_fv;
					}
					
					$template='content_publish';
					/***内容查看页面**/
					if(isset($_GET['isShow'])) $template.='_show';
					//echo $template;die;
					$formValidator = $content_form->formValidator;
					$type=$_GET['type'];
					if(isset($type)){
						include template ( 'member', 'content_publish_'.$type );
					}else{
						include template ( 'member', $template );
					}
				}
			}
			header ( "Cache-control: private" );
		}
	}
	/**
	 * **
	 *
	 * 项目提交
	 */
	public function submit() {
		$data = array (
				"success" => false,
				'msg' => '' 
		);
		$id = $_GET ['id'];
		if (! isset ( $id )) {
			$data ['msg'] = '数据ID错误';
			jsonExit ( $data );
		}
		
		$groupid = $this->memberinfo ['groupid'];
		if ($groupid < 12) {
			$data ['msg'] = '请等待资料审核通过';
			jsonExit ( $data );
		}
		
		$this->content_db = pc_base::load_model ( 'content_model' );
		$sql = "update gxw_project set status=1 where id=" . $id;
		$this->content_db->query ( $sql );
		
		$data ['success'] = true;
		jsonExit ( $data );
	}
	public function tuijian(){
		
	}
	//认证企业浏览
	public function scan(){
		
	}
	/**
	 * 企业删除录入 ...
	 */
	public function delete() {
		$id = intval ( $_GET ['id'] );
		if (! $id) {
			return false;
		}
		// 判断该文章是否待审，并且属于该企业
		$username = param::get_cookie ( '_username' );
		$userid = param::get_cookie ( '_userid' );
		$siteid = get_siteid ();
		$catid = intval ( $_GET ['catid'] );
		$siteids = getcache ( 'category_content', 'commons' );
		$siteid = $siteids [$catid];
		$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
		$category = $CATEGORYS [$catid];
		if (! $category) {
			showmessage ( L ( 'operation_failure' ), HTTP_REFERER );
		}
		$modelid = $category ['modelid'];
		$checkid = 'c-' . $id . '-' . $modelid;
		$where = " checkid='$checkid' and username='$username' and status!=99 ";
		$check_pushed_db = pc_base::load_model ( 'content_check_model' );
		$array = $check_pushed_db->get_one ( $where );
		/*
		 * if(!$array){
		 * showmessage(L('operation_failure'), HTTP_REFERER);
		 * }else{
		 */
		$content_db = pc_base::load_model ( 'content_model' );
		$content_db->set_model ( $modelid );
		$table_name = $content_db->table_name;
		$content_db->delete_content ( $id ); // 删除文章
		$check_pushed_db->delete ( array (
				'checkid' => $checkid 
		) ); // 删除对应录入表
		showmessage ( L ( 'operation_success' ), HTTP_REFERER );
		// }
	}
	public function info_publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache ( 'grouplist' );
		$SEO ['title'] = L ( 'info_publish', '', 'info' );
		// 判断企业组是否允许录入
		if (! $grouplist [$memberinfo ['groupid']] ['allowpost']) {
			showmessage ( L ( 'member_group' ) . L ( 'publish_deny' ), HTTP_REFERER );
		}
		
		// 判断每日录入数
		$this->content_check_db = pc_base::load_model ( 'content_check_model' );
		$todaytime = strtotime ( date ( 'y-m-d', SYS_TIME ) );
		$_username = $memberinfo ['username'];
		$allowpostnum = $this->content_check_db->count ( "`inputtime` > $todaytime AND `username`='$_username'" );
		if ($grouplist [$memberinfo ['groupid']] ['allowpostnum'] > 0 && $allowpostnum >= $grouplist [$memberinfo ['groupid']] ['allowpostnum']) {
			showmessage ( L ( 'allowpostnum_deny' ) . $grouplist [$memberinfo ['groupid']] ['allowpostnum'], HTTP_REFERER );
		}
		
		$siteids = getcache ( 'category_content', 'commons' );
		header ( "Cache-control: private" );
		if (isset ( $_POST ['dosubmit'] )) {
			$catid = intval ( $_POST ['info'] ['catid'] );
			$siteid = $siteids [$catid];
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			$category = $CATEGORYS [$catid];
			$modelid = $category ['modelid'];
			if (! $modelid)
				showmessage ( L ( 'illegal_parameters' ), HTTP_REFERER );
			$this->content_db = pc_base::load_model ( 'content_model' );
			$this->content_db->set_model ( $modelid );
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields ();
			$this->content_db->table_name = $table_name . '_data';
			
			$fields_attr = $this->content_db->get_fields ();
			$fields = array_merge ( $fields_sys, $fields_attr );
			$fields = array_keys ( $fields );
			$info = array ();
			foreach ( $_POST ['info'] as $_k => $_v ) {
				if (in_array ( $_k, $fields ))
					$info [$_k] = $_v;
			}
			$post_fields = array_keys ( $_POST ['info'] );
			$post_fields = array_intersect_assoc ( $fields, $post_fields );
			$setting = string2array ( $category ['setting'] );
			if ($setting ['presentpoint'] < 0 && $memberinfo ['point'] < abs ( $setting ['presentpoint'] ))
				showmessage ( L ( 'points_less_than', array (
						'point' => $memberinfo ['point'],
						'need_point' => abs ( $setting ['presentpoint'] ) 
				) ), APP_PATH . 'index.php?m=pay&c=deposit&a=pay&exchange=point', 3000 );
				
				// 判断企业组录入是否需要审核
			if ($grouplist [$memberinfo ['groupid']] ['allowpostverify'] || ! $setting ['workflowid']) {
				$info ['status'] = 99;
			} else {
				$info ['status'] = 1;
			}
			$info ['username'] = $memberinfo ['username'];
			$this->content_db->siteid = $siteid;
			
			$id = $this->content_db->add_content ( $info );
			// 检查录入奖励或扣除积分
			$flag = $catid . '_' . $id;
			if ($setting ['presentpoint'] > 0) {
				pc_base::load_app_class ( 'receipts', 'pay', 0 );
				receipts::point ( $setting ['presentpoint'], $memberinfo ['userid'], $memberinfo ['username'], $flag, 'selfincome', L ( 'contribute_add_point' ), $memberinfo ['username'] );
			} else {
				pc_base::load_app_class ( 'spend', 'pay', 0 );
				spend::point ( $setting ['presentpoint'], L ( 'contribute_del_point' ), $memberinfo ['userid'], $memberinfo ['username'], '', '', $flag );
			}
			// 缓存结果
			$model_cache = getcache ( 'model', 'commons' );
			$infos = array ();
			foreach ( $model_cache as $modelid => $model ) {
				if ($model ['siteid'] == $siteid) {
					$datas = array ();
					$this->content_db->set_model ( $modelid );
					$datas = $this->content_db->select ( array (
							'username' => $memberinfo ['username'],
							'sysadd' => 0 
					), 'id,catid,title,url,username,sysadd,inputtime,status', 100, 'id DESC' );
				}
			}
			setcache ( 'member_' . $memberinfo ['userid'] . '_' . $siteid, $infos, 'content' );
			// 缓存结果 END
			if ($info ['status'] == 99) {
				showmessage ( L ( 'contributors_success' ), APP_PATH . 'index.php?m=member&c=content&a=info_top&id=' . $id . '&catid=' . $catid . '&msg=1' );
			} else {
				showmessage ( L ( 'contributors_checked' ), APP_PATH . 'index.php?m=member&c=content&a=info_top&id=' . $id . '&catid=' . $catid . '&msg=1' );
			}
		} else {
			$show_header = $show_dialog = $show_validator = '';
			$step = $step_1 = $step_2 = $step_3 = $step_4;
			$temp_language = L ( 'news', '', 'content' );
			$sitelist = getcache ( 'sitelist', 'commons' );
			/*
			 * if(!isset($_GET['siteid']) && count($sitelist)>1) {
			 * include template('member', 'content_publish_select_model');
			 * exit;
			 * }
			 */
			// 设置cookie 在附件添加处调用
			param::set_cookie ( 'module', 'content' );
			$siteid = intval ( $_GET ['siteid'] );
			
			// 获取信息模型类别、区域、城市信息
			$info_linkageid = getinfocache ( 'info_linkageid' );
			$cityid = getcity ( trim ( $_GET ['city'] ), 'linkageid' );
			$cityname = getcity ( trim ( $_GET ['city'] ), 'name' );
			$citypinyin = getcity ( trim ( $_GET ['city'] ), 'pinyin' );
			$zone = intval ( $_GET ['zone'] );
			$zone_name = get_linkage ( $zone, $info_linkageid, '', 0 );
			
			if (! $siteid)
				$siteid = 1;
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			$priv_db = pc_base::load_model ( 'category_priv_model' ); // 加载栏目权限表数据模型
			foreach ( $CATEGORYS as $catid => $cat ) {
				if ($cat ['siteid'] == $siteid && $cat ['child'] == 0 && $cat ['type'] == 0 && $priv_db->get_one ( array (
						'catid' => $catid,
						'roleid' => $memberinfo ['groupid'],
						'is_admin' => 0,
						'action' => 'add' 
				) ))
					break;
			}
			$catid = $_GET ['catid'] ? intval ( $_GET ['catid'] ) : $catid;
			if (! $catid)
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
				
				// 判断本栏目是否允许录入
			if (! $priv_db->get_one ( array (
					'catid' => $catid,
					'roleid' => $memberinfo ['groupid'],
					'is_admin' => 0,
					'action' => 'add' 
			) ))
				showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
			$category = $CATEGORYS [$catid];
			if ($category ['siteid'] != $siteid)
				showmessage ( L ( 'site_no_category' ), '?m=member&c=content&a=info_publish' );
			$setting = string2array ( $category ['setting'] );
			if ($zone == 0 && ! isset ( $_GET ['catid'] )) {
				$step = 1;
				include template ( 'member', 'info_content_publish_select' );
				exit ();
			} elseif ($zone == 0 && $category ['child']) {
				$step = 2;
				$step_1 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '&city=' . $citypinyin . '">' . $category ['catname'] . '</a>';
				include template ( 'member', 'info_content_publish_select' );
				exit ();
			} elseif ($zone == 0 && isset ( $_GET ['catid'] )) {
				$step = 3;
				$step_1 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '">' . $CATEGORYS [$category ['parentid']] ['catname'] . '</a>';
				$step_2 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '&city=' . $citypinyin . '&catid=' . $category ['parentid'] . '">' . $category ['catname'] . '</a>';
				$zone_arrchild = show_linkage ( $info_linkageid, $cityid, $cityid );
				include template ( 'member', 'info_content_publish_select' );
				exit ();
			} elseif ($zone !== 0 && get_linkage_level ( $info_linkageid, $zone, 'child' ) && ! $_GET ['jumpstep']) {
				$step = 4;
				$step_1 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '&city=' . $citypinyin . '">' . $CATEGORYS [$category ['parentid']] ['catname'] . '</a>';
				$step_2 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '&city=' . $citypinyin . '&catid=' . $category ['parentid'] . '">' . $category ['catname'] . '</a>';
				$step_3 = '<a href="' . APP_PATH . 'index.php?m=member&c=content&a=info_publish&siteid=' . $siteid . '&city=' . $citypinyin . '&catid=' . $catid . '">' . $zone_name . '</a>';
				
				$zone_arrchild = get_linkage_level ( $info_linkageid, $zone, 'arrchildinfo' );
				include template ( 'member', 'info_content_publish_select' );
				exit ();
			}
			
			if ($setting ['presentpoint'] < 0 && $memberinfo ['point'] < abs ( $setting ['presentpoint'] ))
				showmessage ( L ( 'points_less_than', array (
						'point' => $memberinfo ['point'],
						'need_point' => abs ( $setting ['presentpoint'] ) 
				) ), APP_PATH . 'index.php?m=pay&c=deposit&a=pay&exchange=point', 3000 );
			if ($category ['type'] != 0)
				showmessage ( L ( 'illegal_operation' ) );
			$modelid = $category ['modelid'];
			
			require CACHE_MODEL_PATH . 'content_form.class.php';
			$content_form = new content_form ( $modelid, $catid, $CATEGORYS );
			
			$data = array (
					'zone' => $zone,
					'city' => $cityid 
			);
			$forminfos_data = $content_form->get ( $data );
			
			$forminfos = array ();
			foreach ( $forminfos_data as $_fk => $_fv ) {
				if ($_fv ['isomnipotent'])
					continue;
				if ($_fv ['formtype'] == 'omnipotent') {
					foreach ( $forminfos_data as $_fm => $_fm_value ) {
						if ($_fm_value ['isomnipotent']) {
							$_fv ['form'] = str_replace ( '{' . $_fm . '}', $_fm_value ['form'], $_fv ['form'] );
						}
					}
				}
				$forminfos [$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			// 去掉栏目id
			unset ( $forminfos ['catid'] );
			
			$workflowid = $setting ['workflowid'];
			header ( "Cache-control: private" );
			include template ( 'member', 'info_content_publish' );
		}
	}
	function info_top() {
		$exist_posids = array ();
		$memberinfo = $this->memberinfo;
		$_username = $this->memberinfo ['username'];
		$id = intval ( $_GET ['id'] );
		
		$catid = $_GET ['catid'];
		$pos_data = pc_base::load_model ( 'position_data_model' );
		
		if (! $id || ! $catid)
			showmessage ( L ( 'illegal_parameters' ), HTTP_REFERER );
		if (isset ( $catid ) && $catid) {
			$siteids = getcache ( 'category_content', 'commons' );
			$siteid = $siteids [$catid];
			$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
			$category = $CATEGORYS [$catid];
			if ($category ['type'] == 0) {
				$modelid = $category ['modelid'];
				$this->model = getcache ( 'model', 'commons' );
				$this->content_db = pc_base::load_model ( 'content_model' );
				$this->content_db->set_model ( $modelid );
				$this->content_db->table_name = $this->content_db->db_tablepre . $this->model [$modelid] ['tablename'];
				$r = $this->content_db->get_one ( array (
						'id' => $id,
						'username' => $_username,
						'sysadd' => 0 
				) );
				if (! $r)
					showmessage ( L ( 'illegal_operation' ) );
					
					// 再次重新赋值，以数据库为准
				$catid = $CATEGORYS [$r ['catid']] ['catid'];
				$modelid = $CATEGORYS [$catid] ['modelid'];
				
				require_once CACHE_MODEL_PATH . 'content_output.class.php';
				$content_output = new content_output ( $modelid, $catid, $CATEGORYS );
				$data = $content_output->get ( $r );
				extract ( $data );
			}
		}
		// 置顶推荐位数组
		$infos = getcache ( 'info_setting', 'commons' );
		$toptype_posid = array (
				'1' => $infos ['top_city_posid'],
				'2' => $infos ['top_zone_posid'],
				'3' => $infos ['top_district_posid'] 
		);
		foreach ( $toptype_posid as $_k => $_v ) {
			if ($pos_data->get_one ( array (
					'id' => $id,
					'catid' => $catid,
					'posid' => $_v 
			) )) {
				$exist_posids [$_k] = 1;
			}
		}
		include template ( 'member', 'info_top' );
	}
	function info_top_cost() {
		$amount = $msg = '';
		$memberinfo = $this->memberinfo;
		$_username = $this->memberinfo ['username'];
		$_userid = $this->memberinfo ['userid'];
		$infos = getcache ( 'info_setting', 'commons' );
		$toptype_arr = array (
				1,
				2,
				3 
		);
		// 置顶积分数组
		$toptype_price = array (
				'1' => $infos ['top_city'],
				'2' => $infos ['top_zone'],
				'3' => $infos ['top_district'] 
		);
		// 置顶推荐位数组
		$toptype_posid = array (
				'1' => $infos ['top_city_posid'],
				'2' => $infos ['top_zone_posid'],
				'3' => $infos ['top_district_posid'] 
		);
		if (isset ( $_POST ['dosubmit'] )) {
			$posids = array ();
			$push_api = pc_base::load_app_class ( 'push_api', 'admin' );
			$pos_data = pc_base::load_model ( 'position_data_model' );
			$catid = intval ( $_POST ['catid'] );
			$id = intval ( $_POST ['id'] );
			$flag = $catid . '_' . $id;
			$toptime = intval ( $_POST ['toptime'] );
			if ($toptime == 0 || empty ( $_POST ['toptype'] ))
				showmessage ( L ( 'info_top_not_setting_toptime' ) );
				// 计算置顶扣费积分，时间
			if (is_array ( $_POST ['toptype'] ) && ! empty ( $_POST ['toptype'] )) {
				foreach ( $_POST ['toptype'] as $r ) {
					if (is_numeric ( $r ) && in_array ( $r, $toptype_arr )) {
						$posids [] = $toptype_posid [$r];
						$amount += $toptype_price [$r];
						$msg .= $r . '-';
					}
				}
			}
			// 应付总积分
			$amount = $amount * $toptime;
			
			// 扣除置顶点数
			pc_base::load_app_class ( 'spend', 'pay', 0 );
			$pay_status = spend::point ( $amount, L ( 'info_top' ) . $msg, $_userid, $_username, '', '', $flag );
			if ($pay_status == false) {
				$msg = spend::get_msg ();
				showmessage ( $msg );
			}
			// 置顶过期时间
			// TODO
			$expiration = SYS_TIME + $toptime * 3600;
			
			// 获取置顶文章信息内容
			if (isset ( $catid ) && $catid) {
				$siteids = getcache ( 'category_content', 'commons' );
				$siteid = $siteids [$catid];
				$CATEGORYS = getcache ( 'category_content_' . $siteid, 'commons' );
				$category = $CATEGORYS [$catid];
				if ($category ['type'] == 0) {
					$modelid = $category ['modelid'];
					$this->model = getcache ( 'model', 'commons' );
					$this->content_db = pc_base::load_model ( 'content_model' );
					$this->content_db->set_model ( $modelid );
					$this->content_db->table_name = $this->content_db->db_tablepre . $this->model [$modelid] ['tablename'];
					$r = $this->content_db->get_one ( array (
							'id' => $id,
							'username' => $_username,
							'sysadd' => 0 
					) );
				}
			}
			if (! $r)
				showmessage ( L ( 'illegal_operation' ) );
			
			$push_api->position_update ( $id, $modelid, $catid, $posids, $r, $expiration, 1 );
			$refer = $_POST ['msg'] ? $r ['url'] : '';
			if ($_POST ['msg'])
				showmessage ( L ( 'ding_success' ), $refer );
			else
				showmessage ( L ( 'ding_success' ), '', '', 'top' );
		} else {
			
			$toptype = trim ( $_POST ['toptype'] );
			$toptime = trim ( $_POST ['toptime'] );
			$types = explode ( '_', $toptype );
			if (is_array ( $types ) && ! empty ( $types )) {
				foreach ( $types as $r ) {
					if (is_numeric ( $r ) && in_array ( $r, $toptype_arr )) {
						$amount += $toptype_price [$r];
					}
				}
			}
			$amount = $amount * $toptime;
			echo $amount;
		}
	}
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * 
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class ( 'client', '', 0 );
		define ( 'APPID', pc_base::load_config ( 'system', 'phpsso_appid' ) );
		$phpsso_api_url = pc_base::load_config ( 'system', 'phpsso_api_url' );
		$phpsso_auth_key = pc_base::load_config ( 'system', 'phpsso_auth_key' );
		$this->client = new client ( $phpsso_api_url, $phpsso_auth_key );
		return $phpsso_api_url;
	}
	
	/**
	 * Function UPLOAD_VIDEO
	 * 用户上传视频
	 */
	public function upload_video() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache ( 'grouplist' );
		// 判断企业组是否允许录入
		if (! $grouplist [$memberinfo ['groupid']] ['allowpost']) {
			showmessage ( L ( 'member_group' ) . L ( 'publish_deny' ), HTTP_REFERER );
		}
		// 判断每日录入数
		$this->content_check_db = pc_base::load_model ( 'content_check_model' );
		$todaytime = strtotime ( date ( 'y-m-d', SYS_TIME ) );
		$_username = $this->memberinfo ['username'];
		$allowpostnum = $this->content_check_db->count ( "`inputtime` > $todaytime AND `username`='$_username'" );
		if ($grouplist [$memberinfo ['groupid']] ['allowpostnum'] > 0 && $allowpostnum >= $grouplist [$memberinfo ['groupid']] ['allowpostnum']) {
			showmessage ( L ( 'allowpostnum_deny' ) . $grouplist [$memberinfo ['groupid']] ['allowpostnum'], HTTP_REFERER );
		}
		// 加载视频库配置信息
		pc_base::load_app_class ( 'ku6api', 'video', 0 );
		$setting = getcache ( 'video', 'video' );
		if (empty ( $setting )) {
			showmessage ( '上传功能还在开发中，请稍后重试！' );
		}
		$ku6api = new ku6api ( $setting ['sn'], $setting ['skey'] );
		if (isset ( $_POST ['dosubmit'] )) {
			$_POST ['info'] ['catid'] = isset ( $_POST ['info'] ['catid'] ) ? intval ( $_POST ['info'] ['catid'] ) : showmessage ( '请选择栏目！' );
			$_POST ['info'] ['title'] = isset ( $_POST ['info'] ['title'] ) ? safe_replace ( $_POST ['info'] ['title'] ) : showmessage ( '标题不能为空！' );
			$_POST ['info'] ['keywords'] = isset ( $_POST ['info'] ['keywords'] ) ? safe_replace ( $_POST ['info'] ['keywords'] ) : '';
			$_POST ['info'] ['description'] = isset ( $_POST ['info'] ['description'] ) ? safe_replace ( $_POST ['info'] ['description'] ) : '';
			// 查询此模型下的视频字段
			$field = get_video_field ( $_POST ['info'] ['catid'] );
			if (! $field)
				showmessage ( '上传功能还在开发中，请稍后重试！' );
			$_POST ['info'] [$field] = 1;
			$_POST [$field . '_video'] = array (
					1 => array (
							'title' => $_POST ['info'] ['title'],
							'vid' => $_POST ['vid'],
							'listorder' => 1 
					) 
			);
			unset ( $_POST ['vid'] );
			$this->publish ();
		} else {
			$categorys = video_categorys ();
			if (is_array ( $categorys ) && ! empty ( $categorys )) {
				$cat = array ();
				$priv_db = pc_base::load_model ( 'category_priv_model' ); // 加载栏目权限表数据模型
				foreach ( $categorys as $cid => $c ) {
					if ($c ['child'] == 0 && $c ['type'] == 0 && ! $priv_db->get_one ( array (
							'catid' => $cid,
							'roleid' => $memberinfo ['groupid'],
							'is_admin' => 0,
							'action' => 'add' 
					) ))
						unset ( $categorys [$cid] );
				}
				if (empty ( $categorys ))
					showmessage ( L ( 'category' ) . L ( 'publish_deny' ), APP_PATH . 'index.php?m=member' );
				foreach ( $categorys as $cid => $c ) {
					if ($c ['child']) {
						$ischild = 1;
						$categorys [$cid] ['disabled'] = 'disabled';
					}
					$cat [$cid] = $c ['catname'];
				}
				if (! $ischild) {
					$cat_list = form::radio ( $cat, '', 'name="info[catid]"', '90' );
				} else {
					$tree = pc_base::load_sys_class ( 'tree' );
					$str = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
					
					$tree->init ( $categorys );
					$string = $tree->get_tree ( 0, $str );
					$cat_list = '<select name="info[catid]" id="catid"><option value="0">请选择栏目</option>' . $string . '</select>';
				}
			}
			$flash_info = $ku6api->flashuploadparam (); // 加载视频上传工具信息
			
			include template ( 'member', 'upload_video' );
		}
	}
}


class progress_date{
	public $proDate;
	public $date;
	public $monthCount;
	public $month;
	public $dates;
	public $startDate;
	
	public function __construct(){
		/**
		 * 时间计算*
		 */
		$this->proDate = $_GET ['proDate'];
		$this->startDate = strtotime ( $this->proDate );
		
		if(isset($_GET['endDate'])){
			$this->date = strtotime ($_GET['endDate']);
		}else{
			$this->date = strtotime ( date ( 'Y-m-d H:i:s' ) );
		}
		$this->monthCount = ceil ( $this->date - $this->startDate ) / 86400 / 30;
		$this->month=$this->monthCount = ceil ( $this->monthCount );
		if ($this->monthCount > 4) {
			$this->month = 4;
		}
		
		$this->dates = array ();
		for($i = $this->month; $i > 0; $i--) {
			$j = $i - 1;
			$this->dates [] = date ( 'Y-m', strtotime(" -".$j." month",$this->date));
		}
	}
}

?>