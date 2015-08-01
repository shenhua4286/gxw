<?php
/**
 * 企业前台管理中心、账号管理、收藏操作类
 */

defined('IN_gxw') or exit('No permission resources.');
require gxw_PATH.'/phpexcel//Classes/PHPExcel.php';
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_class('Calendar');
class index extends foreground {

	private $times_db;
	
	function __construct() {
		parent::__construct();
		$this->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
	}
	
	/***获取日历**/
	public function public_day(){
		//获取当天日期代码
		$now = SYS_TIME;
		$year = date("Y",$now);
		$month = date("m",$now);
		$day = date("d",$now);
		$week = date("w",$now);
		switch($week){
			case 0:
				$week="日";
				break;
			case 1:
				$week="一";
				break;
			case 2:
				$week="二";
				break;
			case 3:
				$week="三";
				break;
			case 4:
				$week="四";
				break;
			case 5:
				$week="五";
				break;
			case 6:
				$week="六";
				break;
		}
		$calendar = new Calendar();
		$arr = $calendar->Cal($year,$month,$day);
		$lunar = "农历".$arr["month"].$arr["day"];
		$solar = date("Y.m.d")."周".$week;
		$day = $day;
		$status=array('status'=>'true',
					  'msg'=>array('lunar'=>$lunar,'solar'=>$solar,'day'=>$day));
		jsonExit($status);
	}
	public function init() {
	///	echo dd;die;
		$memberinfo = $this->memberinfo;
		header("location:"."index.php");
		/*//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		//获取头像数组
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);

		$grouplist = getcache('grouplist');
		$memberinfo['groupname'] = $grouplist[$memberinfo[groupid]]['name'];


		//$this->db = pc_base::load_model('member_info_model');
  		$member=$this->db ->get_fields("member_info");
  		$membersumcount=count($member);//字段总数
  		$memberin=$this->db ->get_one($where = 'userid='.$memberinfo["userid"], $data = '*');
  		$membercount=0;
  		foreach( $memberin as $key=>$val){
  			if($val==""||$val==0||$val==NULL ){
  				$membercount++;
  			}
  		}
  		
  		$memberpercent=100 - ceil($membercount/$membersumcount *100);//信息完整度百分比
  		
  		$member1_db = pc_base::load_model('member_model');
  		
  		$shenhenum=$member1_db ->select($where = 'groupid=4', $data = 'userid');
  		$shenhesumnum=$member1_db ->select($where = '', $data = 'userid');
       
		include template('member', 'index');*/
	}
	
	
	public function main(){
		include template('member', 'main');
	}
	
	public function recommend_list(){
		
		include template("member","recommend_list");
	}
	
	/**群聊**/
	public function group_list(){
		$memberinfo = $this->memberinfo;
		setcookie('onez_userid',$memberinfo['userid']);
		setcookie('onez_username', $memberinfo['nickname']);
		$channelid=isset($_GET['channelid']) ? $_GET['channelid']:1;
		include template('member', 'member_group_list');
	}
	
	/**群聊**/
	public function group(){
		$memberinfo = $this->memberinfo;
		setcookie('onez_userid',$memberinfo['userid']);
		setcookie('onez_username', $memberinfo['nickname']);
		$channelid=isset($_GET['channelid']) ? $_GET['channelid']:1;
		include template('member', 'member_group');
	}
	
	
	public function public_loadMenu(){
		$parentid=isset($_GET['parentid']) ? $_GET['parentid'] :0;
		$this->menu_db = pc_base::load_model('member_menu_model');
		$menu = $this->menu_db->select(array('display'=>1, 'parentid'=>$parentid), '*', 20 , 'listorder');
		$list=array();
		foreach ($menu as $m){
			$m['menuName']=L($m['name'], '', 'member_menu');
			$childMenu=$this->menu_db->select(array('display'=>1, 'parentid'=>$m['id']), '*', 20 , 'listorder');
			foreach ($childMenu as $cm){
				$cm['menuName']=L($cm['name'], '', 'member_menu');
				$m['child'][]=$cm;
			}
			$list[]=$m;
		}
		$data=json_encode($list);
		echo $data;
	}
	
  
	
