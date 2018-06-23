<?php	
//  文件头
include_once('head.php');
$fikcdn_client_nick 				=$_SESSION['fikcdn_client_nick'];
?>
<script type="text/javascript">	
function FikCdn_ClientLogout(){
	var postURL="ajax_login.php?mod=login&action=logout";
	var postStr="";

	AjaxClientBasePost("login","logout","POST",postURL,postStr);
}
</script>

<div id="fikcdn_main_div">
	<div id="main_top_space">
		<div id="main_top_div">
			<div id="main_top_logo_1"></div>		
			<div id="main_top_right"><a href="#" target="_self" onClick="FikCdn_ClientLogout();"><img src="../images/out.gif" alt="安全退出" width="46" height="20" border="0"></a></div>
			<div id="main_top_txt"> <?php echo $fikcdn_client_nick;   ?> ！欢迎使用 Fikker CDN 后台管理系统</div>
		</div>
	</div>
</div>
	
<?php

include_once("tail.php");
?>