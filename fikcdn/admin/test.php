<?php
	session_start(); 

	// 测试
	$username 					=$_SESSION['username'];
	$IsLogin 					=$_SESSION['IsLogin'];
	$fikcdn_admin_auth 			=$_SESSION['fikcdn_admin_auth'];
	$cookie_fikcdn_admin_auth 	=$_COOKIE['fikcdn_admin_auth'];
	
	echo "username=".$username."<br/>";
	echo "IsLogin=".$IsLogin."<br/>";
	echo "fikcdn_admin_auth=".$fikcdn_admin_auth."<br/>";
	echo "cookie_fikcdn_admin_auth=".$cookie_fikcdn_admin_auth."<br/>";	
?>

<?php printf(' memory usage: %01.2f MB', memory_get_usage()/1024/1024); ?>

<style type="text/css">
#qq_pannel{Z-INDEX: 2; left: 20px;top: 0; clear:both;VISIBILITY: visible;WIDTH:309px; height:650px; POSITION: absolute; TOP: 100px;}
.msgTitle {font-size:14px;color: #666666;margin:0px;
a:link,a:hover,a:active,a:visited{color: #1875C6; text-decoration: none;}
}

.b1,.b2,.b3,.b4,.b1b,.b2b,.b3b,.b4b,.b{display:block;overflow:hidden;}
.b1,.b2,.b3,.b1b,.b2b,.b3b{height:2px;}
.b2,.b3,.b4,.b2b,.b3b,.b4b,.b{border-left:2px solid #83B6E7;border-right:2px solid #83B6E7;}
.b1,.b1b{margin:0 0px;background:#83B6E7;}
.b2,.b2b{margin:0 3px;border-width:2px;}
.b3,.b3b{margin:0 2px;}
.b4,.b4b{height:2px;margin:0 2px;}
.d1{background:#FFFFFF;}
.k {height:180px;}
</style>

<div id="qq_pannel">  
	<table border="0"><tr>
		<td width="4" height="28"><img src="../images/msgbox/t-left.gif"></td>
		<td width="100%" ID="msgBOXTitle" class="msgTitle" background="../images/msgbox/t-mid.gif" style="padding-left:6px;"></td>
		<td width="35" background="../images/msgbox/t-mid.gif\"><a href="javascript:closeMSGBOX()"><span style="font-family:宋体;font-size:14px;">×</span></a></td>
		<td width="4"><img src="../images/msgbox/t-right.gif"></td>
	</tr>
	<tr>
		<td background="../images/msgbox/m-left.gif"></td>
		<td colspan="2" id="boxM" style="background:#ffffff;"></td>
		<td background="../images/msgbox/m-right.gif"></td>
	</tr>
	<tr>
		<td background="../images/msgbox/b-left.gif" height="4"></td>
		<td colspan="2" background="../images/msgbox/b-mid.gif"></td>
		<td background="../images/msgbox/b-right.gif"></td>
	</tr>
	
	</table>
<?php	

function PubFunc_CutHttp($url)
{
	if(substr($url,0,7)=="http://")
	{
		return substr($url,7);
	}
	else if(substr($url,0,6)=="http:/")
	{
		return substr($url,6);
	}	
	else if(substr($url,0,5)=="http:")
	{
		return substr($url,5);
	}	
	return $url;
}

	echo strtotime("2012-12-23")."<br/>";
	
	echo "now=".time()."<br/>";
	echo "now=".date("Y-m-d H:i:s",time())."<br/>";
	
	echo date("Y-m-d",strtotime("2012-12-23"))."<br/>";
	
	$time1 = strtotime("2014-5-23 18:34:31");
	echo "time1=".$time1.'<br />';
	
	$time1= 1425571200;
	echo "time1===".date("Y-m-d H:i:s",$time1)."<br/>";
	
	$time2= 1425657600;
	echo "time2===".date("Y-m-d H:i:s",$time2)."<br/>";
		
	echo 3%25;
	
	echo "<p>";
	
	$timeval1 = time()-(6*60*60*24);
	$sql = "DELETE FROM domain_stat_host_bandwidth WHERE time<$timeval1";
	echo "sql=".$sql."<br />";
	
	echo "==================<br />";
	echo "the time is=". date("Y-m-d H:i:s",1422312143)."<br/>";
	echo "the time is=". date("Y-m-d H:i:s",1422982212)."<br/>";
	
	$nDay = date("d")-1;
	$timeval1 = mktime(23,59,59,date("m"),$nDay,date("Y"));
	echo "2.the time is=". date("Y-m-d H:i:s",$timeval1)."<br/>";

	$upstream = "192.168.3.4;198.34.5.6";
	$ary = explode(";",$upstream);
	
	var_dump($ary);	
	echo "<p>";	
	
	echo PubFunc_CutHttp("http://www.fikker.com");
	echo "<br />";
	echo PubFunc_CutHttp("http:/www.fikker.com");
	echo "<br />";	
	echo PubFunc_CutHttp("http:www.fikker.com");
	echo "<br />";	
	echo PubFunc_CutHttp("www.fikker.com");	
	echo "<br />";	
	
	function PubFunc_IsHomePage($url)
	{
		$sUrl = PubFunc_CutHttp($url);
		
		$nPos = stripos($sUrl,"/");
		if($nPos==false)
		{
			return true;
		}
		
		return false;
		
	}
	
	if(PubFunc_IsHomePage("www.fikker.com/","/"))
	{
		echo "yes";
	}
	else
	{
		echo "no";
	}
	$aryResult = array();
	
	$aryPrevProxy[1]["test1"]["ProxyID"]=1;
	$aryPrevProxy[1]["test2"]["ProID"]=4;
	$aryPrevProxy[2]["test3"]["ProxyID"]=1;
	$aryPrevProxy[2]["test4"]["PxyID"]="dfad";
	$aryPrevProxy[4]["test5"]["ProxyID"]=1;
	$aryPrevProxy[8]["test6"]["ProxyID"]=1;
	$aryPrevProxy[233]["test7"]["ProxyID"]=1;
	
	foreach ($aryPrevProxy as $pData) {
		echo "<br /><br /><br />";
		print_r($pData);
	}
	
	echo "<br /><br /><br />";
	$fik_version = "3.6.1";
	
	if($fik_version >= "3.6.2")
	{
		echo "$fik_version >= 3.6.2";
	}
	else
	{
		echo "$fik_version < 3.6.2";
	}
	
	echo "<br /><br /><br />";	
	if($fik_version > "3.6.2")
	{
		echo "$fik_version > 3.6.2";
	}
	else if($fik_version == "3.6.2")
	{
		echo "$fik_version == 3.6.2";
	}
	else
	{
		echo "$fik_version < 3.6.2";
	}
	
?>
</div>


