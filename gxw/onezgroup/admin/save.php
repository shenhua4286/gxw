<?php
include("admin/check.php");
function createtable($sql) {
	global $dbcharset;
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
}
function runquery($sql) {
	global $dbcharset, $tbl, $db;
	$tablepre=$tbl.'bot_';
	$sql = str_replace("\r", "\n", str_replace(' onez_', ' '.$tablepre, $sql));
	$ret = array();
	$num = 0;
	if($dbcharset=='utf8'){
    @$db->query("set names $dbcharset");
	}
	foreach(explode(";\n", trim($sql)) as $query) {
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				$db->query(createtable($query));
			} else {
        if($dbcharset=='utf8'){
          $query=iconv('gbk',$dbcharset,$query);
        }
				$db->query($query);
			}
		}
	}
}
$action=Char_Cv("action","get");
switch($action){
  case"config":
    $ac=Char_Cv("ac","get");
    if($ac=='api'){
      $configfile=@readover('../config.inc.php');
      $configfile = preg_replace("/\/\/([\*]+)UCenter Start([\*]+)((.|\n)+?)\/\/([\*]+)UCenter End([\*]+)/i", "//$1UCenter Start$2\n".$_POST['uc_config']."//$5UCenter End$6", $configfile);
      @writeover('../config.inc.php',$configfile);
    }
    $config=$_POST["config"];
    if(is_array($config)){
      foreach($config as $k=>$v){
        $setting[$k]=strval($v);
      }
    }
    $setting['autosave']=$config["autosave"]=='1'?'1':'0';
    writeover('../onezdata/setting.php','<?php
  $setting='.var_export($setting,true).';
  ?>');
    ero("操作成功","index.php?action=$ac");
    break;
  case"addchannel"://
    if(!$_POST)ero("来源非法",1);
    $config=$_POST["config"];
    $config['allowguest']=$config["allowguest"]=='1'?'1':'0';
    $config['ifonly']=$config["ifonly"]=='1'?'1':'0';
    $config['savehistory']=$config["savehistory"]=='1'?'1':'0';
    $config['exptime']=$config["exptime"]=='-1'?'-1':strtotime($config["exptime"]);
    $db->insert("channel",$config);
    ero("添加成功","index.php?action=channels");
    break;
  case"editchannel"://
    $id=Char_Cv("id");
    if(!$id)ero("请选择您要编辑的记录",1);
    $config=$_POST["config"];
    $config['allowguest']=$config["allowguest"]=='1'?'1':'0';
    $config['ifonly']=$config["ifonly"]=='1'?'1':'0';
    $config['savehistory']=$config["savehistory"]=='1'?'1':'0';
    $db->update("channel",$config,"id='$id'");
    @unlink('../onezdata/cache/channel/'.$id.'.php');
    ero("添加成功","index.php?action=channels");
    break;
  case"delchannel"://
    $id=Char_Cv("id","get");
    if(!$id)ero("请选择您要删除的记录",1);
    $db->delete("channel","id=$id");
    @unlink('../onezdata/cache/channel/'.$id.'.php');
    ero("删除成功","index.php?action=channels");
    break;
  case"setchannel"://
    $id=Char_Cv("id","get");
    $s=Char_Cv("s","get");
    if(!$id)ero("请选择您要操作的记录",1);
    if($s=='1'){
      $db->update("channel",array('ifdefault'=>1),"id=$id");
      $db->update("channel",array('ifdefault'=>0),"id<>$id");
    }else{
      $db->update("channel",array('ifdefault'=>0),"id=$id");
      $db->update("channel",array('ifdefault'=>1),"id<>$id");
    }
    @unlink('../onezdata/cache/channel/'.$id.'.php');
    ero("设置成功","index.php?action=channels");
    break;
  case"addlinks"://添加链接
    if(!$_POST)ero("来源非法",1);
    $cid=Char_Cv("cid");
    $arr=array(
      'adpos'=>Char_Cv("adpos"),
      'cid'=>Char_Cv("cid"),
      'icon'=>Char_Cv("icon"),
      'title'=>Char_Cv("title"),
      'linkurl'=>Char_Cv("linkurl"),
      'endtime'=>strtotime(Char_Cv("endtime")),
      'addtime'=>$time,
      'updatetime'=>$time,
      'addip'=>$onlineip,
    );
    $db->insert("links",$arr);
    @unlink('../onezdata/cache/channel/'.$cid.'.php');
    ero("添加成功","index.php?action=links&cid=$cid");
    break;
  case"editlinks"://编辑链接
    $id=Char_Cv("id");
    $cid=Char_Cv("cid");
    if(!$id)ero("请选择您要编辑的记录",1);
    $arr=array(
      'adpos'=>Char_Cv("adpos"),
      'cid'=>Char_Cv("cid"),
      'icon'=>Char_Cv("icon"),
      'title'=>Char_Cv("title"),
      'linkurl'=>Char_Cv("linkurl"),
      'endtime'=>strtotime(Char_Cv("endtime")),
      'updatetime'=>$time,
    );
    $db->update("links",$arr,"id=$id");
    @unlink('../onezdata/cache/channel/'.$cid.'.php');
    ero("编辑成功","index.php?action=links&cid=$cid");
    break;
  case"dellinks"://删除单个链接
    $cid=Char_Cv("cid");
    $id=Char_Cv("id","get");
    if(!$id)ero("请选择您要删除的记录",1);
    $db->delete("links","id=$id");
    @unlink('../onezdata/cache/channel/'.$cid.'.php');
    ero("删除成功","index.php?action=links&cid=$cid");
    break;
  case"dellinks2"://批量删除链接
    $cid=Char_Cv("cid");
    $id=Char_Cv("id");
    if(!$id)ero("您没有选择任何内容",1);
    $db->delete("links","id in (".@implode(",",$id).")");
    @unlink('../onezdata/cache/channel/'.$cid.'.php');
    ero("删除成功","index.php?action=links&cid=$cid");
    break;
  case"robot":
    $s=Char_Cv("s","get");
    $botid=Char_Cv("botid","get");
    if($s=='install'){
      if($db->rows("robot","botid='$botid'")==0){
        if(is_numeric($botid))ero("此机器人标识有误(必须字母开头)，安装失败！");
        if(!file_exists('../plugins/robot/'.$botid.'/config.php'))ero('此机器人不存在');
        $sqlData=@readover('../plugins/robot/'.$botid.'/sql.txt');
        if($sqlData){
          runquery($sqlData);
        }
        include('../plugins/robot/'.$botid.'/config.php');
        $arr=array(
          'botid'=>$botid,
          'botname'=>$Con['name'],
          'readme'=>$Con['readme'],
          //'con'=>'$Con='.var_export($Con,true).';',
        );
        $db->insert("robot",$arr);
      }
    }else{
      if($db->rows("robot","botid='$botid'")>0){
        $sqlData=@readover('../plugins/robot/'.$botid.'/sql.txt');
        if($sqlData){
          if(preg_match_all("/CREATE TABLE([^\(]+)\(/i",$sqlData,$mat)){
            $A=array();
            foreach($mat[1] as $v){
              $v=preg_replace("/IF NOT EXISTS/i",'',$v);
              $v=str_replace('`','',$v);
              $v=str_replace(' ','',$v);
              $A[$v]=$v;
            }
            foreach($A as $v)runquery("DROP TABLE IF EXISTS $v");
          }
        }
        $db->delete("robot","botid='$botid'");
      }
    }
    @unlink('../onezdata/cache/robot.php');
    header("location:index.php?action=robots");
    break;
}
?>