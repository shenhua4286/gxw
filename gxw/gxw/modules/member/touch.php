
<?php
/**
 * 数据对接
 */

defined('IN_gxw') or exit('No permission resources.');

pc_base::load_app_class('foreground');

//pc_base::load_app_class('excel');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
class touch extends foreground {

	private $times_db;
	
	function __construct() {
		parent::__construct();
		
		$this->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
		
	}

	public function init() {
		
	}
	
	
	public function main(){
	}
	
	public function loadMenu(){
		
	}
	
  	/**群聊**/
	public function group(){
		
	}
	
	/**获取企业列表数据**/
	function public_lists() {
		//站点信息
		$sitelistarr = getcache('sitelist', 'commons');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '0';
		foreach ($sitelistarr as $k=>$v) {
			$sitelist[$k] = $v['name'];
		}
			$where = '1=1 ';
				
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if($_SESSION['roleid'] == 1) {
				if(!empty($siteid)) {
					$where .= "AND `siteid` = '$siteid'  ";
				}
			} else {
				$siteid = get_siteid();
				$where .= "AND `siteid` = '$siteid'  ";
			}
			
			$where .= "AND `status` = '99'  ";
			$where .= "AND `groupid` = '12'  ";

			$complayName=$_GET['complayName'];
			
			if(isset($complayName)){
				$where .= "AND `nickname` LIKE '%$complayName%'";
			}
			
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 15;
		
		$sql1 = "select  m.userid,m.username,m.nickname complayName,i.* From gxw_member m ".
				"LEFT JOIN gxw_member_info i on m.userid=i.userid ".
				"WHERE " . $where;
		$memberlist = $this->db->mylistinfo ( $sql1, 'm.userid desc', $page,$rows);
		$dataArray=array();
		$dataArray['total']=$this->db->number;
		$dataArray['rows']=$memberlist;
		$pages = $this->db->number;
		$data=json_encode($dataArray);
		echo $data;
		//include template('member', 'member_list');
	}
	/****
	 * 获取单个企业数据
	 */
	function public_get() {
		//站点信息
		$userid=$_GET['userid'];
		
		if(isset($userid)){
			$where.='m.userid='.$userid;
			
			$sql1 = "select  m.userid,m.username,m.nickname complayName,i.* From gxw_member m ".
					"LEFT JOIN gxw_member_info i on m.userid=i.userid ".
					"WHERE " . $where;
			$memberlist = $this->db->mylistinfo ( $sql1, 'm.userid desc', $page );
		
			eval("\$photos = ".$memberlist[0]['basic_photos'].'; ');
			$memberlist[0]['basic_photos']=$photos;

			$dataArray=array();
			$dataArray['total']=$this->db->number;
			if($this->db->number !=0)
				$dataArray['rows']=$memberlist;
			$data=json_encode($dataArray);
			echo $data;
		}else{
			$data['success']=false;
			$data['message']='参数错误';
			echo json_encode($data);
		}
		
		//include template('member', 'member_list');
	}
	
	
	/***获取企业项目数据**/
	function public_project() {
		$this->projectDb = pc_base::load_model("project_model");
		//站点信息
		
		$sitelistarr = getcache('sitelist', 'commons');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '0';
		foreach ($sitelistarr as $k=>$v) {
			$sitelist[$k] = $v['name'];
		}
		$where = 'status=99 ';
	
		//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
/* 		if($_SESSION['roleid'] == 1) {
			if(!empty($siteid)) {
				$where .= "AND `siteid` = '$siteid'  ";
			}
		} else {
			$siteid = get_siteid();
			$where .= "AND `siteid` = '$siteid'  ";
		} */
			
		//$where .= "AND `status` = '99'  ";
		$username = $_GET["username"];
		if(isset($username)){
			$num = $this->db->count("username='$username'");
			if($num){
				$where .= "AND `username` = '$username' ";
			}else{
				$arr["success"]=false;
				$arr["message"]="用户$username不存在";
				echo json_encode($arr);
				exit;				
			}			
		}else{
			$arr["success"]=false;
			$arr["message"]="参数错误";
			echo json_encode($arr);
			exit;
		}
		$id=$_GET['id'];
			
		if(isset($id)){
			$num = $this->projectDb->count("`username`='$username' and `id` = $id");
			if($num){
				$where .= "AND p.id = $id";
			}else{
				$arr["success"]=false;
				$arr["message"]="您查找的项目不存在";
				echo json_encode($arr);
				exit;				
			}	
		}
			
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 15;
	
		/* $sql1 = "select p.id,p.catid,p.title,p.username,p.pro_type,p.cy_type,d.* From gxw_project p ".
				"LEFT JOIN gxw_project_data d on p.id=d.id ".
				"WHERE " . $where; */
		$sql1 = "select p.id,p.title,p.username,d.pro_content,d.start_time,d.end_time From gxw_project p ".
				"LEFT JOIN gxw_project_data d on p.id=d.id ".
				"WHERE " . $where;
		$memberlist = $this->db->mylistinfo ( $sql1, 'p.id desc', $page,$rows);
		$dataArray=array();
		$dataArray['total']=$this->projectDb->count("username='$username' and status=99");
		$dataArray['rows']=$memberlist;
		//$pages = $this->projectDb->number;
		$data=json_encode($dataArray);
		echo $data;
		//include template('member', 'member_list');
	}	
	function public_products(){
		$this->productDb = pc_base::load_model("products_model");
		$where ="status=99 ";
		$username = $_GET["username"];
		if(isset($username)){
			$num = $this->productDb->count("username='$username'");
			if($num){
				$where .= "AND `username` = '$username' ";
			}else{
				$arr["success"]=false;
				$arr["message"]="用户$username不存在";
				echo json_encode($arr);
				exit;
			}
		}else{
			$arr["success"]=false;
			$arr["message"]="参数错误";
			echo json_encode($arr);
			exit;
		}
		$id=$_GET['id'];
			
		if(isset($id)){
			$num = $this->productDb->count("`username`='$username' and `id` =$id");
			if($num){
				$where .= "AND p.id =$id";
			}else{
				$arr["success"]=false;
				$arr["message"]="您查找的产品不存在";
				echo json_encode($arr);
				exit;
			}
		}
			
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 15;
		
		/* $sql1 = "select p.id,p.catid,p.title,p.username,p.pro_type,p.cy_type,d.* From gxw_project p ".
		 "LEFT JOIN gxw_project_data d on p.id=d.id ".
		"WHERE " . $where; */
		$sql1 = "select p.id,p.title,p.username,p.thumbs,d.xingh,d.yongt From gxw_products p ".
				"LEFT JOIN gxw_products_data d on p.id=d.id ".
				"WHERE " . $where;
		$memberlist = $this->db->mylistinfo ( $sql1, 'p.id desc', $page,$rows);
		
		// $lists=array();
		foreach ($memberlist as $key => $value) {
			eval("\$thumbs = ".$value['thumbs'].'; ');
			$memberlist[$key]['thumbs']=$thumbs;
		}
		$dataArray=array();
		$dataArray['total']=$this->productDb->count("username='$username'");
		$dataArray['rows']=$memberlist;
		//$pages = $this->projectDb->number;
		$data=json_encode($dataArray);
		echo $data;		
	}
	//获取政策法规内容
	public function public_touch(){
		$catid = $_GET["catid"];
		
		if(isset($catid)){
			$sql = "select count(1) as num from gxw_category where catid=$catid";
			$rs = $this->db->query($sql);
			$num = $this->db->fetch_next($rs);
			if($num['num']){


				$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
				$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 15;
				
				$sql="select n.*,d.* from gxw_news n left join gxw_news_data d on n.id=d.id where catid=$catid";
				$memberlist = $this->db->mylistinfo ( $sql, 'n.id desc', $page,$rows);
			
				$dataArray=array();
				$sql="select count(1) as num from gxw_news where catid=$catid";
				$rs = $this->db->query($sql);
				$num = $this->db->fetch_next($rs);
				$num = $num['num'];
				
				$dataArray['total']=$num;
				
				$dataArray['rows']=$memberlist;

				$data=json_encode($dataArray);
				echo $data;				
			
			
			}else{
				$arr["success"]=false;
				$arr["message"]="参数$catid不存在";
				echo json_encode($arr);
				exit;
			}
		}else{
			$arr["success"]=false;
			$arr["message"]="参数错误";
			echo json_encode($arr);
			exit;			
		}
	}
	
	//获取广告列表
	public function public_adv(){
		$sql = "select * from gxw_poster where spaceid=11";
		$rs = $this->db->query($sql);
		$arr= $this->db->fetch_array($rs);
		$adv = array();
		foreach($arr as $v){
			$tmp = string2array($v['setting']);
			$adv[] = $tmp[1];
		}
		$adv_json = json_encode($adv);
		echo $adv_json;
	}
}
?>