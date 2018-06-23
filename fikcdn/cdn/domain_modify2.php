<?php
include_once("head.php");
?>

<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
function FikCdn_ModifyDomain(domain_id){
	var txtSrcIP     =document.getElementById("txtSrcIP").value;
	var txtUnicomIP   =document.getElementById("txtUnicomIP").value;
	var txtBackup    =document.getElementById("txtBackup").value;
	var txtICP     =document.getElementById("txtICP").value;
	var txtDNSName     =document.getElementById("txtDNSName").value;
		
	if (txtSrcIP.length==0 && txtUnicomIP.length==0){ 
	  	document.getElementById("tipsSrcIP").innerHTML="请输入域名对应源站IP地址 (联通或电信至少填一个)";
		document.getElementById("txtSrcIP").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsSrcIP").innerHTML="";
	}	
	
	var postURL="./ajax_domain.php?mod=domain&action=modify";
	var postStr="domain_id="+UrlEncode(domain_id) + "&srcip=" + UrlEncode(txtSrcIP) + "&unicom_ip="+UrlEncode(txtUnicomIP)+
				"&icp=" + UrlEncode(txtICP) +"&dns_name=" + UrlEncode(txtDNSName) + "&backup=" + UrlEncode(txtBackup);
					 
	AjaxClientBasePost("domain","modify","POST",postURL,postStr);	
}

</script>


<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">修改域名信息</span></td>
				<td width="95%"></td>
			</tr>	
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>  
<?php
	$domain_id = isset($_GET['id'])?$_GET['id']:'';
 	$client_username 	=$_SESSION['fikcdn_client_username'];
	
 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		
		$sql = "SELECT * FROM fikcdn_domain WHERE id='$domain_id' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			exit();
		}
	
		$hostname 	= mysql_result($result,0,"hostname");
		$username 	= mysql_result($result,0,"username");
		$buy_id		= mysql_result($result,0,"buy_id");	
		$add_time 	= mysql_result($result,0,"add_time");
		$status 	= mysql_result($result,0,"status");
		$upstream 	= mysql_result($result,0,"upstream");
		$unicom_ip 	= mysql_result($result,0,"unicom_ip");
		$use_transit_node 	= mysql_result($result,0,"use_transit_node");
		$icp 	= mysql_result($result,0,"icp");
		$DNSName 	= mysql_result($result,0,"DNSName");
		$note	 	= mysql_result($result,0,"note");
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
				<td width="200" height="35" align="right"><span class="input_tips_txt3">加速的网站域名：</span></td>
				<td><label><?php echo $hostname; ?></label><span class="input_tips_txt" id="tipsDomain" ></span> </td>
    		</tr>	
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt5"></span><span class="input_tips_txt3">源站电信 IP 地址：</span></td>
				<td><input id="txtSrcIP" name="txtSrcIP" type="text" size="36" maxlength="64"  value='<?php echo $upstream; ?>' /> <span class="input_tips_txt" id="tipsSrcIP" ></span>  </td>
    		</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">源站联通 IP 地址：</span></td>
				<td><input id="txtUnicomIP" type="text" size="36" maxlength="64" value='<?php echo $unicom_ip; ?>'  /><span class="input_tips_txt4" id="tipsUnicomIP" ></span>  </td>
    		</tr>	
<?php						
	/*		<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3"></span></td>
				<td><span class="input_tips_txt3"><input id="txtUseransit" type="checkbox" class="checkbox" <?php if($use_transit_node) echo "checked=checked";?> />&nbsp;启用中转服务器</span><span class="input_tips_txt4" id="tipsUseransit"></span> </td>
    		</tr>		
			*/		
?>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt"></span><span class="input_tips_txt3">域名ICP备案号：</span></td>
				<td><input id="txtICP" type="text" size="36" maxlength="64"  value="<?php echo $icp; ?>"/> <span class="input_tips_txt" id="tipsICP" ></span>  </td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt"></span><span class="input_tips_txt3">DNS别名(CNAME)：</span></td>
				<td><input id="txtDNSName" type="text" size="36" maxlength="64" value="<?php echo $DNSName; ?>" /> <span class="input_tips_txt" id="tipsDNSName" ></span>  </td>
    		</tr>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"><span class="input_tips_txt3">产品套餐：</span></td>
				<td>
 <?php
	
	if($db_link)
	{
		//查询产品所属服务器组
		$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{
			$product_id	= mysql_result($result,0,"product_id");
			
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result2 = mysql_query($sql,$db_link);
			if($result2 && mysql_num_rows($result2)>0)
			{
				$product_name  			= mysql_result($result2,0,"name");	
				echo '<label>'.$product_name.'</label>';		
			}
		}
		
		mysql_close($db_link);
	}			
 ?>
				<span class="input_tips_txt" id="tipsProductSelect" ></span> </td>
			</tr>		
<?php			
			/*	
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">到期时间：</td>
				<td><input id="txtExpire" name="txtExpire" type="text" size="16" maxlength="16" onclick="new Calendar(2012,2030).show(this);" readonly="readonly" />  <span class="input_tips_txt" id="tipsExpire" name="tipsExpire" ></span> </td>
    		</tr>	

			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right"></td>
				<td><input name="IsStartDomain" id="IsStartDomain" type="checkbox" value="1" class="checkbox" checked="checked" />
					 立即开启域名加速
					<span class="input_tips_txt" id="tipsExpire" name="tipsExpire" ></span> </td>
    		</tr>
	
					
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">可缓存的文件扩展名：</td>
				<td><input id="txtExName" name="txtExName" type="text" size="66" maxlength="128" value=".html|.htm|.js|.css|.jpg|.bmp|.gif|.txt" />  <span class="input_tips_txt" id="tipsExName" name="tipsExName" ></span> </td>
    		</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">目录缓存设置：</td>
				<td><label><input id="isCacheDir" type="checkbox" name="isCacheDir" value="1">是否缓存网站目录页面</label><span class="input_tips_txt" id="tipsisCacheDir" name="tipsisCacheDir" ></span> </td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">缓存过期时间：</td>
				<td><input id="nCacheExpire" name="nCacheExpire" type="text" size="8" maxlength="8" value="1440" /> 分钟 <span class="input_tips_txt" id="tipsCacheExpire" name="tipsCacheExpire" ></span> </td>
    		</tr>
			*/
?>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" align="right"><span class="input_tips_txt3">备注：</span></td>
				<td><textarea id="txtBackup" name="txtBackup" maxlength="218" cols="80" rows="3" ><?php echo $note; ?></textarea> </td>
    		</tr>	
			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="center"> </td>
				<td>
				<input id="btn_ModifyDomain"  type="submit" style="width:80px;height:28px" value="修改" style="cursor:pointer;" onClick="FikCdn_ModifyDomain(<?php echo $domain_id; ?>);" /> 
				</td>
    		</tr>
		 </table>
		 <p></p>
		 <table width="800" border="0" class="disc">
			<tr>
			<td bgcolor="#FFFFE6"><p style="padding-left:70px">说明：<br />
			    1. 源站的电信 IP 和联通 IP 至少需要填写一个，如果是其他运营商的线路，则可以默认填写到电信源站IP栏；<br />
				2. 源站IP修改成功后，后台会需要几分钟时间同步到所有加速节点服务器，请耐心等待；
			</p></td>
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
