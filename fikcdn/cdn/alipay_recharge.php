<?php
include_once("./head.php");
include_once('../db/db.php');
include_once("function.php");
?>

<script language="javascript" src="./js/calendar.js"></script>

<script type="text/javascript">
function ChangePayCheckCode(){
	var sHtml;
	var myDate=new Date();
	
	sHtml = '<img src="../function/pay_checkcode.php?time='+myDate.getTime()+'" alt="验证码" height="20" width="50" />';
	document.getElementById("span_pay_check_code").innerHTML=sHtml;
}

function FikCDN_SubOrder(){
	var nMoney = document.getElementById("txtMoney").value;
	var txtNote = document.getElementById("txtBackup").value; 
	var txtCheckNum = document.getElementById("txtCheckNum").value; 

	if (nMoney.length==0 || isNaN(nMoney) || nMoney==0 ){ 
	  	document.getElementById("tipsMoney").innerHTML="请输入充值金额";
		document.getElementById("tipsMoney").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsMoney").innerHTML="";
	}
	
	if(txtCheckNum.length==0 ){ 
	  	document.getElementById("tipsCheckNum").innerHTML="请输入验证码";
		document.getElementById("txtCheckNum").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsCheckNum").innerHTML="";
	}	

	var postURL="./ajax_buy.php?mod=order&action=submit";
	var postStr="Money=" + UrlEncode(nMoney) + "&Note=" + UrlEncode(txtNote) + 
			     "&CheckNum=" + UrlEncode(txtCheckNum);				 
					 
	AjaxClientBasePost("order","submit","POST",postURL,postStr);
}

function FikCDN_SubmitOrderResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var order_id = json["order_id"];
		location.href = "alipay.php?order_id="+order_id;
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
		
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			alert(strErr);
		}
	}
}

</script>


<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">在线充值</span></td>
				<td width="95%"></td>
			</tr>	
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  
<?php
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
				<td width="200" height="35" align="right"><span class="input_tips_txt">*</span><span class="input_tips_txt3">充值金额：</span></td>
				<td><input id="txtMoney" type="text" size="3" maxlength="32" style="width:65px" value="" /> <span class="input_tips_txt" id="tipsMoney" >元</span>  </td>
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
				<td><textarea id="txtBackup" name="txtBackup" maxlength="108" cols="48" rows="3" ></textarea> </td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt">*</span><span class="input_tips_txt3">验证码：</span></td>
				<td  style=" vertical-align:middle;">
				  <input id="txtCheckNum" name="txtCheckNum" type="text" size="6" maxlength="16" style="width:65px"  value=""  />
				  	<span id="span_pay_check_code" style="clear:both;"><img src="../function/pay_checkcode.php" alt="验证码" height="20" width="50" style="vertical-align:text-bottom;display:inline-block;" /></span>
							<a href="javascript:void(0)" onClick="javescript:ChangePayCheckCode();" > 更换验证码</a>
							<span class="input_tips_txt" id="tipsCheckNum" ></span>
				</td>
    		</tr>										
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="65" align="center"> </td>
				<td  style=" vertical-align:middle;">
				<input name="sub_order"  id="sub_order" type="submit" value="" onClick="FikCDN_SubOrder();" 
				style="width: 180px;height: 38px;cursor: pointer;border: 0; background:url(../images/sub.png) no-repeat;"  />
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
