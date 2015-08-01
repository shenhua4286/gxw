<?php
function db_local(){
  include(ONEZ_ROOT.'./config.inc.php');
  $GLOBALS['tbl']=$tbl;
  $GLOBALS['dbhost']=$dbhost;
  $GLOBALS['dbuser']=$dbuser;
  $GLOBALS['dbpass']=$dbpass;
  $GLOBALS['dbname']=$dbname;
}
class onez_db{
	var $version = '';
	var $querynum = 0;
	var $link;
	var $tbl;
	var $dbname;
	
  function onez_db(){
	//echo '32';
  	global $dbhost,$dbuser,$dbpass,$dbname,$pconnect,$charset,$tbl;
		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$this->link = @$func($dbhost, $dbuser, $dbpass)) {
			die('Can not connect to MySQL server');
		} else {
      global $dbcharset, $wcharset;
      if(!$dbcharset)$dbcharset=$charset;
      $serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
      $serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
      @mysql_query("SET $serverset", $this->link);
      @mysql_query("set names $dbcharset", $this->link);
			$dbname && @mysql_select_db($dbname, $this->link);
		}
		$this->tbl=$tbl;
		$this->dbname=$dbname;
    register_shutdown_function(array(&$this, 'close'));
  }
  
  function reset(){
    @mysql_select_db($this->dbname, $this->link);
  }
  
  function close(){
    mysql_close($this->link);
  }
  
	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->link);
		}
		return $this->version;
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return (($this->link) ? mysql_errno($this->link) : mysql_errno());
	}
  
  function query($sql,$type='') {
		$query=mysql_query($sql, $this->link);
		$this->querynum++;
		return $query;
  }
  
  function fetch_array($sql) {
    return mysql_fetch_array($sql,MYSQL_ASSOC);
  }
  
  function rows($table,$vars="",$field='*') {
    $tbl=$this->tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select count($field) as id from $table $vars");
    if(!$result)return 0;
    $rs=$this->fetch_array($result);
    return $rs['id'];
  }
  
  function insert($table,$arr) {
    $tbl=$this->tbl;
    $table = $tbl.$table;
    $A=array();
    foreach($arr as $k=>$v){
			$A[$k]=var_export($v,true);
    }
    $this->query("insert into $table (".implode(',',array_keys($A)).")values(".implode(',',array_values($A)).")");
  }
  function update($table,$arr,$vars) {
    $tbl=$this->tbl;
    if(!$arr)return;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $A=array();
    foreach($arr as $k=>$v){
			$v=var_export($v,true);
			if(substr($v,-2,2)=='\\\'')$v=substr($v,0,-2).'\'';
			$A[]=$k.'='.$v;
    }
    $this->query("update $table set ".implode(',',$A)." $vars");
  }
  function delete($table,$vars) {
    $tbl=$this->tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $this->query("delete from $table $vars");
  }
  function select($table,$key,$vars=""){
    $tbl=$this->tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select $key from $table $vars");
    if(!$result){
      return false;
    }else{
      $rs=mysql_fetch_array($result);
      return $rs[$key];
    }
  }
  function autoindex($table){
    $tbl=$this->tbl;
    $table = $tbl.$table;
    $result=mysql_query("SHOW TABLE STATUS LIKE '$table'");
    if(!$result){
      return false;
    }else{
      $rs=mysql_fetch_array($result);
      return $rs['Auto_increment'];
    }
  }
  function record($table,$key,$vars="",$limit=""){
    $tbl=$this->tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    if($limit){
      $limit = "limit $limit";
    }
    $k=explode(",",$key);
    $record = Array();
    
    $sql="select $key from $table $vars $limit";
   // echo $sql;
    $result=$this->query($sql);
    $j=0;
    if(!$result){
    	echo mysql_error();
      return false;
    }
    while($onez=$this->fetch_array($result)){
      $record[$j]=$onez;
      $j++;
    }
    return $record;
  }
  function page($table,$key,$vars="",$maxperpage=20,$strs){
    $tbl=$this->tbl;
    $table_=$table;
    $vars_=$vars;
    $pagename = $_SERVER['PHP_SELF'];
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $thispage=Char_Cv("page","get");
    if ($thispage=="" || !is_numeric($thispage)){
      $thispage=1;
    }
    $thispage=intval($thispage);
    if($thispage<1)$thispage=1;
    $sql="select $key from $table $vars limit ".(($thispage-1)*$maxperpage).",$maxperpage";
    $result=$this->query($sql);
    $totalput=$this->rows($table_,$vars_);
    if (($totalput %$maxperpage)==0){
      $PageCount=intval($totalput /$maxperpage);
    }else{
      $PageCount=intval($totalput /$maxperpage+1);
    } 
    if($PageCount<$thispage)$thispage=$PageCount;
    $record = Array();
    while($onez=$this->fetch_array($result)){
      $record[]=$onez;
    }
    $ms="";unset($A,$B);
    if($thispage<1)$thispage=1;
    if($PageCount<1)$PageCount=1;
    if($strs && $PageCount>1){
			$page='<div id="page">';
			if($thispage>1)$page.='<a href="'.str_replace('*',$thispage-1,$strs).'" class="step">��һҳ</a>';
			if($thispage>5){
				$page.='<a href="'.str_replace('*',1,$strs).'">1</a>';
				$page.='<span>��</span>';
				if($thispage>$PageCount-7){
					for($i=$PageCount-7;$i<$thispage-3;$i++){
						$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
					}
				}
				for($i=$thispage-3;$i<$thispage;$i++){
					$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
				}
			}else{
				for($i=1;$i<$thispage;$i++){
					$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
				}
			}
			$page.='<a href="'.str_replace('*',$thispage,$strs).'" class="sel">'.$thispage.'</a>';
			if($PageCount-$thispage>5){
				if($PageCount>8){
					for($i=$thispage+1;$i<=($thispage>5?$thispage+3:8);$i++){
						$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
					}
					$page.='<span>��</span>';
					$page.='<a href="'.str_replace('*',$PageCount,$strs).'">'.$PageCount.'</a>';
				}else{
					for($i=$thispage+1;$i<=$PageCount;$i++){
						$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
					}
				}
			}else{
				for($i=$thispage+1;$i<=$PageCount;$i++){
					$page.='<a href="'.str_replace('*',$i,$strs).'">'.$i.'</a>';
				}
			}
			if($thispage<$PageCount)$page.='<a href="'.str_replace('*',$thispage+1,$strs).'" class="step">��һҳ</a>';
			$page.='</div>';
		}
    return array($record,$page);
  }
}
?>