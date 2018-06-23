<?php
session_start(); 
include_once('../db/db.php');
include_once('../function/define.php');
include_once("function.php");

if(!FuncClient_IsLogin())
{
	FuncClient_LocationLogin();
}
else
{
	header("Location:main.php");
}
?>

