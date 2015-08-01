<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=gb2312">
<title><?=$title?></title>
<link href="images/style.css" rel="stylesheet" type="text/css"/>
<meta name="keywords" content="">
<meta name="description" content="">
</head>
<body>
<div class="header">
<div class="link"></div>
<div class="logo"></div>
<div class="headad"></div>
</div>
<ul class="menu">
<li class="left"></li>
<?for($i=0;$i<count($Menu);$i++){
if(is_array($Menu[$i][1])){?>
<li class="<?=$i==$MenuIndex?'sel':'text'?>"><a href="index.php?menu=<?=$i?>"><?=$Menu[$i][0]?></a></li>
<?}else{?>
<li class="text"><a href="<?=$Menu[$i][1]?>" target="_blank"><?=$Menu[$i][0]?></a></li>
<?}}?>
<li class="right"></li>
</ul>
<div class="page">
<div class="left">
  <div class="ti"></div>
  <ul class="co">
  <?if(is_array($ChildMenu)){
  foreach($ChildMenu as $k=>$v){?>
    <li<?=$k==$action?' class="sel"':''?>><a href="index.php?action=<?=$k?>"><?=$v?></a></li>
  <?}}?>
  </ul>
</div>
<div class="main">
  <div class="where">
    <a href="?action=main">用户中心首页</a> &raquo; <?=$Menu[$MenuIndex][0]?> &raquo; <?=$ChildMenu[$action]?>
  </div>
  <div class="toolbar"><?=$title?></div>
  <div class="content">