<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<?php
if(!isset($_SESSION)){  
   session_start();  
}
include_once('../db/db.php');
include_once('../function/define.php');
include_once('../function/pub_function.php');
include_once("function.php");

if(!FuncClient_IsLogin())
{
	FuncClient_LocationLogin();
}
?>
<HEAD>
<TITLE>欢迎使用 Fikker CDN 后台管理系统</TITLE>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="description" content="Fikker CDN 后台管理系统" />
<meta name="keywords" content="Fikker CDN 后台管理系统" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #EEF2FB;
}
-->
</style>
<link href="../css/main.css" type="text/css" rel="stylesheet" />
<link href="../css/table.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="../js/urlencode.js"></script> 
<script language="javascript" src="../js/fikcdn_event.js"></script>
<script language="javascript" src="../js/client_function.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/cookie.js"></script>
<script language="javascript" src="../js/formatNumber.js"></script>
<script language="javascript" src="../js/div.js"></script>
</HEAD>
<body>