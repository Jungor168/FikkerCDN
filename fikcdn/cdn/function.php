<?php
if(!isset($_SESSION)){  
   session_start();  
}
//判断当前请求用户是否登录
function FuncClient_IsLogin()
{
	$username 					=$_SESSION['fikcdn_client_username'];
	$IsLogin 					=$_SESSION['fikcdn_client_IsLogin'];
	$fikcdn_client_auth 		=$_SESSION['fikcdn_client_auth'];
	$cookie_fikcdn_client_auth 	=$_COOKIE['fikcdn_client_auth'];
	if(strlen($username)>0 && $IsLogin && ($fikcdn_client_auth==$cookie_fikcdn_client_auth))
	{
		return true;
	}
	
	return false;
}

function FuncClient_LocationLogin()
{
	header("Location:login.php");
	exit();
}


?>