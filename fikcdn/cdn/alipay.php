<?php

include_once("./head.php");
include_once('../db/db.php');
include_once("function.php");

?>

<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
function ChangePayCheckCode(){
	var sHtml;
	var myDate=new Date();
	
	sHtml = '<img src="./function/pay_checkcode.php?time='+myDate.getTime()+'" alt="验证码" height="20" width="50" />';
	document.getElementById("span_pay_check_code").innerHTML=sHtml;
}

function onChangeAuthType(){
	var nAuthType = document.getElementById("authTypeSelect").value;
	
	var objSpanAuthPrice = document.getElementById("span_auth_price");
         
	if(nAuthType==12)
	{	    
		objSpanAuthPrice.innerHTML = "799元/年";
	}
	else if(nAuthType==6)
	{	    
		objSpanAuthPrice.innerHTML = "399元/半年";
	}
	else if(nAuthType==3)
	{	    
		objSpanAuthPrice.innerHTML = "199元/三个月";
	}	
	else if(nAuthType==1)
	{	    
		objSpanAuthPrice.innerHTML = "78元/月";
	}	
	else
	{
		alert("选择错误!");
	}	
}

function FikAgent_PayOrder(order_id){
	var new_url = "alipayapi.php?order_id="+order_id;
	window.open(new_url);
}

</script>


<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">在线支付</span></td>
				<td width="95%"></td>
			</tr>	
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  
<?php
	$order_id 	= isset($_GET['order_id'])?$_GET['order_id']:'';
	$client_username	=$_SESSION['fikcdn_client_username'];
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
			
			//查询订单		
		}
			
		$sql = "SELECT * FROM fikcdn_recharge WHERE order_id='$order_id' AND username='$client_username'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{
			$id  			= mysql_result($result,$i,"id");	
			$order_id   	= mysql_result($result,$i,"order_id");
			$status   		= mysql_result($result,$i,"status");
			$username   	= mysql_result($result,$i,"username");
			$chgmoney 		= mysql_result($result,$i,"money");	
			$time  		 	= mysql_result($result,$i,"time");	
			$transactor   	= mysql_result($result,$i,"transactor");	
			$bank_name   	= mysql_result($result,$i,"bank_name");	
			$serial_no   	= mysql_result($result,$i,"serial_no");
			$balance	   	= mysql_result($result,$i,"balance");
			$note   	    = mysql_result($result,$i,"note");
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
				<td width="200" height="35" align="right"><span class="input_tips_txt3">订单号：</span></td>
				<td> 			
					<span id="span_auth_price" name="span_auth_price"><?php echo $order_id; ?></span>
				</td>
    		</tr>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">本次充值金额：</span></td>
				<td> <span id="span_auth_price" name="span_auth_price" class="input_tips_txt2"><?php echo $chgmoney; ?> 元</span></td>
    		</tr>									
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">当前账户余额：</span></td>
				<td> <span class="input_tips_txt2"><?php echo $money;  ?> 元</span></td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="60" align="right"><span class="input_tips_txt3">付款方式：</span></td>
				<td style="vertical-align:middle;"> 
				     <div style="width:60px; float:left;vertical-align:middle; margin-top:15px;"> <input type="radio" checked="checked" name="fikker_pay" id="fikker_pay" 
					 title="全球领先的第三方支付平台，在线支付，安全可靠！"/>  </div>
					 <div style="width: 135px;height: 45px;border: 0; margin-left:20px; background:url(../images/alipay.gif) no-repeat;" 
					 title="全球领先的第三方支付平台，在线支付，安全可靠！"></div>
				</td>
    		</tr>					
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" align="right"><span class="input_tips_txt3">备注：</span></td>
				<td><?php echo $note;  ?></td>
    		</tr>											
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="65" align="center"> </td>
				<td  style=" vertical-align:middle;">
				<input name="sub_order"  id="sub_order" type="submit" class="input_btnpay" value="立即在线支付" onClick="FikAgent_PayOrder(<?php echo '\''.$order_id.'\'';?>);" />
				</td>
    		</tr>
		 </table>		
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
