<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$setting['homename']?></title>
<link href="themes/<?=$theskin?$theskin:$setting['theme']?>/style.css" rel="stylesheet" type="text/css" />
<link href="onez.ico" rel="shortcut icon" />
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/event.js"></script>
<script type="text/javascript" src="js/limit.js"></script>
<script type="text/javascript">
var onez_key="<?=$_GET["onezid"]?>";
var client="<?=$_GET["client"]?>";
try{var onez_id=eval("window.parent."+onez_key);}catch(e){}
try{_attachEvent(window,"load",function(){parent.FrameInit(onez_key)});}catch(e){parent.FrameInit(onez_key);}
</script>
</head>
<body scroll="no" class="childbody">