	function lists() {
		$memberinfo = $this->memberinfo;
		// 站点信息
		$sitelistarr = getcache ( 'sitelist', 'commons' );
		$siteid = isset ( $_REQUEST ['siteid'] ) ? intval ( $_REQUEST ['siteid'] ) : '0';
		foreach ( $sitelistarr as $k => $v ) {
			$sitelist [$k] = $v ['name'];
		}
		$grouplist = getcache ( 'grouplist' );
		foreach ( $grouplist as $k => $v ) {
			$grouplist [$k] = $v ['name'];
		}
		// 企业所属模型
		$modellistarr = getcache ( 'member_model', 'commons' );
		foreach ( $modellistarr as $k => $v ) {
			$modellist [$k] = $v ['name'];
		}
		$status = isset ( $_REQUEST ['status'] ) ? $_REQUEST ['status'] : '';
		$title = isset ( $_REQUEST ['title'] ) ? $_REQUEST ['title'] : '';
		if (isset ( $_REQUEST ['search'] )) {
			
			// 默认选取一个月内的用户，防止用户量过大给数据造成灾难
			$where_start_time = strtotime ( $start_time ) ? strtotime ( $start_time ) : 0;
			$where_end_time = strtotime ( $end_time ) + 86400;
			// 开始时间大于结束时间，置换变量
			if ($where_start_time > $where_end_time) {
				$tmp = $where_start_time;
				$where_start_time = $where_end_time;
				$where_end_time = $tmp;
				$tmptime = $start_time;
				
				$start_time = $end_time;
				$end_time = $tmptime;
				unset ( $tmp, $tmptime );
			}
			
			$area = $memberinfo ['area'] ? $memberinfo ['area'] :$_POST['info']['area'];
			$where = 'groupid = 12 and';
			
			if(isset($area)){
				$where .= " area = '$area' and";
			}
			/*if ($memberinfo ['groupid'] < 15) {
				$where .= " area = '$area' and";
			}else{
				
			}*/
			
			// 如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if ($_SESSION ['roleid'] == 1) {
				if (! empty ( $siteid )) {
					$where .= "`siteid` = '$siteid' AND ";
				}
			} else {
				$siteid = get_siteid ();
				$where .= "`siteid` = '$siteid' AND ";
			}
			
			$steps = $_REQUEST ['steps'];
			
			if ($status) {
				// /$islock = $status == 1 ? 1 : 0;
				$where .= "`status` = '$status' AND ";
			}
			if ($title) {
				$where .= "`nickname` like '%$title%' AND";
			}
			$where .= ' 1';
		} else {
			$where = '';
		}
		//echo $where;
		$page = isset ( $_REQUEST ['page'] ) ? intval ( $_REQUEST ['page'] ) : 1;
		$memberlist = $this->db->listinfo ( $where, 'userid DESC', $page, 15 );
		$pages = $this->db->pages;
		include template ( 'member', 'member_list' );
	}
	
	
	
	/**项目审核**/
	/**
	 * 过审内容
	 */
	public function pass() {
		$memberinfo=$this->memberinfo;
		if($memberinfo['groupid'] <=12) showmessage('你没有权限操作此项');
		$message_db = pc_base::load_model('message_model');
		$content_db = pc_base::load_model('content_model');
		$catid = intval($_GET['catid']);
	
		if(!$catid) showmessage(L('missing_part_parameters'));
		
		$this->siteid = get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		
		$category = $this->categorys[$catid];
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		//print_r($category);
		//只有存在工作流才需要审核
		if($workflowid) {
			$steps = intval($_POST['steps']);
			//检查当前用户有没有当前工作流的操作权限
			$workflows = getcache('workflow_'.$this->siteid,'commons');
			$workflows = $workflows[$workflowid];
			$workflows_setting = string2array($workflows['setting']);
			//将有权限的级别放到新数组中
			$admin_privs = array();
			foreach($workflows_setting as $_k=>$_v) {
				if(empty($_v)) continue;
				foreach($_v as $_value) {
					if($_value==$admin_username) $admin_privs[$_k] = $_k;
				}
			}
			//if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
			//更改内容状态
			if(isset($_GET['reject'])) {
				//退稿
				$status = 0;
			} else {
				//工作流审核级别
				$workflow_steps = $workflows['steps'];
					
				if($workflow_steps>$steps) {
					$status = $steps+1;
				} else {
					$status = 99;
				}
				
				if($catid==9){
					$str1="";$str2="";
					switch($status){
						case 1:$str1='您的申报的项目';$str2='正在进一步审核';break;
						case 2:$str1='您的申报的项目';$str2='通过项目审核';break;
						case 99:$str1='您的申报的项目';$str2='通过了审核';break;
						default :$str1='您的申报的项目';$str2='已通过了审核';
					}
					//非退稿,发送审核消息
					if (isset($_POST['ids']) && !empty($_POST['ids'])) {
						foreach ($_POST['ids'] as $id) {
							$content_info = $content_db->get_content($catid,$id);
							$memberinfo = $this->db->get_one(array('username'=>$content_info['username']), 'userid, username');
							$title=$content=$str1.'"'.$content_info['title'].'"'.$str2;
							$message_db->add_message($memberinfo['username'],'SYSTEM',$title,$content);
						}
					}
				}
			}
			//echo $status;die;
			$memberinfo = $this->db->get_one(array('username'=>'shenhua52'), 'userid, username');
			$modelid = $this->categorys[$catid]['modelid'];
			$content_db->set_model($modelid);
			$content_db->search_db = pc_base::load_model('search_model');
			//审核通过，检查录入奖励或扣除积分
			if ($status==99) {
				$html = pc_base::load_app_class('html', 'content');
				$this->url = pc_base::load_app_class('url', 'content');
	
				if (isset($_POST['ids']) && !empty($_POST['ids'])) {
					foreach ($_POST['ids'] as $id) {
						$content_info = $content_db->get_content($catid,$id);
						$memberinfo = $this->db->get_one(array('username'=>$content_info['username']), 'userid, username');
							
						$flag = $catid.'_'.$id;
						if($setting['presentpoint']>0) {
							pc_base::load_app_class('receipts','pay',0);
							receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
						} else {
							pc_base::load_app_class('spend','pay',0);
							spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
						}
						if($setting['content_ishtml'] == '1'){//栏目有静态配置
							$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
							$html->show($urls[1],$urls['data'],0);
						}
						//更新到全站搜索
						$inputinfo = '';
						$inputinfo['system'] = $content_info;
						$content_db->search_api($id,$inputinfo);
					}
				} else if (isset($_GET['id']) && $_GET['id']) {
					$id = intval($_GET['id']);
					$content_info = $content_db->get_content($catid,$id);
					$memberinfo = $this -> db->get_one(array('username'=>'shenhua52'), 'userid, username');
					//print_r($content_db);
				//	print_r($this->db);
					//$memberinfo = $this->db->get_one(array('username'=>$content_info['username']), 'userid, username');
					$flag = $catid.'_'.$id;
					if($setting['presentpoint']>0) {
						pc_base::load_app_class('receipts','pay',0);
						receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
					} else {
						pc_base::load_app_class('spend','pay',0);
						spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
					}
					//单篇审核，生成静态
					if($setting['content_ishtml'] == '1'){//栏目有静态配置
						$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
						$html->show($urls[1],$urls['data'],0);
					}
					//更新到全站搜索
					$inputinfo = '';
					$inputinfo['system'] = $content_info;
					$content_db->search_api($id,$inputinfo);
				}
			}
			if(isset($_GET['ajax_preview'])) {
				$_POST['ids'] = $_GET['id'];
			}
			$content_db->status($_POST['ids'],$status);
		}
		/*$steps=$_POST['steps'];//获取企业或产品的状态值，保证返回列表无误
		$status=$_POST['status'];//获取企业或产品的状态值，保证返回列表无误
		$t=$_POST['t'];
		$pt=$_POST['pt'];
		$type=$_POST['type'];
		//index.php?&menu=1&m=member&c=content&a=published&catid=9&type=steps&t=82&pt=68
		//$listurl="index.php?&menu=1&m=member&c=content&a=published&catid=".$catid."&type=".$type."&t=".$t."&pt=".$pt."&status=".$status;
		//$url=array(HTTP_REFERER);*/
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	public function center(){
		$memberinfo = $this->memberinfo;
		//var_dump($memberinfo);
		//获取企业模型表单
		$this->db->set_model($this->memberinfo['modelid']);
		$info = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
		include template('member', 'member_center');
	}
	
	
	public function register() {
		$this->_session_start();
		//获取用户siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		
		//加载用户模块配置
		$member_setting = getcache('member_setting');
		if(!$member_setting['allowregister']) {
			showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
		}
		//加载短信模块配置
 		$sms_setting_arr = getcache('sms','sms');
		$sms_setting = $sms_setting_arr[$siteid];		
		
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			if($member_setting['enablcodecheck']=='1'){//开启验证码
				if ((empty($_SESSION['connectid']) && $_SESSION['code'] != strtolower($_POST['code']) && $_POST['code']!==NULL) || empty($_SESSION['code'])) {
					showmessage(L('code_error'));
				} else {
					$_SESSION['code'] = '';
				}
			}
			
			$userinfo = array();
			$userinfo['encrypt'] = create_randomstr(6);

			$userinfo['username'] = (isset($_POST['username']) && is_username($_POST['username'])) ? $_POST['username'] : showmessage('请输入正确的用户名，请勿输入中文！', HTTP_REFERER,2000);
			$userinfo['nickname'] = (isset($_POST['nickname'])) ? $_POST['nickname'] : '';
			
			$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : exit('0');
			$userinfo['password'] = (isset($_POST['password']) && is_badword($_POST['password'])==false) ? $_POST['password'] : showmessage('密码验证失败', HTTP_REFERER,2000);
			
			$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : exit('0');

			$userinfo['modelid'] = isset($_POST['modelid']) ? intval($_POST['modelid']) : 10;
			$userinfo['regip'] = ip();
			$userinfo['status'] = $_POST['status'];
			$userinfo['point'] = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
			$userinfo['amount'] = $member_setting['defualtamount'] ? $member_setting['defualtamount'] : 0;
			$userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
			$userinfo['siteid'] = $siteid;
			$userinfo['connectid'] = isset($_SESSION['connectid']) ? $_SESSION['connectid'] : '';
			$userinfo['from'] = isset($_SESSION['from']) ? $_SESSION['from'] : '';
			//手机强制验证
			
			if($member_setting[mobile_checktype]=='1'){
				//取用户手机号
				$mobile_verify = $_POST['mobile_verify'] ? intval($_POST['mobile_verify']) : '';
				if($mobile_verify=='') showmessage('请提供正确的手机验证码！', HTTP_REFERER);
 				$sms_report_db = pc_base::load_model('sms_report_model');
				$posttime = SYS_TIME-360;
				$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'*','id DESC');
 				if(!empty($r)){
					$userinfo['mobile'] = $r['mobile'];
				}else{
					showmessage('未检测到正确的手机号码！', HTTP_REFERER);
				}
 			}elseif($member_setting[mobile_checktype]=='2'){
				//获取验证码，直接通过POST，取mobile值
				$userinfo['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';
			} 
			if($userinfo['mobile']!=""){
				if(!preg_match('/^1([0-9]{9})/',$userinfo['mobile'])) {
					showmessage('请提供正确的手机号码！', HTTP_REFERER);
				}
			} 
 			unset($_SESSION['connectid'], $_SESSION['from']);
			
			if($member_setting['enablemailcheck']) {	//是否需要邮件验证
				$userinfo['groupid'] = 7;
			} elseif($member_setting['registerverify']) {	//是否需要管理员审核
				$modelinfo_str = $userinfo['modelinfo'] = isset($_POST['info']) ? array2string(array_map("safe_replace", new_html_special_chars($_POST['info']))) : '';
				$this->verify_db = pc_base::load_model('member_verify_model');
				unset($userinfo['lastdate'],$userinfo['connectid'],$userinfo['from']);
				$userinfo['modelinfo'] = $modelinfo_str;
				$this->verify_db->insert($userinfo);
				showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=3');
			} else {
				//查看当前模型是否开启了短信验证功能
				$model_field_cache = getcache('model_field_'.$userinfo['modelid'],'model');
				if(isset($model_field_cache['mobile']) && $model_field_cache['mobile']['disabled']==0) {
					$mobile = $_POST['info']['mobile'];
					if(!preg_match('/^1([0-9]{10})/',$mobile)) showmessage(L('input_right_mobile'));
					$sms_report_db = pc_base::load_model('sms_report_model');
					$posttime = SYS_TIME-300;
					$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
					$r = $sms_report_db->get_one($where);
					if(!$r || $r['id_code']!=$_POST['mobile_verify']) showmessage(L('error_sms_code'));
				}
				//$userinfo['groupid'] = $this->_get_usergroup_bypoint($userinfo['point']);
				$userinfo['groupid'] = (isset($_POST['groupid'])) ? $_POST['groupid'] : '11';
			}
			
			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$status = $this->client->ps_member_register($userinfo['username'], $userinfo['password'], $userinfo['email'], $userinfo['regip'], $userinfo['encrypt']);
				if($status > 0) {
					$userinfo['phpssouid'] = $status;
					//传入phpsso为明文密码，加密后存入gxw_v9
					$password = $userinfo['password'];
					$userinfo['password'] = password($userinfo['password'], $userinfo['encrypt']);
					$userid = $this->db->insert($userinfo, 1);
					if($member_setting['choosemodel']) {	//如果开启选择模型
						//通过模型获取企业信息					
						require_once CACHE_MODEL_PATH.'member_input.class.php';
				        require_once CACHE_MODEL_PATH.'member_update.class.php';
						$member_input = new member_input($userinfo['modelid']);
						
						$_POST['info'] = array_map('new_html_special_chars',$_POST['info']);
						$user_model_info = $member_input->get($_POST['info']);
						$user_model_info['userid'] = $userid;
	
						//插入企业模型数据
						$this->db->set_model($userinfo['modelid']);
						$this->db->insert($user_model_info);
					}
					
					if($userid > 0) {
						//执行登陆操作
						if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
						$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
						$cookietime = $_cookietime ? TIME + $_cookietime : 0;
						
						if($userinfo['groupid'] == 7) {
							param::set_cookie('_username', $userinfo['username'], $cookietime);
							param::set_cookie('email', $userinfo['email'], $cookietime);							
						} else {
							$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
							$gxw_auth = sys_auth($userid."\t".$userinfo['password'], 'ENCODE', $gxw_auth_key);
							
							param::set_cookie('auth', $gxw_auth, $cookietime);
							param::set_cookie('_userid', $userid, $cookietime);
							param::set_cookie('_username', $userinfo['username'], $cookietime);
							param::set_cookie('_nickname', $userinfo['nickname'], $cookietime);
							param::set_cookie('_groupid', $userinfo['groupid'], $cookietime);
							param::set_cookie('_status', $userinfo['status'], $cookietime);
							param::set_cookie('cookietime', $_cookietime, $cookietime);
						}
					}
					//如果需要邮箱认证
					if($member_setting['enablemailcheck']) {
						pc_base::load_sys_func('mail');
						$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key'));
						$code = sys_auth($userid.'|'.SYS_TIME, 'ENCODE', $gxw_auth_key);
						$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
						$message = $member_setting['registerverifymessage'];
						$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$userinfo['username'],$userinfo['email'],$password), $message);
 						sendmail($userinfo['email'], L('reg_verify_email'), $message);
						//设置当前注册账号COOKIE，为第二步重发邮件所用
						param::set_cookie('_regusername', $userinfo['username'], $cookietime);
						param::set_cookie('_reguserid', $userid, $cookietime);
						param::set_cookie('_reguseruid', $userinfo['phpssouid'], $cookietime);
						showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=2');
					} else {
						//如果不需要邮箱认证、直接登录其他应用
						$synloginstr = $this->client->ps_member_synlogin($userinfo['phpssouid']);
						showmessage(L('operation_success').$synloginstr, 'index.php?m=member&c=index&a=init');
					}
					
				}
			} else {
				showmessage(L('enable_register').L('enable_phpsso'), 'index.php?m=member&c=index&a=login');
			}
			showmessage(L('operation_failure'), HTTP_REFERER);
		} else {
			if(!pc_base::load_config('system', 'phpsso')) {
				showmessage(L('enable_register').L('enable_phpsso'), 'index.php?m=member&c=index&a=login');
			}
			
			if(!empty($_GET['verify'])) {
				$code = isset($_GET['code']) ? trim($_GET['code']) : showmessage(L('operation_failure'), 'index.php?m=member&c=index');
				$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key'));
				$code_res = sys_auth($code, 'DECODE', $gxw_auth_key);
				$code_arr = explode('|', $code_res);
				$userid = isset($code_arr[0]) ? $code_arr[0] : '';
				$userid = is_numeric($userid) ? $userid : showmessage(L('operation_failure'), 'index.php?m=member&c=index');

				$this->db->update(array('groupid'=>$this->_get_usergroup_bypoint()), array('userid'=>$userid));
				showmessage(L('operation_success'), 'index.php?m=member&c=index');
			} elseif(!empty($_GET['protocol'])) {

				include template('member', 'protocol');
			} else {
				//过滤非当前站点企业模型
				$modellist = getcache('member_model', 'commons');
				foreach($modellist as $k=>$v) {
					if($v['siteid']!=$siteid || $v['disabled']) {
						unset($modellist[$k]);
					}
				}
				if(empty($modellist)) {
					showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
				}
				//是否开启选择企业模型选项
				if($member_setting['choosemodel']) {
					$first_model = array_pop(array_reverse($modellist));
					$modelid = isset($_GET['modelid']) && in_array($_GET['modelid'], array_keys($modellist)) ? intval($_GET['modelid']) : $first_model['modelid'];
					$modelid=12;
					if(array_key_exists($modelid, $modellist)) {
						//获取企业模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}
				}
				$description = $modellist[$modelid]['description'];
				$lunar = $this->lunar;
				$solar = $this->solar;
				$day = $this->day;
				include template('member', 'register');
			}
		}
	}
 	
	
	/*
	 * 测试邮件配置
	 */
	public function send_newmail() {
		$_username = param::get_cookie('_regusername');
		$_userid = param::get_cookie('_reguserid');
		$_ssouid = param::get_cookie('_reguseruid');
		$newemail = $_GET['newemail'];

		if($newemail==''){//邮箱为空，直接返回错误
			return '2';
		}
		$this->_init_phpsso();
		$status = $this->client->ps_checkemail($newemail);
		if($status=='-5'){//邮箱被占用
			exit('-1');
		}
		if ($status==-1) {
			$status = $this->client->ps_get_member_info($newemail, 3);
			if($status) {
				$status = unserialize($status);	//接口返回序列化，进行判断
				if (!isset($status['uid']) || $status['uid'] != intval($_ssouid)) {
					exit('-1');
				}
			} else {
				exit('-1');
			}
		}
		//验证邮箱格式
		pc_base::load_sys_func('mail');
		$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key'));
		$code = sys_auth($userid.'|'.SYS_TIME, 'ENCODE', $gxw_auth_key);
		$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
		
		//读取配置获取验证信息
		$member_setting = getcache('member_setting');
		$message = $member_setting['registerverifymessage'];
		$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$_username,$newemail,$password), $message);
		
 		if(sendmail($newemail, L('reg_verify_email'), $message)){
			//更新新的邮箱，用来验证
 			$this->db->update(array('email'=>$newemail), array('userid'=>$_userid));
			$this->client->ps_member_edit($_username, $newemail, '', '', $_ssouid);
			$return = '1';
		}else{
			$return = '2';
		}
		echo $return;
   	}
	
	public function account_manage() {
		$memberinfo = $this->memberinfo;
		//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		//获取头像数组
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);
	
		$grouplist = getcache('grouplist');
		$member_model = getcache('member_model', 'commons');

		//获取用户模型数据
		$this->db->set_model($this->memberinfo['modelid']);
		$member_modelinfo_arr = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
		$model_info = getcache('model_field_'.$this->memberinfo['modelid'], 'model');
		foreach($model_info as $k=>$v) {
			if($v['formtype'] == 'omnipotent') continue;
			if($v['formtype'] == 'image') {
				$member_modelinfo[$v['name']] = "<a href='$member_modelinfo_arr[$k]' target='_blank'><img src='$member_modelinfo_arr[$k]' height='40' widht='40' onerror=\"this.src='$phpsso_api_url/statics/images/member/nophoto.gif'\"></a>";
			} elseif($v['formtype'] == 'datetime' && $v['fieldtype'] == 'int') {	//如果为日期字段
				$member_modelinfo[$v['name']] = format::date($member_modelinfo_arr[$k], $v['format'] == 'Y-m-d H:i:s' ? 1 : 0);
			} elseif($v['formtype'] == 'images') {
				$tmp = string2array($member_modelinfo_arr[$k]);
				$member_modelinfo[$v['name']] = '';
				if(is_array($tmp)) {
					foreach ($tmp as $tv) {
						$member_modelinfo[$v['name']] .= " <a href='$tv[url]' target='_blank'><img src='$tv[url]' height='40' widht='40' onerror=\"this.src='$phpsso_api_url/statics/images/member/nophoto.gif'\"></a>";
					}
					unset($tmp);
				}
			} elseif($v['formtype'] == 'box') {	//box字段，获取字段名称和值的数组
				$tmp = explode("\n",$v['options']);
				if(is_array($tmp)) {
					foreach($tmp as $boxv) {
						$box_tmp_arr = explode('|', trim($boxv));
						if(is_array($box_tmp_arr) && isset($box_tmp_arr[1]) && isset($box_tmp_arr[0])) {
							$box_tmp[$box_tmp_arr[1]] = $box_tmp_arr[0];
							$tmp_key = intval($member_modelinfo_arr[$k]);
						}
					}
				}
				if(isset($box_tmp[$tmp_key])) {
					$member_modelinfo[$v['name']] = $box_tmp[$tmp_key];
				} else {
					$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
				}
				unset($tmp, $tmp_key, $box_tmp, $box_tmp_arr);
			} elseif($v['formtype'] == 'linkage') {	//如果为联动菜单
				$tmp = string2array($v['setting']);
				$tmpid = $tmp['linkageid'];
				$linkagelist = getcache($tmpid, 'linkage');
				$fullname = $this->_get_linkage_fullname($member_modelinfo_arr[$k], $linkagelist);

				$member_modelinfo[$v['name']] = substr($fullname, 0, -1);
				unset($tmp, $tmpid, $linkagelist, $fullname);
			} else {
				$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
			}
		}

		include template('member', 'account_manage');
	}

	public function account_manage_avatar() {
		$memberinfo = $this->memberinfo;
		//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		$ps_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$auth_data = $this->client->auth_data(array('uid'=>$this->memberinfo['phpssouid'], 'ps_auth_key'=>$ps_auth_key), '', $ps_auth_key);
		$upurl = base64_encode($phpsso_api_url.'/index.php?m=phpsso&c=index&a=uploadavatar&auth_data='.$auth_data);
		//获取头像数组
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);
		
		include template('member', 'account_manage_avatar');
	}

	public function account_manage_security() {
		$memberinfo = $this->memberinfo;
		include template('member', 'account_manage_security');
	}
	
	public function account_manage_info() {
		if(isset($_POST['dosubmit'])) {
			//更新用户企业名称
			$nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			//$groupid = isset($_POST['groupid']) ? trim($_POST['groupid']) : 10;
			$nickname = safe_replace($nickname);
			$area=$_POST['info']['area'];
			$status = $_POST['status'];
			unset($_POST['info']['area']);
			//echo $nickname;
			if($nickname){
				$this->db->update(array('nickname'=>$nickname,'status' => $status,
										'area'=>$area,'basic_industrys'=>$_POST['info']['basic_industrys']), 
								  array('userid'=>$this->memberinfo['userid']));
				
				if(!isset($cookietime)) {
					$get_cookietime = param::get_cookie('cookietime');
				}
				//更新用户状态
				if(pc_base::load_config('system', 'phpsso')) {
					//初始化phpsso
					$this->_init_phpsso();
					$res = $this->client->ps_member_edit($this->memberinfo['username'], '', '', '', '', '',$status);
					$message_error = array('-1'=>L('user_not_exist'), '-2'=>L('old_password_incorrect'), '-3'=>L('email_already_exist'), '-4'=>L('email_error'), '-5'=>L('param_error'));
					if ($res < 0) showmessage($message_error[$res]);
				}
			}
		
			
			$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
			$cookietime = $_cookietime ? TIME + $_cookietime : 0;
			param::set_cookie('_nickname', $nickname, $cookietime);
			param::set_cookie('_status', $status, $cookietime);
			//}
			require_once CACHE_MODEL_PATH.'member_input.class.php';
			require_once CACHE_MODEL_PATH.'member_update.class.php';
			$member_input = new member_input($this->memberinfo['modelid']);
			$modelinfo = $member_input->get($_POST['info']);

			$this->db->set_model($this->memberinfo['modelid']);
			$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
			if(!empty($membermodelinfo)) {
				$this->db->update($modelinfo, array('userid'=>$this->memberinfo['userid']));
			} else {
				$modelinfo['userid'] = $this->memberinfo['userid'];
				$this->db->insert($modelinfo);
			}
			
			$type=$_POST['type'];
			//TODO
			//echo $type;die;
			$nextType=array('basic' => array('url' => 'index.php?&menu=1&m=member&c=index&a=account_manage_info&type=pro&t=59&pt=55',
											 'text' =>'<span style="color:rgb(2,161,208);">保存成功,请继续完成填写生产经营信息</span>'),
							'pro' => array('url' =>'index.php?&menu=1&m=member&c=index&a=account_manage_info&type=kej&t=60&pt=55',
											'text' =>'<span style="color:rgb(2,161,208);">保存成功,请继续完成填写科技创新信息</span>'
							),
			);
			if(isset($nextType[$type])){
				$url=str_replace($type, $nextType[$type], HTTP_REFERER);
				showmessage("<a style='text-decoration:underline;' href='".$nextType[$type]['url']."'>". $nextType[$type]['text'] ."</a>", $nextType[$type]['url']);
			}else{
				showmessage('保存完成，请继续完成项目信息', HTTP_REFERER);
			}
			
		} else {
			$memberinfo = $this->memberinfo;
			//获取企业模型表单
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($this->memberinfo['modelid']);
			$this->db->set_model($this->memberinfo['modelid']);
			
			$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
			
			//print_r($mem)
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);

			
			//万能字段过滤
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}
			
			if($_POST['type']=='pro'){
				
			}
						
			$formValidator = $member_form->formValidator;
			
			$template='account_manage_info';
			if(isset($_GET['isShow'])) $template.="_show";
			include template('member', $template);
		}
	}
	
	
	/***企业审核**/
	public function check_manage_info() {
		if(isset($_POST['dosubmit'])) {
			$userid=$_POST['userid'];
			if(!isset($userid)){
				$userid=$_POST['userids'];
			}
			if(!$userid) showmessage(L('illegal_parameters'), HTTP_REFERER,1250);
			
			//echo $userid;
			$where = to_sqls($userid, '', 'userid');
			//更新用户企业名称
			//$nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			//$groupid = isset($_POST['groupid']) ? trim($_POST['groupid']) : 10;
			//$nickname = safe_replace($nickname);
			$status = $_POST['status'];
			//echo $nickname;
				$this->db->update(array('status' => $status), $where);
				if(!isset($cookietime)) {
					$get_cookietime = param::get_cookie('cookietime');
				}
				//更新用户状态
				/*if(pc_base::load_config('system', 'phpsso')) {
					//初始化phpsso
					$this->_init_phpsso();
					$res = $this->client->ps_member_edit('', '', '', '', $userid, '',$status);
					$message_error = array('-1'=>L('user_not_exist'), '-2'=>L('old_password_incorrect'), '-3'=>L('email_already_exist'), '-4'=>L('email_error'), '-5'=>L('param_error'));
					if ($res < 0) showmessage($message_error[$res]);
				}*/
	
			$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
			$cookietime = $_cookietime ? TIME + $_cookietime : 0;
			param::set_cookie('_status', $status, $cookietime);
			
			
			/**发送短消息**/
			$title='';$content='';
			$member_db=pc_base::load_model('member_model');
			$message_db=pc_base::load_model('message_model');
			switch($status){
				case 1: $content=$title='您的企业资料当前在审核状态'; break;
				case -1: $title='您的企业资料被驳回了,请重新填写资料，进行提交';$content="驳回意见:".$_POST['reject_c']; break;
				case 99: $content=$title='您企业资料已经审核通过了'; break;
				default: $content=$title='您的资料审核状态有了新的变化';
			}
			
			/**数组审核 发送消息**/
			if(is_array($userid)){
				foreach ($userid as $k => $u){
					$memberinfo = $member_db->get_one(array('userid'=>$u), 'userid, username');
					$message_db->add_message($memberinfo['username'],'SYSTEM',$title,$content);
				}
			}else{
				$memberinfo = $member_db->get_one(array('userid'=>$userid), 'userid, username');
				$message_db->add_message($memberinfo['username'],'SYSTEM',$title,$content);
			}
			
			//$url=array('返回列表'=>'index.php?&menu=1&m=member&c=index&a=lists&status=2&search=search&steps=1&t=89&pt=78','查看此信息'=>HTTP_REFERER);
			showmessage("审核成功", HTTP_REFERER);
				
		} else {
			$memberinfo = $this->memberinfo;
			$memberinfo['userid']=$_GET['userid'];
			$memberinfo['modelid']=$_GET['modelid'];
			
			$memberinfo = $this->db->get_one(array('userid' => $memberinfo['userid']));
			//获取企业模型表单
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($memberinfo['modelid']);
			$this->db->set_model($memberinfo['modelid']);
				
			$membermodelinfo = $this->db->get_one(array('userid'=>$memberinfo['userid']));
				
			
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);
			//万能字段过滤
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}
				
			if($_POST['type']=='pro'){
	
			}
	
			$formValidator = $member_form->formValidator;
	
			include template('member', 'check_manage_info');
		}
	}
	
	
	
	
	public function public_ie6(){
		include template('member','ie6');
	}
	
	
	public function account_manage_password() {
		if(isset($_POST['dosubmit'])) {
			$updateinfo = array();
			if(!is_password($_POST['info']['password'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			if($this->memberinfo['password'] != password($_POST['info']['password'], $this->memberinfo['encrypt'])) {
				showmessage(L('old_password_incorrect'), HTTP_REFERER);
			}
			
			//修改企业邮箱
			if($this->memberinfo['email'] != $_POST['info']['email'] && is_email($_POST['info']['email'])) {
				$email = $_POST['info']['email'];
				$updateinfo['email'] = $_POST['info']['email'];
			} else {
				$email = '';
			}
			$newpassword = password($_POST['info']['newpassword'], $this->memberinfo['encrypt']);
			$updateinfo['password'] = $newpassword;
			
			$this->db->update($updateinfo, array('userid'=>$this->memberinfo['userid']));
			if(pc_base::load_config('system', 'phpsso')) {
				//初始化phpsso
				$this->_init_phpsso();
				$res = $this->client->ps_member_edit('', $email, $_POST['info']['password'], $_POST['info']['newpassword'], $this->memberinfo['phpssouid'], $this->memberinfo['encrypt']);
				$message_error = array('-1'=>L('user_not_exist'), '-2'=>L('old_password_incorrect'), '-3'=>L('email_already_exist'), '-4'=>L('email_error'), '-5'=>L('param_error'));
				//print_r($res);
				//die;
				if ($res < 0) showmessage($message_error[$res]);
			}

			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$show_validator = true;
			$memberinfo = $this->memberinfo;
			
			include template('member', 'account_manage_password');
		}
	}
	//更换手机号码
	public function account_change_mobile() {
		$memberinfo = $this->memberinfo;
		if(isset($_POST['dosubmit'])) {
			if(!is_password($_POST['password'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			if($this->memberinfo['password'] != password($_POST['password'], $this->memberinfo['encrypt'])) {
				showmessage(L('old_password_incorrect'));
			}
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$mobile = $_POST['mobile'];
			if($mobile){
				if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
				$posttime = SYS_TIME-600;
				$where = "`mobile`='$mobile' AND `send_userid`='".$memberinfo['userid']."' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
				if($r && $r['id_code']==$mobile_verify) {
					$sms_report_db->update(array('id_code'=>''),$where);
					$this->db->update(array('mobile'=>$mobile),array('userid'=>$memberinfo['userid']));
					showmessage("手机号码更新成功！",'?m=member&c=index&a=account_change_mobile&t=1');
				} else {
					showmessage("短信验证码错误！请重新获取！");
				}
			}else{
				showmessage("短信验证码已过期！请重新获取！");
			}
		} else {
			include template('member', 'account_change_mobile');
		}
	}

	//选择密码找回方式
	public function public_get_password_type() {
		$siteid = intval($_GET['siteid']);
		include template('member', 'get_password_type');
	}

	public function account_manage_upgrade() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		if(empty($grouplist[$memberinfo['groupid']]['allowupgrade'])) {
			showmessage(L('deny_upgrade'), HTTP_REFERER);
		}
		if(isset($_POST['upgrade_type']) && intval($_POST['upgrade_type']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['upgrade_date']) && intval($_POST['upgrade_date']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['dosubmit'])) {
			$groupid = isset($_POST['groupid']) ? intval($_POST['groupid']) : showmessage(L('operation_failure'), HTTP_REFERER);
			
			$upgrade_type = isset($_POST['upgrade_type']) ? intval($_POST['upgrade_type']) : showmessage(L('operation_failure'), HTTP_REFERER);
			$upgrade_date = !empty($_POST['upgrade_date']) ? intval($_POST['upgrade_date']) : showmessage(L('operation_failure'), HTTP_REFERER);

			//消费类型，包年、包月、包日，价格
			$typearr = array($grouplist[$groupid]['price_y'], $grouplist[$groupid]['price_m'], $grouplist[$groupid]['price_d']);
			//消费类型，包年、包月、包日，时间
			$typedatearr = array('366', '31', '1');
			//消费的价格
			$cost = $typearr[$upgrade_type]*$upgrade_date;
			//购买时间
			$buydate = $typedatearr[$upgrade_type]*$upgrade_date*86400;
			$overduedate = $memberinfo['overduedate'] > SYS_TIME ? ($memberinfo['overduedate']+$buydate) : (SYS_TIME+$buydate);

			if($memberinfo['amount'] >= $cost) {
				$this->db->update(array('groupid'=>$groupid, 'overduedate'=>$overduedate, 'vip'=>1), array('userid'=>$memberinfo['userid']));
				//消费记录
				pc_base::load_app_class('spend','pay',0);
				spend::amount($cost, L('allowupgrade'), $memberinfo['userid'], $memberinfo['username']);
				showmessage(L('operation_success'), 'index.php?m=member&c=index&a=init');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}

		} else {
			
			$groupid = isset($_GET['groupid']) ? intval($_GET['groupid']) : '';
			//初始化phpsso
			$phpsso_api_url = $this->_init_phpsso();
			//获取头像数组
			$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);
			
			
			$memberinfo['groupname'] = $grouplist[$memberinfo[groupid]]['name'];
			$memberinfo['grouppoint'] = $grouplist[$memberinfo[groupid]]['point'];
			unset($grouplist[$memberinfo['groupid']]);
			include template('member', 'account_manage_upgrade');
		}
	}
	
	public function login() {
		
		$this->_session_start();
		//获取用户siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		
		if(isset($_POST['dosubmit'])) {
			if(empty($_SESSION['connectid'])) {
				//判断验证码
				$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
				if ($_SESSION['code'] != strtolower($code)) {
					showmessage(L('code_error'), HTTP_REFERER);
				}
			}
			//echo $_POST['username'];
			//die;
			
			$username = isset($_POST['username']) && is_username($_POST['username']) ? trim($_POST['username']) : showmessage(L('username_empty'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_empty'), HTTP_REFERER);
			$cookietime = intval($_POST['cookietime']);
			$synloginstr = ''; //同步登陆js代码
			
			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$status = $this->client->ps_member_login($username, $password);
				$memberinfo = unserialize($status);
				//print_r($memberinfo);
				//die;
				// dprint_r($status);die;
				
				if(isset($memberinfo['uid'])) {
					//查询帐号
					$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					if(!$r) {
						//插入企业详细信息，企业不存在 插入企业
						$info = array(
									'phpssouid'=>$memberinfo['uid'],
						 			'username'=>$memberinfo['username'],
						 			'password'=>$memberinfo['password'],
						 			'encrypt'=>$memberinfo['random'],
						 			'email'=>$memberinfo['email'],
						 			'regip'=>$memberinfo['regip'],
						 			'regdate'=>$memberinfo['regdate'],
						 			'lastip'=>$memberinfo['lastip'],
						 			'lastdate'=>$memberinfo['lastdate'],
						 			'groupid'=>$this->_get_usergroup_bypoint(),	//企业默认组
						 			'modelid'=>10,	//普通企业
									);
									
						//如果是connect用户
						if(!empty($_SESSION['connectid'])) {
							$userinfo['connectid'] = $_SESSION['connectid'];
						}
						if(!empty($_SESSION['from'])) {
							$userinfo['from'] = $_SESSION['from'];
						}
						unset($_SESSION['connectid'], $_SESSION['from']);
						
						$this->db->insert($info);
						unset($info);
						$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					}
					$password = $r['password'];
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
 				} else {
					if($status == -1) {	//用户不存在
						showmessage(L('user_not_exist'), HTTP_REFERER);
					} elseif($status == -2) { //密码错误
						showmessage(L('password_error'), HTTP_REFERER);
					} else {
						showmessage(L('login_failure'), HTTP_REFERER);
					}
				}
				
			} else {
				//密码错误剩余重试次数
				$this->times_db = pc_base::load_model('times_model');
				$rtime = $this->times_db->get_one(array('username'=>$username));
				if($rtime['times'] > 4) {
					$minute = 60 - floor((SYS_TIME - $rtime['logintime']) / 60);
					showmessage(L('wait_1_hour', array('minute'=>$minute)));
				}
				
				//查询帐号
				$r = $this->db->get_one(array('username'=>$username));

				if(!$r) showmessage(L('user_not_exist'),'index.php?m=member&c=index&a=login');
				
				//验证用户密码
				$password = md5(md5(trim($password)).$r['encrypt']);
				if($r['password'] != $password) {				
					$ip = ip();
					if($rtime && $rtime['times'] < 5) {
						$times = 5 - intval($rtime['times']);
						$this->times_db->update(array('ip'=>$ip, 'times'=>'+=1'), array('username'=>$username));
					} else {
						$this->times_db->insert(array('username'=>$username, 'ip'=>$ip, 'logintime'=>SYS_TIME, 'times'=>1));
						$times = 5;
					}
					showmessage(L('password_error', array('times'=>$times)), 'index.php?m=member&c=index&a=login', 3000);
				}
				$this->times_db->delete(array('username'=>$username));
			}
			
			//如果用户被锁定
			if($r['islock']) {
				showmessage(L('user_is_lock'));
			}
			
			$userid = $r['userid'];
			$groupid = $r['groupid'];
			$username = $r['username'];
			$status = $r['status'];
			$nickname = empty($r['nickname']) ? $username : $r['nickname'];
			$updatearr = array('lastip'=>ip(), 'lastdate'=>SYS_TIME);
			
			//vip过期，更新vip和企业组
			if($r['overduedate'] < SYS_TIME) {
				$updatearr['vip'] = 0;
			}		

			//检查用户积分，更新新用户组，除去邮箱认证、禁止访问、游客组用户、vip用户，如果该用户组不允许自助升级则不进行该操作		
			if($r['point'] >= 0 && !in_array($r['groupid'], array('1', '7', '8')) && empty($r[vip])) {
				$grouplist = getcache('grouplist');
				if(!empty($grouplist[$r['groupid']]['allowupgrade'])) {	
					$check_groupid = $this->_get_usergroup_bypoint($r['point']);
	
					if($check_groupid != $r['groupid']) {
						$updatearr['groupid'] = $groupid = $check_groupid;
					}
				}
			}

			//如果是connect用户
			if(!empty($_SESSION['connectid'])) {
				$updatearr['connectid'] = $_SESSION['connectid'];
			}
			if(!empty($_SESSION['from'])) {
				$updatearr['from'] = $_SESSION['from'];
			}
			unset($_SESSION['connectid'], $_SESSION['from']);
						
			$this->db->update($updatearr, array('userid'=>$userid));
			
			if(!isset($cookietime)) {
				$get_cookietime = param::get_cookie('cookietime');
			}
			
			
			//获取企业模型表单
			/*require CACHE_MODEL_PATH.'member_form.class.php';
			$this->db->set_model($r['modelid']);
			$membermodelinfo = $this->db->get_one(array('userid'=>$userid));*/
			
			$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
			$cookietime = $_cookietime ? SYS_TIME + $_cookietime : 0;
			
			$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
			$gxw_auth = sys_auth($userid."\t".$password, 'ENCODE', $gxw_auth_key);
			
			param::set_cookie('auth', $gxw_auth, $cookietime);
			param::set_cookie('_userid', $userid, $cookietime);
			param::set_cookie('_username', $username, $cookietime);
			param::set_cookie('_groupid', $groupid, $cookietime);
			param::set_cookie('_nickname', $nickname, $cookietime);
			param::set_cookie('_status', $status, $cookietime);
			param::set_cookie('_area', $r['area'], $cookietime);
			//param::set_cookie('cookietime', $_cookietime, $cookietime);
			$forward = isset($_POST['forward']) && !empty($_POST['forward']) ? urldecode($_POST['forward']) : 'index.php?m=member&c=index&a=center&t=27';
			//echo $forward;
			header("location:".$forward);
			//showmessage(L('login_success').$synloginstr, $forward);
		} else {
			$setting = pc_base::load_config('system');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';
			
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
			$lunar = $this->lunar;
			$solar = $this->solar;
			$day = $this->day;
			include template('member', 'login');
		}
	}
  	
	public function logout() {
		$setting = pc_base::load_config('system');
		//snda退出
		if($setting['snda_enable'] && param::get_cookie('_from')=='snda') {
			param::set_cookie('_from', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';
			$logouturl = 'https://cas.sdo.com/cas/logout?url='.urlencode(APP_PATH.'index.php?m=member&c=index&a=logout&forward='.$forward);
			header('Location: '.$logouturl);
		} else {
			$synlogoutstr = '';	//同步退出js代码
			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$synlogoutstr = $this->client->ps_member_synlogout();			
			}
			
			param::set_cookie('auth', '');
			param::set_cookie('_userid', '');
			param::set_cookie('_username', '');
			param::set_cookie('_groupid', '');
			param::set_cookie('_nickname', '');
			param::set_cookie('cookietime', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? $_GET['forward'] : 'index.php';
			showmessage(L('logout_success'), $forward);
		}
	}

	/**
	 * 我的收藏
	 * 
	 */
	public function favorite() {
		$this->favorite_db = pc_base::load_model('favorite_model');
		$memberinfo = $this->memberinfo;
		if(isset($_GET['id']) && trim($_GET['id'])) {
			$this->favorite_db->delete(array('userid'=>$memberinfo['userid'], 'id'=>intval($_GET['id'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
			$favoritelist = $this->favorite_db->listinfo(array('userid'=>$memberinfo['userid']), 'id DESC', $page, 10);
			$pages = $this->favorite_db->pages;

			include template('member', 'favorite_list');
		}
	}
	
	/**
	 * 我的好友
	 */
	public function friend() {
		$memberinfo = $this->memberinfo;
		$this->friend_db = pc_base::load_model('friend_model');
		if(isset($_GET['friendid'])) {
			$this->friend_db->delete(array('userid'=>$memberinfo['userid'], 'friendid'=>intval($_GET['friendid'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			//初始化phpsso
			$phpsso_api_url = $this->_init_phpsso();
	
			//我的好友列表userid
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$friendids = $this->friend_db->listinfo(array('userid'=>$memberinfo['userid']), '', $page, 10);
			$pages = $this->friend_db->pages;
			foreach($friendids as $k=>$v) {
				$friendlist[$k]['friendid'] = $v['friendid'];
				$friendlist[$k]['avatar'] = $this->client->ps_getavatar($v['phpssouid']);
				$friendlist[$k]['is'] = $v['is'];
			}
			include template('member', 'friend_list');
		}
	}
	
	//网站信息统计
	public function info_tongji(){
		
		$groupid = $this->memberinfo["groupid"];
		$area = $this->memberinfo["area"];
		//如果是区县和园区用户则只统计该区域数据
		if($groupid==13 || $groupid==14){
			
			if(!empty($area)){
				
				/**企业信息**/
				$member_ruzhu=$this->db->count(array('groupid'=>12,'area'=>$area));	//入住
				$member_shim=$this->db->count(array('groupid'=>12,'status' =>'99','area'=>$area));//实名
				$member_check=$member_ruzhu-$member_shim;//待审核
				/***项目信息**/
				$sql = "select count(*) as num from gxw_project p inner join gxw_member m on p.username=m.username where m.area=$area";
				$rs = $this->db->query($sql);
				$project_num = $this->db->fetch_next();
				$project_num = $project_num['num'];//总项目数
				
				$sql = "select count(*) as num from gxw_project p inner join gxw_member m on p.username=m.username where m.area=$area and p.status=99";
				$rs = $this->db->query($sql);
				$project_tg = $this->db->fetch_next();
				$project_tg = $project_tg['num'];//已通过				
				
				$sql = "select count(*) as num from gxw_project p inner join gxw_member m on p.username=m.username where m.area=$area and p.status=0";
				$rs = $this->db->query($sql);
				$project_submit = $this->db->fetch_next();
				$project_submit = $project_submit['num'];//等待提交

				/**产品信息**/
				$sql = "select count(*) as num from gxw_products p inner join gxw_member m on p.username=m.username where m.area=$area and p.status=99";
				$rs = $this->db->query($sql);
				$products_num = $this->db->fetch_next();
				$products_num = $products_num['num'];//已入库产品数
			
			}
		}else{
			/**企业信息**/
			$member_ruzhu=$this->db->count(array('groupid'=>12));	//入住
			$member_shim=$this->db->count(array('groupid'=>12,'status' =>'99'));//实名
			$member_check=$member_ruzhu-$member_shim;//待审核			
			/**企业信息**/

			$member_ruzhu=$this->db->count(array('groupid'=>12));	//入住
			$member_shim=$this->db->count(array('groupid'=>12,'status' =>'99'));//实名
			$member_check=$member_ruzhu-$member_shim;//待审核
			
			/***项目信息**/
			$this->db->setTableName("gxw_project");
			$project_num=$this->db->count(array());	//总项目数
			$project_tg=$this->db->count(array("status"=>"99"));	//已通过
			$project_submit=$this->db->count(array("status"=>"0"));	//等待提交
						
			/**产品信息**/

			$sql = "select count(*) as num from gxw_products p inner join gxw_member m on p.username=m.username where p.status=99";
			$rs = $this->db->query($sql);
			$products_num = $this->db->fetch_next();
			$products_num = $products_num['num'];//已入库产品数
		
		}
		/**产业园**/
		$this->db->setTableName("gxw_linkage");
		$cyy_num=$this->db->count(array('keyid'=>'3360'));	//总产业园
		$sql=" select count(*) num,basic_industrys,l.`name` ".
				" from gxw_member_info m ".
				" inner join gxw_linkage l on l.keyid='3387'  and m.basic_industrys=l.linkageid".
				" group by basic_industrys order by num desc";
		//echo $sql;
		$this->db->query($sql);
		$member_count=array();
		$lists=$this->db->fetch_array();
	
		$ohter=array('num' => '','name'=>'其他','basic_industrys'=>'');
		$num=0;
		/**前5名显示具体类别**/
		foreach ($lists as $k =>$v){
			if($k < 5){
				$member_count[]=$v;
			}else{
				//剩下的为其他
				$num+=$v['num'];
			}
		}
		$ohter['num']=$num;
		$member_count[]=$ohter;
	
	
		include template('member','tongji');
	}	
	/**
	 * 积分兑换
	 */
	public function change_credit() {
		$memberinfo = $this->memberinfo;
		//加载用户模块配置
		$member_setting = getcache('member_setting');
		$this->_init_phpsso();
		$setting = $this->client->ps_getcreditlist();
		$outcredit = unserialize($setting);
		$setting = $this->client->ps_getapplist();
		$applist = unserialize($setting);
		
		if(isset($_POST['dosubmit'])) {
			//本系统积分兑换数
			$fromvalue = intval($_POST['fromvalue']);
			//本系统积分类型
			$from = $_POST['from'];
			$toappid_to = explode('_', $_POST['to']);
			//目标系统appid
			$toappid = $toappid_to[0];
			//目标系统积分类型
			$to = $toappid_to[1];
			if($from == 1) {
				if($memberinfo['point'] < $fromvalue) {
					showmessage(L('need_more_point'), HTTP_REFERER);
				}
			} elseif($from == 2) {
				if($memberinfo['amount'] < $fromvalue) {
					showmessage(L('need_more_amount'), HTTP_REFERER);
				}
			} else {
				showmessage(L('credit_setting_error'), HTTP_REFERER);
			}

			$status = $this->client->ps_changecredit($memberinfo['phpssouid'], $from, $toappid, $to, $fromvalue);
			if($status == 1) {
				if($from == 1) {
					$this->db->update(array('point'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
				} elseif($from == 2) {
					$this->db->update(array('amount'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
				}
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} elseif(isset($_POST['buy'])) {
			if(!is_numeric($_POST['money']) || $_POST['money'] < 0) {
				showmessage(L('money_error'), HTTP_REFERER);
			} else {
				$money = intval($_POST['money']);
			}
			
			if($memberinfo['amount'] < $money) {
				showmessage(L('short_of_money'), HTTP_REFERER);
			}
			//此处比率读取用户配置
			$point = $money*$member_setting['rmb_point_rate'];
			$this->db->update(array('point'=>"+=$point"), array('userid'=>$memberinfo['userid']));
			//加入消费记录，同时扣除金钱
			pc_base::load_app_class('spend','pay',0);
			spend::amount($money, L('buy_point'), $memberinfo['userid'], $memberinfo['username']);
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$credit_list = pc_base::load_config('credit');
			
			include template('member', 'change_credit');
		}
	}
	
	//mini登陆条
	public function mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		
		$snda_enable = pc_base::load_config('system', 'snda_enable');
		include template('member', 'mini');
	}
	
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
	protected function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	private function _session_start() {
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		pc_base::load_sys_class($session_storage);
	}
	
	/*
	 * 通过linkageid获取名字路径
	 */
	protected function _get_linkage_fullname($linkageid,  $linkagelist) {
		$fullname = '';
		if($linkagelist['data'][$linkageid]['parentid'] != 0) {
			$fullname = $this->_get_linkage_fullname($linkagelist['data'][$linkageid]['parentid'], $linkagelist);
		}
		//所在地区名称
		$return = $fullname.$linkagelist['data'][$linkageid]['name'].'>';
		return $return;
	}
	
	/**
	 *根据积分算出用户组
	 * @param $point int 积分数
	 */
	protected function _get_usergroup_bypoint($point=0) {
		$groupid = 2;
		if(empty($point)) {
			$member_setting = getcache('member_setting');
			$point = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		}
		$grouplist = getcache('grouplist');
		
		foreach ($grouplist as $k=>$v) {
			$grouppointlist[$k] = $v['point'];
		}
		arsort($grouppointlist);

		//如果超出用户组积分设置则为积分最高的用户组
		if($point > max($grouppointlist)) {
			$groupid = key($grouppointlist);
		} else {
			foreach ($grouppointlist as $k=>$v) {
				if($point >= $v) {
					$groupid = $tmp_k;
					break;
				}
				$tmp_k = $k;
			}
		}
		return $groupid;
	}
				
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return $status {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
		$username = safe_replace($username);
		//首先判断企业审核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('username'=>$username))) {
			exit('0');
		}
	
		$this->_init_phpsso();
		$status = $this->client->ps_checkname($username);
			
		if($status == -4 || $status == -1) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * 检查用户企业名称
	 * @param string $nickname	企业名称
	 * @return $status {0:已存在;1:成功}
	 */
	public function public_checknickname_ajax() {
		$nickname = isset($_GET['nickname']) && trim($_GET['nickname']) ? trim($_GET['nickname']) : exit('0');
		if(CHARSET != 'utf-8') {
			$nickname = iconv('utf-8', CHARSET, $nickname);
			$nickname = addslashes($nickname);
		} 
		//首先判断企业审核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('nickname'=>$nickname))) {
			exit('0');
		}
		if(isset($_GET['userid'])) {
			$userid = intval($_GET['userid']);
			//如果是企业修改，而且NICKNAME和原来优质一致返回1，否则返回0
			$info = get_memberinfo($userid);
			if($info['nickname'] == $nickname){//未改变
				exit('1');
			}else{//已改变，判断是否已有此名
				$where = array('nickname'=>$nickname);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		} else {
			$where = array('nickname'=>$nickname);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		} 
	}
	
	/**
	 * 检查邮箱
	 * @param string $email
	 * @return $status {-1:email已经存在 ;-5:邮箱禁止注册;1:成功}
	 */
	public function public_checkemail_ajax() {
		$this->_init_phpsso();
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//禁止注册
			exit('0');
		} elseif($status == -1) {	//用户名已存在，但是修改用户的时候需要判断邮箱是否是当前用户的
			if(isset($_GET['phpssouid'])) {	//修改用户传入phpssouid
				$status = $this->client->ps_get_member_info($email, 3);
				if($status) {
					$status = unserialize($status);	//接口返回序列化，进行判断
					if (isset($status['uid']) && $status['uid'] == intval($_GET['phpssouid'])) {
						exit('1');
					} else {
						exit('0');
					}
				} else {
					exit('0');
				}
			} else {
				exit('0');
			}
		} else {
			exit('1');
		}
	}
	
	public function public_sina_login() {
		define('WB_AKEY', pc_base::load_config('system', 'sina_akey'));
		define('WB_SKEY', pc_base::load_config('system', 'sina_skey'));
		define('WEB_CALLBACK', APP_PATH.'index.php?m=member&c=index&a=public_sina_login&callback=1');
		pc_base::load_app_class('saetv2.ex', '' ,0);
		$this->_session_start();
					
		if(isset($_GET['callback']) && trim($_GET['callback'])) {
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			if (isset($_REQUEST['code'])) {
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = WEB_CALLBACK;
				try {
					$token = $o->getAccessToken('code', $keys);
				} catch (OAuthException $e) {
				}
			}
			if ($token) {
				$_SESSION['token'] = $token;
			}
			$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token'] );
			$ms  = $c->home_timeline(); // done
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$me = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			if(CHARSET != 'utf-8') {
				$me['name'] = iconv('utf-8', CHARSET, $me['name']);
				$me['location'] = iconv('utf-8', CHARSET, $me['location']);
				$me['description'] = iconv('utf-8', CHARSET, $me['description']);
				$me['screen_name'] = iconv('utf-8', CHARSET, $me['screen_name']);
			}
			if(!empty($me['id'])) {
 				//检查connect企业是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$me['id'], 'from'=>'sina');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r)) {
					//读取本站用户信息，执行登录操作
					
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$gxw_auth = sys_auth($userid."\t".$password, 'ENCODE', $gxw_auth_key);
					
					param::set_cookie('auth', $gxw_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_status', $status, $cookietime);
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success').$synloginstr, $forward);
					
				} else {
 					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $me['id'];
					$_SESSION['from'] = 'sina';
					$connect_username = $me['name'];
					
					//加载用户模块配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
					}
					
					//获取用户siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//过滤非当前站点企业模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}
					
					$modelid = 10; //设定默认值
					if(array_key_exists($modelid, $modellist)) {
						//获取企业模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}
					include template('member', 'connect');
				}
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}
		} else {
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			$aurl = $o->getAuthorizeURL(WEB_CALLBACK);
			include template('member', 'connect_sina');
		}
	}
	
	/**
	 * 盛大通行证登陆
	 */
	public function public_snda_login() {
		define('SNDA_AKEY', pc_base::load_config('system', 'snda_akey'));
		define('SNDA_SKEY', pc_base::load_config('system', 'snda_skey'));
		define('SNDA_CALLBACK', urlencode(APP_PATH.'index.php?m=member&c=index&a=public_snda_login&callback=1'));
		
		pc_base::load_app_class('OauthSDK', '' ,0);
		$this->_session_start();		
		if(isset($_GET['callback']) && trim($_GET['callback'])) {
					
			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$code = $_REQUEST['code'];
			$accesstoken = $o->getAccessToken($code);
		
			if(is_numeric($accesstoken['sdid'])) {
				$userid = $accesstoken['sdid'];
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}

			if(!empty($userid)) {
				
				//检查connect企业是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$userid, 'from'=>'snda');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r)) {
					//读取本站用户信息，执行登录操作
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$gxw_auth = sys_auth($userid."\t".$password, 'ENCODE', $gxw_auth_key);
					
					param::set_cookie('auth', $gxw_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_status', $status, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success').$synloginstr, $forward);
				} else {				
					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $userid;
					$_SESSION['from'] = 'snda';
					$connect_username = $userid;
					include template('member', 'connect');
				}
			}	
		} else {
			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$accesstoken = $o->getSystemToken();		
			$aurl = $o->getAuthorizeURL();
			
			include template('member', 'connect_snda');
		}
		
	}
	
	
	/**
	 * QQ号码登录
	 * 该函数为QQ登录回调地址
	 */
	public function public_qq_loginnew(){
                $appid = pc_base::load_config('system', 'qq_appid');
                $appkey = pc_base::load_config('system', 'qq_appkey');
                $callback = pc_base::load_config('system', 'qq_callback');
                pc_base::load_app_class('qqapi','',0);
                $info = new qqapi($appid,$appkey,$callback);
                $this->_session_start();
                if(!isset($_GET['code'])){
                         $info->redirect_to_login();
                }else{
					$code = $_GET['code'];
					$openid = $_SESSION['openid'] = $info->get_openid($code);
					if(!empty($openid)){
						$r = $this->db->get_one(array('connectid'=>$openid,'from'=>'qq'));
						
						 if(!empty($r)){
								//QQ已存在于数据库，则直接转向登陆操作
								$password = $r['password'];
								$this->_init_phpsso();
								$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
								$userid = $r['userid'];
								$groupid = $r['groupid'];
								$username = $r['username'];
								$nickname = empty($r['nickname']) ? $username : $r['nickname'];
								$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
								if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
								$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
								$cookietime = $_cookietime ? TIME + $_cookietime : 0;
								$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
								$gxw_auth = sys_auth($userid."\t".$password, 'ENCODE', $gxw_auth_key);
								param::set_cookie('auth', $gxw_auth, $cookietime);
								param::set_cookie('_userid', $userid, $cookietime);
								param::set_cookie('_username', $username, $cookietime);
								param::set_cookie('_groupid', $groupid, $cookietime);
								param::set_cookie('cookietime', $_cookietime, $cookietime);
								param::set_cookie('_nickname', $nickname, $cookietime);
								$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
								showmessage(L('login_success').$synloginstr, $forward);
						}else{	
								//未存在于数据库中，跳去完善资料页面。页面预置用户名（QQ返回是UTF8编码，如有需要进行转码）
								$user = $info->get_user_info();
 								$_SESSION['connectid'] = $openid;
								$_SESSION['from'] = 'qq';
								if(CHARSET != 'utf-8') {//转编码
									$connect_username = iconv('utf-8', CHARSET, $user['nickname']); 
								} else {
									 $connect_username = $user['nickname']; 
								}
 								include template('member', 'connect');
						}
					}
                }
    }
	
	/**
	 * QQ微博登录
	 */
	public function public_qq_login() {
		define('QQ_AKEY', pc_base::load_config('system', 'qq_akey'));
		define('QQ_SKEY', pc_base::load_config('system', 'qq_skey'));
		pc_base::load_app_class('qqoauth', '' ,0);
		$this->_session_start();
		if(isset($_GET['callback']) && trim($_GET['callback'])) {
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY, $_SESSION['keys']['oauth_token'], $_SESSION['keys']['oauth_token_secret']);
			$_SESSION['last_key'] = $o->getAccessToken($_REQUEST['oauth_verifier']);
			
			if(!empty($_SESSION['last_key']['name'])) {
				//检查connect企业是否绑定，已绑定直接登录，未绑定提示注册/绑定页面
				$where = array('connectid'=>$_REQUEST['openid'], 'from'=>'qq');
				$r = $this->db->get_one($where);
				
				//connect用户已经绑定本站用户
				if(!empty($r)) {
					//读取本站用户信息，执行登录操作
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					
					$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$gxw_auth = sys_auth($userid."\t".$password, 'ENCODE', $gxw_auth_key);
					
					param::set_cookie('auth', $gxw_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success').$synloginstr, $forward);
				} else {				
					//弹出绑定注册页面
					$_SESSION = array();
					$_SESSION['connectid'] = $_REQUEST['openid'];
					$_SESSION['from'] = 'qq';
					$connect_username = $_SESSION['last_key']['name'];

					//加载用户模块配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
					}
					
					//获取用户siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//过滤非当前站点企业模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}
					
					$modelid = 10; //设定默认值
					if(array_key_exists($modelid, $modellist)) {
						//获取企业模型表单
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//万能字段过滤
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}
						
						$formValidator = $member_form->formValidator;
					}	
					include template('member', 'connect');
				}
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}
		} else {
			$oauth_callback = APP_PATH.'index.php?m=member&c=index&a=public_qq_login&callback=1';
			$oauth_nonce = md5(SYS_TIME);
			$oauth_signature_method = 'HMAC-SHA1';
			$oauth_timestamp = SYS_TIME;
			$oauth_version = '1.0';

			$url = "https://open.t.qq.com/cgi-bin/request_token?oauth_callback=$oauth_callback&oauth_consumer_key=".QQ_AKEY."&oauth_nonce=$oauth_nonce&oauth_signature=".QQ_SKEY."&oauth_signature_method=HMAC-SHA1&oauth_timestamp=$oauth_timestamp&oauth_version=$oauth_version"; 
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY);
			
			$keys = $o->getRequestToken(array('callback'=>$oauth_callback));
			$_SESSION['keys'] = $keys;
			$aurl = $o->getAuthorizeURL($keys['oauth_token'] ,false , $oauth_callback);
			
			include template('member', 'connect_qq');	
		}

	}

	/**
	 * 找回密码
	 * 新增加短信找回方式 
	 */
	public function public_forget_password () {
		
		$email_config = getcache('common', 'commons');
		
		//SMTP MAIL 二种发送模式
 		if($email_config['mail_type'] == '1'){
			if(empty($email_config['mail_user']) || empty($email_config['mail_password'])) {
				showmessage(L('email_config_empty'), HTTP_REFERER);
			}
		}
		$this->_session_start();
		$member_setting = getcache('member_setting');
		if(isset($_POST['dosubmit'])) {
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			
			$memberinfo = $this->db->get_one(array('email'=>$_POST['email']));
			if(!empty($memberinfo['email'])) {
				$email = $memberinfo['email'];
			} else {
				showmessage(L('email_error'), HTTP_REFERER);
			}
			
			pc_base::load_sys_func('mail');
			$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key'));

			$code = sys_auth($memberinfo['userid']."\t".SYS_TIME, 'ENCODE', $gxw_auth_key);

			$url = APP_PATH."index.php?m=member&c=index&a=public_forget_password&code=$code";
			$message = $member_setting['forgetpassword'];
			$message = str_replace(array('{click}','{url}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url), $message);
			//获取站点名称
			$sitelist = getcache('sitelist', 'commons');
			
			if(isset($sitelist[$memberinfo['siteid']]['name'])) {
				$sitename = $sitelist[$memberinfo['siteid']]['name'];
			} else {
				$sitename = 'gxw_V9_MAIL';
			}
			sendmail($email, L('forgetpassword'), $message, '', '', $sitename);
			showmessage(L('operation_success'), 'index.php?m=member&c=index&a=login');
		} elseif($_GET['code']) {
			$gxw_auth_key = md5(pc_base::load_config('system', 'auth_key'));
			$hour = date('y-m-d h', SYS_TIME);
			$code = sys_auth($_GET['code'], 'DECODE', $gxw_auth_key);
			$code = explode("\t", $code);

			if(is_array($code) && is_numeric($code[0]) && date('y-m-d h', SYS_TIME) == date('y-m-d h', $code[1])) {
				$memberinfo = $this->db->get_one(array('userid'=>$code[0]));
				
				if(empty($memberinfo['phpssouid'])) {
					showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
				}
				$updateinfo = array();
				$password = random(8,"23456789abcdefghkmnrstwxy");
				$updateinfo['password'] = password($password, $memberinfo['encrypt']);
				
				$this->db->update($updateinfo, array('userid'=>$code[0]));
				if(pc_base::load_config('system', 'phpsso')) {
					//初始化phpsso
					$this->_init_phpsso();
					$this->client->ps_member_edit('', $email, '', $password, $memberinfo['phpssouid'], $memberinfo['encrypt']);
				}
				$email = $memberinfo['email'];
				//获取站点名称
				$sitelist = getcache('sitelist', 'commons');		
				if(isset($sitelist[$memberinfo['siteid']]['name'])) {
					$sitename = $sitelist[$memberinfo['siteid']]['name'];
				} else {
					$sitename = 'gxw_V9_MAIL';
				}
				pc_base::load_sys_func('mail');
				sendmail($email, L('forgetpassword'), "New password:".$password, '', '', $sitename);
				showmessage(L('operation_success').L('newpassword').':'.$password);

			} else {
				showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
			}

		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
			
			include template('member', 'forget_password');
		}
	}
	
	/**
	*通过手机修改密码
	*方式：用户发送HHPWD afei985#821008 至 1065788 ，gxw进行转发到网站运营者指定的回调地址，在回调地址程序进行密码修改等操作,处理成功时给用户发条短信确认。
	*gxw 以POST方式传递相关数据到回调程序中
	*要求：网站中企业系统，mobile做为主表字段，并且唯一（如已经有手机号码，把号码字段转为主表字段中）
	*/
	
	public function public_changepwd_bymobile(){
		$phone = $_REQUEST['phone'];
		$msg = $_REQUEST['msg'];
		$sms_key = $_REQUEST['sms_passwd'];
		$sms_pid = $_REQUEST['sms_pid'];
		if(empty($phone) || empty($msg) || empty($sms_key) || empty($sms_pid)){
			return false;
		}
		if(!preg_match('/^1([0-9]{9})/',$phone)) {
			return false;
		}
		//判断是否gxw请求的接口
		pc_base::load_app_func('global','sms');
		pc_base::load_app_class('smsapi', 'sms', 0);
		$this->sms_setting_arr = getcache('sms');
		$siteid = $_REQUEST['siteid'] ? $_REQUEST['siteid'] : 1;
		if(!empty($this->sms_setting_arr[$siteid])) {
			$this->sms_setting = $this->sms_setting_arr[$siteid];
		} else {
			$this->sms_setting = array('userid'=>'', 'productid'=>'', 'sms_key'=>'');
		}
		if($sms_key != $this->sms_setting['sms_key'] || $sms_pid != $this->sms_setting['productid']){
			return false;
		}
		//取用户名
		$msg_array = explode("@@",$str);
		$newpwd = $msg_array[1];
		$username = $msg_array[2];
		$array = $this->db->get_one(array('mobile'=>$phone,'username'=>$username));
		if(empty($array)){
			echo 1;
		}else{
			$result = $this->db->update(array('password'=>$newpwd),array('mobile'=>$phone,'username'=>$username));
			if($result){
				//修改成功，发送短信给用户回执
 				//检查短信余额
				if($this->sms_setting['sms_key']) {
					$smsinfo = $this->smsapi->get_smsinfo();
				}
				if($smsinfo['surplus'] < 1) {
 					echo 1;
				}else{
 					$this->smsapi = new smsapi($this->sms_setting['userid'], $this->sms_setting['productid'], $this->sms_setting['sms_key']);
					$content = '你好,'.$username.',你的新密码已经修改成功：'.$newpwd.' ,请妥善保存！';
					$return = $this->smsapi->send_sms($phone, $content, SYS_TIME, CHARSET);
					echo 1;
				}
 			}
		}
	}
	
	/**
	 * 手机短信方式找回密码
	 */
	public function public_forget_password_mobile () {
		$step = intval($_POST['step']);
		$step = max($step,1);
		$this->_session_start();
		
		if(isset($_POST['dosubmit']) && $step==2) {
		//处理提交申请，以手机号为准
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			$username = safe_replace($_POST['username']);

			$r = $this->db->get_one(array('username'=>$username),'userid,mobile');
			if($r['mobile']=='') {
				$_SESSION['mobile'] = '';
				$_SESSION['userid'] = '';
				$_SESSION['code'] = '';
				showmessage("该账号没有绑定手机号码，请选择其他方式找回！");
			}
			$_SESSION['mobile'] = $r['mobile'];
			$_SESSION['userid'] = $r['userid'];
			include template('member', 'forget_password_mobile');
		} elseif(isset($_POST['dosubmit']) && $step==3) {
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$mobile = $_SESSION['mobile'];
			if($mobile){
				if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
				pc_base::load_app_func('global','sms');
				$posttime = SYS_TIME-600;
				$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
				if($r && $r['id_code']==$mobile_verify) {
					$sms_report_db->update(array('id_code'=>''),$where);
					$userid = $_SESSION['userid'];
					$updateinfo = array();
					$password = random(8,"23456789abcdefghkmnrstwxy");
					$encrypt = random(6,"23456789abcdefghkmnrstwxyABCDEFGHKMNRSTWXY");
					$updateinfo['encrypt'] = $encrypt;
					$updateinfo['password'] = password($password, $encrypt);
					
					$this->db->update($updateinfo, array('userid'=>$userid));
					$rs = $this->db->get_one(array('userid'=>$userid),'phpssouid');
					if(pc_base::load_config('system', 'phpsso')) {
						//初始化phpsso
						$this->_init_phpsso();
						$this->client->ps_member_edit('', '', '', $password, $rs['phpssouid'], $encrypt);
					}
					$status = sendsms($mobile, $password, 5);
					if($status!==0) showmessage($status);
					$_SESSION['mobile'] = '';
					$_SESSION['userid'] = '';
					$_SESSION['code'] = '';
					showmessage("密码已重置成功！请查收手机",'?m=member&c=index&a=login');
				} else {
					showmessage("短信验证码错误！请重新获取！");
				}
			}else{
				showmessage("短信验证码已过期！请重新获取！");
			}
		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
 			include template('member', 'forget_password_mobile');
		}
	}
	//通过用户名找回密码
	public function public_forget_password_username() {
		$step = intval($_POST['step']);
		$step = max($step,1);
		$this->_session_start();
		
		if(isset($_POST['dosubmit']) && $step==2) {
		//处理提交申请，以手机号为准
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			$username = safe_replace($_POST['username']);

			$r = $this->db->get_one(array('username'=>$username),'userid,email');
			if($r['email']=='') {
				$_SESSION['userid'] = '';
				$_SESSION['code'] = '';
				showmessage("该账号没有绑定手机号码，请选择其他方式找回！");
			} else {
				$_SESSION['userid'] = $r['userid'];
				$_SESSION['email'] = $r['email'];
			}
			$email_arr = explode('@',$r['email']);
			include template('member', 'forget_password_username');
		} elseif(isset($_POST['dosubmit']) && $step==3) {
			$sms_report_db = pc_base::load_model('sms_report_model');
			$mobile_verify = $_POST['mobile_verify'];
			$email = $_SESSION['email'];
			if($email){
				if(!preg_match('/^([a-z0-9_]+)@([a-z0-9_]+).([a-z]{2,6})$/',$email)) exit('check email error');
				if($_SESSION['emc_times']=='' || $_SESSION['emc_times']<=0){
					showmessage("验证次数超过5次,验证码失效，请重新获取邮箱验证码！",HTTP_REFERER,3000);
				}
				$_SESSION['emc_times'] = $_SESSION['emc_times']-1;
				if($_SESSION['emc']!='' && $_POST['email_verify']==$_SESSION['emc']) {
					
					$userid = $_SESSION['userid'];
					$updateinfo = array();
					$password = random(8,"23456789abcdefghkmnrstwxy");
					$encrypt = random(6,"23456789abcdefghkmnrstwxyABCDEFGHKMNRSTWXY");
					$updateinfo['encrypt'] = $encrypt;
					$updateinfo['password'] = password($password, $encrypt);
					
					$this->db->update($updateinfo, array('userid'=>$userid));
					$rs = $this->db->get_one(array('userid'=>$userid),'phpssouid');
					if(pc_base::load_config('system', 'phpsso')) {
						//初始化phpsso
						$this->_init_phpsso();
						$this->client->ps_member_edit('', '', '', $password, $rs['phpssouid'], $encrypt);
					}
					$_SESSION['email'] = '';
					$_SESSION['userid'] = '';
					$_SESSION['emc'] = '';
					$_SESSION['code'] = '';
					pc_base::load_sys_func('mail');
					sendmail($email, '密码重置通知', "您在".date('Y-m-d H:i:s')."通过密码找回功能，重置了本站密码。");
					include template('member', 'forget_password_username');
					exit;
				} else {
					showmessage("验证码错误！请重新获取！",HTTP_REFERER,3000);
				}
			} else {
				showmessage("非法请求！");
			}
		} else {
 			include template('member', 'forget_password_username');
		}
	}

	//邮箱获取验证码
	public function public_get_email_verify() {
		pc_base::load_sys_func('mail');
		$this->_session_start();
		$code = $_SESSION['emc'] = random(8,"23456789abcdefghkmnrstwxy");
		$_SESSION['emc_times']=5;
		$message = '您的验证码为：'.$code;

		sendmail($_SESSION['email'], '邮箱找回密码验证', $message);
		echo '1';
	}
	
	public function addContent(){
		//TODO 
		$siteids = getcache ( 'category_content', 'commons' );
		$catid = intval ( $_POST ['content'] ['catid'] );
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
		$content = array ();
		foreach ( $_POST ['content'] as $_k => $_v ) {
			if ($_k == 'content') {
				$content [$_k] = remove_xss ( strip_tags ( $_v, '<p><a><br><img><ul><li><div>' ) );
			} elseif (in_array ( $_k, $fields )) {
				$content [$_k] = new_html_special_chars ( trim_script ( $_v ) );
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
		$post_fields = array_keys ( $_POST ['content'] );
		$post_fields = array_intersect_assoc ( $fields, $post_fields );
		$setting = string2array ( $category ['setting'] );
		if ($setting ['presentpoint'] < 0 && $membercontent ['point'] < abs ( $setting ['presentpoint'] ))
			showmessage ( L ( 'points_less_than', array (
					'point' => $membercontent ['point'],
					'need_point' => abs ( $setting ['presentpoint'] )
			) ), APP_PATH . 'index.php?m=pay&c=deposit&a=pay&exchange=point', 3000 );
	
			// 判断企业组录入是否需要审核
			if ($grouplist [$membercontent ['groupid']] ['allowpostverify'] || ! $setting ['workflowid']) {
				$content ['status'] = 99;
			} else {
				$content ['status'] = - 2;
			}
			$content ['username'] = $membercontent ['username'];
			if (isset ( $content ['title'] ))
				$content ['title'] = safe_replace ( $content ['title'] );
			$this->content_db->siteid = $siteid;
	
			$id = $this->content_db->add_content ( $content );
	}
	
	
	public function getContent(){
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
			/* if($r['status']==99) showmessage(L('has_been_verified')); */
			$this->content_db->table_name = $this->content_db->table_name . '_data';
			$r2 = $this->content_db->get_one ( array (
					'id' => $id
			) );
			
			$data = array_merge ( $r, $r2 );
			print_r($data);
			/*require CACHE_MODEL_PATH . 'content_form.class.php';
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
			$formValidator = $content_form->formValidator;
				
			include template ( 'member', 'content_publish' );*/
		}
		
	}
	//获取企业信息，导出至excel表
	function member_excel(){
		
		$groupid = $this->memberinfo['groupid'];
		$excel = new PHPExcel();
		if(!empty($_POST)){
			//$s = $_POST['s'];
			//$fields = 'i.'.implode(',i.',explode('|',$s));
			//echo $field;die;
			$s = $_POST['fields'];
			foreach($s as $v){
				$sql = "select name from gxw_model_field where field='$v'";
				$model_result=$this->db->query($sql);
				$arr = $this->db->fetch_next($model_result);
				//print_r($arr);die;
				$name[] = $arr['name'];
			}
			//var_dump($name);die;
			$fields = 'i.'.implode(',i.',$s);
			
		}else{	
			//获取企业模型字段信息
			$sql = "select field,name from gxw_model_field where modelid=12 and disabled=0 and formtype!='image' and formtype!='images' order by listorder asc";
			$model_result = $this->db->query($sql);
		
			$model_fields = $this->db->fetch_array($model_result);//
			foreach($model_fields as $v){
				$field[] = $v['field'];//要查询字段
				$name[] = $v['name'];//要查询字段中文名称    作为excel表头
			}
			$fields = 'i.'.implode(",i.",$field);
		}
		//$fields = 'i.'.implode(",i.",$field);
		//获取企业数据  注：筛选条件 根据当前用户组id  园区和区县用户取出该区域的用户 ，企业用户只取出该企业信息，gxw用户则取出所有企业信息
		if($groupid>12 && $groupid<15){
			if(!empty($this->memberinfo['area'])){
				$area = $this->memberinfo['area'];
			}
			$sql = "select m.nickname,m.area,{$fields} from gxw_member m left join gxw_member_info i on m.userid=i.userid where m.area={$area}";
		}else if($groupid==12){
			$sql = "select m.nickname,m.area,{$fields} from gxw_member m left join gxw_member_info i on m.userid=i.userid where m.userid={$this->memberinfo['userid']}";
		}else if($groupid==15){
			$sql = "select m.nickname,m.area,{$fields} from gxw_member m left join gxw_member_info i on m.userid=i.userid";
		}
		$com_result = $this->db->query($sql);
		$num_fields = mysql_num_fields($com_result);
		$data = $this->db->fetch_array($com_result);
		//获取列数，计算出excel表 列标识显示
	
	
		//如果查询字段大于26，则在列前拼接字符A  注：因为excel表列是从A-Z显示的，如果超出，则后面是AA-AZ显示
		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		if($num_fields>26 && $num_fields<=52){
			$extra = $num_fields-26;
			for($i=0;$i<=$extra;$i++){
				array_push($letter,"A".$letter[$i]);
			}
		}
		//var_dump($name);var_dump($letter);die;
		//获取企业模型所有字段（主要获取其中文名称作为excel表头）
	
		$tableheader=array('企业名称','所属区域');
		$tableheader = array_merge($tableheader,$name);
		//var_dump($tableheader);die;
		//填充excel表头信息
		for($i = 0;$i < count($tableheader);$i++) {
			$excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
		}
	
		//填充表格信息
		for ($i = 2;$i <= count($data) + 1;$i++) {
			$j = 0;
			foreach ($data[$i - 2] as $key=>$value) {
				if($key=='area'){
					//查询企业所属区域    注：只能获取后一个select下拉框的值，为获得完整区域名称，查询了2次
					if(!empty($value)){
						$sql1="select name,parentid from gxw_linkage where linkageid=$value";
						$rs1 = $this->db->query($sql1);
						$arr1 = mysql_fetch_assoc($rs1);
						$val1 = $arr1['name'];
						$sql2 ="select name from gxw_linkage where linkageid={$arr1['parentid']}";
						$rs2 = $this->db->query($sql2);
						$arr2 = mysql_fetch_assoc($rs2);
						$val2 = $arr2['name'];
						$value = $val2.$val1;
					}
				}else if($key=='basic_industrys'){
					//查询企业所属产业
					if(!empty($value)){
						$sql = "select name from gxw_linkage where linkageid=$value";
						$rs = $this->db->query($sql);
						$arr = mysql_fetch_assoc($rs);
						$value = $arr['name'];
					}
				}else if($key=='kej_isyuans'){
					//是否设有院士工作站  1 是  2否
					if($value==1){
						$value="是";
					}else if($value==2){
						$value="否";
					}
				}else if($key=='kej_isbs'){
					//是否设有博士工作站  1 是  2否
					if($value==1){
						$value="是";
					}else if($value==2){
						$value="否";
					}
				}else if($key=='kej_center'){
					//是否设有企业技术中心
					if($value==0){
						$value="无";
					}else if($value==1){
						$value="国家级";
					}else if($value==2){
						$value="省级";
					}else if($value==3){
						$value="市级";
					}
				}
				if($key=="nickname"){
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth(40);
				}else if($key=="basic_reg_addr"){
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth(44);
				}else{
					$td = strlen($value);
					$th = strlen($tableheader[$j]);
					if($td<$th){
						$width = $th;
					}else{
						$width = $td;
					}					
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth($width);
				}
				if(empty($value) || is_numeric($value)){
					$excel->getActiveSheet()->getStyle("$letter[$j]$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
				$excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
				
				$j++;
			}
		}
		//$excel->getActiveSheet()->getColumnDimension("A")->setWidth(36);
		
		//创建Excel输入对象
		$write = new PHPExcel_Writer_Excel5($excel);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="企业信息表.xls"');
		header("Content-Transfer-Encoding:binary");
		$write->save('php://output');
	}
	//获取项目信息，导出至excel表
	public function project_excel(){
		$groupid = $this->memberinfo['groupid'];
		$excel = new PHPExcel();
	
		//在模型字段表中查找需要在excel表显示的项目字段信息（主要获取其中文名称作为excel表头）        isadd表示字段是否在前台录入
		$sql = "select field,name from gxw_model_field where modelid=14 and disabled=0 and isadd=1 and formtype!='image' and formtype!='images' and field!='catid' order by listorder asc";
		$model_result = $this->db->query($sql);
		$fields = array();//存储表字段名称
		$names = array();//存储字段中文名称
		while($row=mysql_fetch_assoc($model_result)){
			$fields[] = $row['field'];//把所有字段存储在$fields数据里
			$names[] = $row['name'];//把字段值存储在另一数组里
		}
		//拼接所需要查询的字段数组$fields 作为字符串放入 sql语句查询
		$p_table = $this->db->get_fields("project");//主表字段信息
		$s_table = $this->db->get_fields('project_data');//附表字段信息
		//字段在主表的，加上前缀p.  在附表的加上前缀d.  为了拼接sql左连接用的
		foreach($fields as $k=>$v){
			if(array_key_exists($v, $p_table)){
				$fields[$k] = 'p.'.$v;
			}else if(array_key_exists($v, $s_table)){
				$fields[$k] = 'd.'.$v;
			}
		}
		$fields = implode(",", $fields);//用逗号把数组拼成字符串
		//var_dump($fields);die;
	
		//获取所有项目信息  注：根据当前用户的用户组id 判断是 园区或区县用户 ，企业用户，gxw用户
		//$sql="select m.nickname,p.title,d.pro_addr,d.pro_fund,p.pro_type,p.cy_type,d.pro_nature,d.pro_content,d.contact_name,d.contact_tel,d.taxation_add,d.value_add,d.start_time,d.end_time from gxw_project p left join gxw_project_data d on p.id=d.id left join gxw_member m on p.username=m.username ";
		if($groupid>12 && $groupid<15){
			if(!empty($this->memberinfo['area'])){
				$area = $this->memberinfo['area'];
			}
			$sql="select m.nickname,{$fields} from gxw_project p
			inner join gxw_project_data d on p.id=d.id
			left join gxw_member m on p.username=m.username
			where m.area={$area}";
		}else if($groupid==12){
			$sql="select m.nickname,{$fields} from gxw_project p
			inner join gxw_project_data d on p.id=d.id
			left join gxw_member m on p.username=m.username
			where m.userid={$this->memberinfo['userid']}";
		}else if($groupid==15){
			$sql="select m.nickname,{$fields} from gxw_project p
			inner join gxw_project_data d on p.id=d.id
			left join gxw_member m on p.username=m.username";
		}
	
		$project_result = $this->db->query($sql);
		while($row=mysql_fetch_assoc($project_result)){
			$data[] = $row;
		}

		//获取列数，计算出excel表 列标识显示
		$num_fields = mysql_num_fields($project_result);
		//如果查询字段大于26，则在列前拼接字符A  注：因为excel表列是从A-Z显示的，如果超出，则后面是AA-AZ显示
		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		if($num_fields>26 && $num_fields<=52){
			$extra = $num_fields-26;
			for($i=0;$i<=$extra;$i++){
				array_push($letter,"A".$letter[$i]);
			}
		}

		$tableheader=array("企业名称");
		$tableheader = array_merge($tableheader,$names);

		//var_dump($tableheader);die;
		//填充excel表头信息
		for($i = 0;$i < count($tableheader);$i++) {
		//echo "$letter[$i]1".'--'.$tableheader[$i];
			$excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
		}

		//填充表格信息
		for ($i = 2;$i <= count($data) + 1;$i++) {
			$j = 0;
			foreach ($data[$i - 2] as $key=>$value) {
				if($key=='pro_type'){//查询项目类别名称
					$sql="select name from gxw_linkage where linkageid={$value}";
					$rs = $this->db->query($sql);
					$row = mysql_fetch_row($rs);
					$value = $row[0];
				}
				if($key=='cy_type'){//查询项目产业类别名称
					$sql="select name from gxw_linkage where linkageid={$value}";
					$rs = $this->db->query($sql);
					$row = mysql_fetch_row($rs);
					$value = $row[0];
				}
				if($key=='pro_nature'){//查询项目性质 如 新建 续建...
					$sql="select setting from gxw_model_field where modelid=14 and field='pro_nature'";
					$rs = $this->db->query($sql);
					$row = mysql_fetch_row($rs);
					$arr = string2array($row[0]);//$row[0]因为是字符串，所以用系统函数转换成数组
					$options = $arr['options'];// "新建|1 续建|2 预备|5 其他|6"
				    //var_dump($options);
					$arr = explode("\r\n", $options);//array(4) { [0]=> string(8) "新建|1" [1]=> string(8) "续建|2" [2]=> string(8) "预备|5" [3]=> string(8) "其他|6" }
					foreach($arr as $v){
						$tmp = explode('|', $v);
						if($tmp[1]==$value){
							$value = $tmp[0];
						}
					}
				}
				if($key=="nickname"){
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth(40);
				}else if($key=="title"){
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth(30);
				}else if($key=='pro_addr'){
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth(30);
				}else{
					$td = strlen($value);
					$th = strlen($tableheader[$j]);
					if($td<$th){
						$width = $th;
					}else{
						$width = $td;
					}
					$excel->getActiveSheet()->getColumnDimension("$letter[$j]")->setWidth($width);
				}
				if(empty($value) || is_numeric($value)){
					$excel->getActiveSheet()->getStyle("$letter[$j]$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}				
				$excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
				$j++;
		 	}
		}	
		//创建Excel输入对象
		$write = new PHPExcel_Writer_Excel5($excel);
		header("Pragma: public");
		header("Expires: 0");
		header("Content-Type:text/html;charset=utf-8");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="企业项目信息表.xls"');
		header("Content-Transfer-Encoding:binary");
		$write->save('php://output');
	}
}
?>