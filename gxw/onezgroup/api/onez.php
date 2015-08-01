<?php
include_once("../check.php");
$ChannelId=char_cv("ChannelId");
$ChannelId=1;

if($ChannelId){
  if(!file_exists(ONEZ_ROOT.'./onezdata/cache/channel/'.$ChannelId.'.php')){
    exit('Channel Error!');
  }else{
    Channel($ChannelId);
  }
}
switch ($action=char_cv("action","get")){
  case "send" :
    mkdirs(ONEZ_ROOT.'./onezdata/online');
    @touch(ONEZ_ROOT.'./onezdata/online/'.$userid);
    $touser=Char_Cv('touser');
    $content=Char_Cv('msg');
    $content=oiconv('utf-8','gbk',$content);
    $content=delhtml($content);
    $content=str_replace("\r\n",'[br]',$content);
    $content=str_replace("\n",'[br]',$content);
    if($setting['badwords']){
      $A=$B=array();
      foreach(explode("\n",$setting['badwords']) as $v){
        $v=Trim($v);
        if($v){
          $A[]=$v;
          $B[]='*';
        }
      }
      if($A){
        $content=str_replace($A,$B,$content);
      }
    }
    if($touser){
      AddMsg_User($touser,"\n2\t$userid\t$username\t$content\t$now");
    }else{
      if(!$ChannelId)exit('Channel Error!');
      if($Channel['savehistory']=='1' && $Channel['forumid'] && $Channel['lasttid'] && substr($userid,0,1)!='_'){
        $re=API_Re($Channel['lasttid'],$content);
        if($re!='1')WriteLog($re);
      }
      AddMsg_Public("1\t$userid\t$username\t$content\t$now",$ChannelId);
    }
    exit('Y');
  case'update':
    if(!$ChannelId)exit('Channel Error!');
    mkdirs(ONEZ_ROOT.'./onezdata/online/'.$ChannelId);
    @touch(ONEZ_ROOT.'./onezdata/online/'.$ChannelId.'/'.$userid);
    if(substr($userid,0,1)!='_'){
      mkdirs(ONEZ_ROOT.'./onezdata/online/0');
      @touch(ONEZ_ROOT.'./onezdata/online/0/'.$userid);
    }
    $index=Char_Cv('index','get');
    $A=array();
    while(file_exists(ONEZ_ROOT.'./onezdata/message/group/'.$ChannelId.'/'.($index+1).'.txt')){
      $index++;
      $A[]=Trim(@readover(ONEZ_ROOT.'./onezdata/message/group/'.$ChannelId.'/'.$index.'.txt'));
    }
    $file=ONEZ_ROOT.'./onezdata/message/users/'.$userid.'.php';
    if(file_exists($file)){
      foreach(explode("\n",@readover($file)) as $v){
        if($v && $v!='<?php die();?>'){
          $A[]=$v;
        }
      }
      @unlink($file);
    }
    if($A){
      echo $index."\n".implode("\n",$A);
    }
    break;
  case'update2':
    mkdirs(ONEZ_ROOT.'./onezdata/online');
    if(substr($userid,0,1)!='_'){
      mkdirs(ONEZ_ROOT.'./onezdata/online/0');
      @touch(ONEZ_ROOT.'./onezdata/online/0/'.$userid);
    }
    $A=array();
    $file=ONEZ_ROOT.'./onezdata/message/users/'.$userid.'.php';
    if(file_exists($file)){
      if(@filesize($file)>14){
        $B=@file($file);
        if($B){
          for($i=1;$i<count($B);$i++){
            $A[]=Trim($B[$i]);
          }
        }
        writeover($file,'<?php die();?>');
      }
    }
    if($A){
      implode("\n",$A);
    }
    break;
  case'list':
    if(!$ChannelId)exit('Channel Error!');
    mkdirs(ONEZ_ROOT.'./onezdata/online/'.$ChannelId.'');
    @touch(ONEZ_ROOT.'./onezdata/online/'.$ChannelId.'/'.$userid);
    $onlinepath="../onezdata/online/$ChannelId";
    $A=array();
    if(is_dir($onlinepath)){
      $dh=opendir($onlinepath);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          if(!is_dir($onlinepath.'/'.$file)) {
            if(time()-@filemtime($onlinepath.'/'.$file)<20){
              $A[]=$file;
            }else{
              @unlink($onlinepath.'/'.$file);
            }
          }
        }
      }
      closedir($dh);
    }
    echo implode(',',$A);
    break;
  case'userlist':
    if(!$ChannelId)exit('Channel Error!');
    $uids=Char_Cv('uids');
    if(!$uids)exit();
    $codepath=ONEZ_ROOT.'./'.$codepath;
    $u=API_UserList($uids);
    $A=array();
    foreach($u as $rs){
      $A[]=implode("\t",array_values($rs));
    }
    echo implode("\n",$A);
    break;
  case'upload':
    $token=Char_Cv('token','get');
    $onezid=Char_Cv('onezid','get');
    $name=$_FILES["Filedata"]["name"];
    $name=oiconv('utf-8','gbk',$name);
    $tmpname=$_FILES["Filedata"]["tmp_name"];
    $type=end(explode('.',$name));
    $suc=0;
    $Tokens=array(
      'pic'=>array('P','����ͼƬʧ��'),
      'file'=>array('F','�ϴ��ļ�ʧ��'),
    );
    if($Tokens[$token]){
      if($tmpname){
        $file=uniqid('');
        mkdirs(ONEZ_ROOT.'./onezdata/'.$token);
        if(@copy($tmpname,ONEZ_ROOT.'./onezdata/'.$token.'/'.$file)){
          $suc=1;
        }
      }
    }
    if($suc){
      $msg='['.$Tokens[$token][0].'/'.$name.'/'.$file.']';
    }else{
      $msg=$Tokens[$token][1];
    }
    AddMsg_User($userid,"\n4\t".strval($suc)."\t$onezid\t$msg");
    break;
  case'catch':
    $onezid=Char_Cv('onezid');
		$data=Trim($_POST['data']);
		if(!$data)exit();
		
    $data=str_replace(' ','+',$data);
    $data=base64_decode($data);
    $file=uniqid('');
    mkdirs(ONEZ_ROOT.'./onezdata/pic');
    writeover(ONEZ_ROOT.'./onezdata/pic/'.$file,$data);
			
    $msg='[P/����.jpg/'.$file.']';
    AddMsg_User($userid,"\n4\t1\t$onezid\t$msg");
    break;
  case'pub':
    if(!$ChannelId)exit('Channel Error!');
    $ti=Char_Cv('ti');
    $co=Char_Cv('co');
    $ti=oiconv('utf-8','gbk',$ti);
    $co=oiconv('utf-8','gbk',$co);
    $api=API_Pub($ti,$co);
    if(!$api){
      WriteLog($api);
      echo '<font color=red>�����Ч</font>';
    }else{
      list($tid,$url)=$api;
      if(!is_numeric($tid)){
        echo '<font color=red>����ʧ��</font>';
      }else{
        $msg='<span class="url" onclick="top.OpenUserDialog(\''.$userid.'\')">'.$username.'</span> �����������ӣ�<a class="url" href="'.$url.'" target="_blank">'.$ti.'</a> [<span class="url" onclick="Re('.$tid.')">�ظ�</span>]';
        AddMsg_Public("1\t0\t$msg",$ChannelId);
        echo 'Y';
      }
    }
    break;
  case're':
    if(!$ChannelId)exit('Channel Error!');
    $tid=Char_Cv('tid');
    $co=Char_Cv('co');
    $co=oiconv('utf-8','gbk',$co);
    $api=API_Re($tid,$co);
    if($api!='1')WriteLog($api);
    if($api==-1){
      echo '<font color=red>�����Ч</font>';
    }elseif($api==-2){
      echo '<font color=red>���Ӳ�����</font>';
    }else{
      echo 'Y';
    }
    break;
  case'tickout':
    $uid=Char_Cv('uid');
    if(!$uid)exit('-1');
    if($uid==$userid)exit('-2');
    $user=API_Info($userid);
    mkdirs(ONEZ_ROOT.'./onezdata/limit');
    @touch(ONEZ_ROOT.'./onezdata/limit/'.$uid.'.txt');
    
    AddMsg_User($uid,"\n3\t�ܱ�Ǹ�����ѱ�ϵͳ����Ա�Ƴ���Ⱥ��30�����ڲ������ٴν���\tlogout");
    exit('1');
    break;
  case'addmaster':
    if(!$ChannelId)exit('Channel Error!');
    $uid=Char_Cv('uid');
    $user=API_Info($userid);
    if($Channel['username']!=$username)exit('-1');
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
	  db_local();
      $db=new onez_db;
      $masters=explode(',',$Channel['masters']);
      if(!in_array($username,$masters)){
        $masters[]=$username;
        $masters=implode(',',$masters);
        $db->update("channel",array('masters'=>$masters),"id='$ChannelId'");
        Channel($ChannelId,1);
      }
    }
    AddMsg_Public("5\t$uid",$ChannelId);
    exit('1');
    break;
  case'addfriend':
    $uid=Char_Cv('uid');
    $A=explode(',',API_LsFriend());
    if(in_array($uid,$A))exit('-1');
    echo API_AddFriend($uid);
    break;
}
?>