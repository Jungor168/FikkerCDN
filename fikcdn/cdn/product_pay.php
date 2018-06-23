<?php
include_once("head2.php");
?>
<script language="javascript" src="../js/calendar.js"></script>
<script type="text/javascript">
var ___nOrderId;
function FikCdn_PayOrderBox(order_id){
	___nOrderId = order_id;
	var txtBackup = document.getElementById("txtBackup").value;
	
	var boxURL="msg.php?1.4";
	showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
}

function FikCdn_PayOrder(){
	var txtBackup = document.getElementById("txtBackup").value;
				
	var postURL="./ajax_buy.php?mod=order&action=pay";
	var postStr="order_id="+UrlEncode(___nOrderId)+"&note="+UrlEncode(txtBackup);
					 
	AjaxClientBasePost("order","pay","POST",postURL,postStr);	
}

function FikCdn_ClientPayOrderResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var boxURL="msg.php?1.5";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');	
		
		//var buy_id = json["buy_id"];
		//window.location.href = "./buy_list.php?buy_id="+buy_id; 
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			var boxURL="msg.php?1.9&msg="+strErr;
			showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		}
	}		
}

function FikCdn_ToDomainList()
{
	parent.window.location.href = "./domain_list.php";
	parent.parent.window.leftFrame.window.OnSelectNav("span_domain_list");
}

function checkIsNumber(str)
{
     var re = /^[1-9]+[0-9]*]*$/;   //判断字符串是否为数字 /^[0-9]+.?[0-9]*$/     //判断正整数 /^[1-9]+[0-9]*]*$/    
     if (!re.test(str))
    {
        return false;
     }
	 return true;
}

</script>

<?php
	$order_id = isset($_GET['order_id'])?$_GET['order_id']:'';
 	$client_username 	=$_SESSION['fikcdn_client_username'];
	
 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$order_id = mysql_real_escape_string($order_id); 
		$client_username = mysql_real_escape_string($client_username); 
		
		$sql = "SELECT * FROM fikcdn_order WHERE id='$order_id' AND username='$client_username';"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			mysql_close($db_link);
			exit();
		}
	
		$username = mysql_result($result,0,"username");
		$product_id = mysql_result($result,0,"product_id");
		$buy_time = mysql_result($result,0,"buy_time");
		$status = mysql_result($result,0,"status");
		$auto_renew = mysql_result($result,0,"auto_renew");
		$price 		= mysql_result($result,0,"price");
		$month = mysql_result($result,0,"month");
		$type = mysql_result($result,0,"type");
		$data_flow	= mysql_result($result,0,"data_flow");	
		$domain_num = mysql_result($result,0,"domain_num");
		$note	 	= mysql_result($result,0,"note");
		$buy_id	 	= mysql_result($result,0,"buy_id");
		$frist_month_money =  mysql_result($result,0,"frist_month_money");
		
		$total_money = ($price*($month));
		
		$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			mysql_close($db_link);		
			exit();
		}
		
		$product_name = mysql_result($result,0,"name");
		$product_note= mysql_result($result,0,"note");	
		
		$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			mysql_close($db_link);		
			exit();
		}
		$client_money = mysql_result($result,0,"money");
		$enable_login = mysql_result($result,0,"enable_login");
		
		if($type==$PubDefine_BuyTypeRenew)
		{
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' ;"; 
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				mysql_close($db_link);		
				exit();
			}
			$buy_begin_time = mysql_result($result,0,"begin_time");
			$buy_end_time = mysql_result($result,0,"end_time");
		}	
		
		mysql_close($db_link);						
	}			
 ?>    
 
 <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="normal">
   <tr>
    <td width="130" height="25" class="objTitle" title="" >套餐名称：</td>
    <td width="220">
		<label><?php echo $product_name; ?></label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  
   <tr>
    <td height="25" class="objTitle" title="" >允许加速的域名个数：</td>
    <td width="220">
		<label><?php echo $domain_num; ?></label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
    
   <tr>
    <td height="25" class="objTitle" title="" >月度总流量数：</td>
    <td width="220">
		<label><?php echo PubFunc_MBToString($data_flow); ?></label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  	
   <tr>
    <td height="25" class="objTitle" title="" >套餐说明：</td>
    <td width="220">
		<label><?php echo $note; ?></label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  	
   <tr>
    <td height="25" class="objTitle" title="" >我的账户余额：</td>
    <td width="220">
		<label><?php echo $client_money; ?> 元</label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  	
   <tr>
    <td height="25" class="objTitle" title="" >套餐价格：</td>
    <td width="220">
		<label><?php echo $price; ?> 元/月</label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  	
   <tr>
    <td height="25" class="objTitle" title="" >购买月份数：</td>
    <td width="220">
		<label><?php echo $month; ?> 个月</label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  
  <tr>
    <td height="25" class="objTitle" title="" >支付总金额：</td>
    <td width="220">
		 <label><?php echo $total_money; ?> 元</label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
 
   <tr>
    <td height="25" class="objTitle" title="" >购买类型：</td>
    <td width="220">
	 	<label><?php echo $PubDefine_BuyTypeStr[$type]; ?></label>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
 
  	
   <tr>
    <td height="25" class="objTitle" title="" >备注：</td>
    <td width="220">
		<textarea id="txtBackup" name="txtBackup" maxlength="128" style="width:320px;height:46px;font-size:14px;border:1px solid #94C7E7;overflow:auto;" ><?php echo $note; ?></textarea>
	</td>
  </tr>  	
  <tr>
    <td height="15" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2">
	    <center><input name="btnPayOrder"  type="submit" style="width:95px;height:28px" id="btnPayOrder" value="支付" style="cursor:pointer;" onClick="FikCdn_PayOrderBox(<?php echo $order_id; ?>);" /></center></td>
  </tr>
  	
 </table>
 
  <table width="480" border="0">
	<tr>
	<td><p style="padding-left:20px;">说明：<br />
	1. 支付总金额 = 套餐价格 × 购买月份数；
	</p></td>
	</tr>
</table>

<?php

include_once("./tail.php");
?>
