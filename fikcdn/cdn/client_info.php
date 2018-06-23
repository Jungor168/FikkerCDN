<?php
include_once("./head.php");
?>
<script language="javascript" src="../js/calendar.js"></script>
<script type="text/javascript">	
function FikCdn_Modify(){
	window.location.href = "./client_info_modify.php"; 
}
</script>

<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">个人资料</span></td>
				<td width="95%"></td>
			</tr>	
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  
<?php
	$client_username 	= $_SESSION['fikcdn_client_username'];
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{		
			$id  			=mysql_result($result,0,"id");
			$real_name		=mysql_result($result,0,"realname");	
			$phone 			=mysql_result($result,0,"phone");	
			$qq 			=mysql_result($result,0,"qq");
			$addr 			=mysql_result($result,0,"addr");
			$note			=mysql_result($result,0,"note");
			$money			=mysql_result($result,0,"money");
			$enable_login	=mysql_result($result,0,"enable_login");
			$last_login_ip	=mysql_result($result,0,"last_login_ip");
			$last_login_time=mysql_result($result,0,"last_login_time");
			$login_count	=mysql_result($result,0,"login_count");			
		}
			
		mysql_close($db_link);
	}
?>		
  
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td> 
	  <td valign="top">
		  <table width="800" border="0" class="dataintable">
			<tr>
				<th colspan="2" align="left" height="35"></th> 
			</tr>	
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">登录用户名：</span></td>
				<td> <label><?php echo $client_username;  ?></label></td>
    		</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">姓名：</span></td>
				<td> <label><?php echo $real_name;  ?></label></td>
    		</tr>					
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">联系地址：</span></td>
				<td> <label><?php echo $addr;  ?></label></td>
    		</tr>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">联系电话：</span></td>
				<td> <label><?php echo $phone;  ?></label></td>
    		</tr>				
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">QQ号码：</span></td>
				<td> <label><?php echo $qq;  ?></label></td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">账户余额：</span></td>
				<td> <label><?php echo $money;  ?> 元</label></td>
    		</tr>												
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="center"> </td>
				<td>
				<input name="btn_modify"  id="btn_modify" type="submit" style="width:80px;height:28px"  value="修改" style="cursor:pointer;" onClick="FikCdn_Modify();" /> 
				</td>
    		</tr>
		 </table>
		 <p></p>



		
	  </td> 
	  <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  
   <tr>
    <td valign="bottom" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
    <td background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17"></td>
    <td valign="bottom" background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr> 
</table>
</div>

<?php

include_once("./tail.php");
?>
