<?php
include_once("./head.php");
?>
<script type="text/javascript">
function FikCdn_BuyProductBox(product_id)
{
	var boxURL="product_buy.php?id="+product_id;
	showMSGBOX('',500,310,BT,BL,120,boxURL,'购买套餐:');
}
</script>

<div style="min-width:1080px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr>
				<td height="31"><div class="title_bt">产品套餐</div></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td> 
	  <td valign="top">
		  <table width="800" border="0" class="dataintable">
			<tr>
				<th align="center" width="50">序号</th> 
				<th align="center" width="240">套餐名称</th>
				<th align="right" width="80">加速域名个数</th>
				<th align="right" width="90">月度总流量</th>
				<th align="right" width="75">套餐价格</th>
				<th align="right" width="210">CNAME</th>
				<th align="center" width="200">产品说明</th>    
				<th align="center">操作</th>
			</tr>			
<?php	

	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		do
		{
			$sql = "SELECT * FROM fikcdn_product WHERE is_online=1;"; 
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				break;
			}
			
			$row_count=mysql_num_rows($result);
			if(!$row_count)
			{
				break;
			}
			
			for($i=0;$i<$row_count;$i++)
			{
				$id  			= mysql_result($result,$i,"id");	
				$name   		= mysql_result($result,$i,"name");
				$price   		= mysql_result($result,$i,"price");		
				$data_flow   	= mysql_result($result,$i,"data_flow");	
				$domain_num		= mysql_result($result,$i,"domain_num");
				$begin_time		= mysql_result($result,$i,"begin_time");
				$is_checks		= mysql_result($result,$i,"is_checks");
				$note			= mysql_result($result,$i,"note");
				$group_id		= mysql_result($result,$i,"group_id");
				$dns_cname		= mysql_result($result,$i,"dns_cname");
				
				$sql = "SELECT count(*) FROM fikcdn_node WHERE groupid=$id;"; 
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$node_count = mysql_result($result2,0,"count(*)");	
				}
				
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$name.'</td>';
				echo '<td align="right">'.$domain_num.' 个</td>'; 
				echo '<td align="right">'.PubFunc_MBToString($data_flow).'</td>';
				echo '<td align="right">'.$price.' 元/月</td>';
				echo '<td align="right">'.$dns_cname.'</td>';
				echo '<td>'.$note.'</td>'; 				
				echo '<td><a href="javascript:void(0);" onclick="javescript:FikCdn_BuyProductBox('.$id.');" title="购买产品套餐">购买产品</a>&nbsp;&nbsp</td></tr>';
			}
		}while(0);
		
		mysql_close($db_link);
	}
?>


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
