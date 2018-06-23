<?php
include_once("./head.php");

// 组ID
$buy_id 		= isset($_GET['buy_id'])?$_GET['buy_id']:'';
?>
<script type="text/javascript">	
function FikCdn_RenewOrderBox(buy_id)
{
	var boxURL="product_renewal.php?id="+buy_id;
	showMSGBOX('',500,360,BT,BL,120,boxURL,'套餐续费:');
}

function selectPage(obj){
	var pagesSelect    =document.getElementById("pagesSelect").value;
	window.location.href="buy_list.php?page="+pagesSelect+"&action=ump";
}

function fiknode_search(){
	var txtKeyword    =document.getElementById("txtKeyword").value;
	var searchSelect  =document.getElementById("searchSelect").value;
	var txtGid		  =document.getElementById("grpSelect").value;
	
	if(txtKeyword.length==0 ){
		return;
	}	
	
	var getURL="./ajax_search.php?mod=search&action=domain"+"&type="+UrlEncode(searchSelect) +"&keyword="+UrlEncode(txtKeyword)+"&gid="+UrlEncode(txtGid);
	
	AjaxBasePost("search","domain","GET",getURL);			
}

function selectGroup(){
	var txtGid		 =document.getElementById("grpSelect").value;
	window.location.href="buy_list.php?page=1"+"&action=jump"+"&gid="+txtGid;
}

function FikCdn_SelectDomainStat(){
	parent.window.leftFrame.window.OnSelectNav("span_buy_product_bandwidth");
}

</script>

<div style="min-width:1100px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">已买套餐</span></td>
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
	  <td valign="top">
	
		<div id="div_search_result">	
		
		  <table width="800" border="0" class="dataintable" id="domain_table">
			<tr id="tr_domain_title">
				<th align="center" width="150" align="center">产品套餐名称</th>
				<th align="center" width="90">加速域名个数</th> 
				<th align="right" width="90">月度总流量</th> 	
				<th align="right" width="200">CNAME</th>	
				<th align="center" width="80">开通时间</th>
				<th align="center" width="80">到期时间</th>
				<th align="right" width="105">累计下载流量</th>
				<th align="right" width="105">累计请求量</th>
				
				<th align="center">操作</th>
			</tr>			
<?php
	$client_username 					=$_SESSION['fikcdn_client_username'];
	
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';
	
	if(!is_numeric($nPage))
	{
		$nPage=1;
	}
	
	if($nPage<=0)
	{
		$nPage = 1;
	}		
	
	if($action!="frist" && $action !="pagedown" && $action !="pageup" && $action !="tail" && $action !="jump")
	{
		$action="frist";
	}
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$client_username = mysql_real_escape_string($client_username); 
		
		do
		{
			$total_host 	= 0;
			
			$sql = "SELECT count(*) FROM fikcdn_buy WHERE username='$client_username';"; 
			
			$result = mysql_query($sql,$db_link);
			if($result&&mysql_num_rows($result)>0)
			{
				$total_host  = mysql_result($result,0,"count(*)");	
			}
			
			$total_pages = floor($total_host/$PubDefine_PageShowNum);
			if(($total_host%$PubDefine_PageShowNum)>0)
			{
				$total_pages+=1;
			}
			
			if($nPage>$total_pages)
			{
				$nPage = $total_pages;
			}
			
			$pagedown = $nPage+1;
			if($pagedown>$total_pages)
			{	
				$pagedown = $total_pages;			
			}
			
			$pageup = $nPage-1;
			if($pageup<=0)
			{
				$pageup = 1;
			}			
			$offset = (($nPage-1)*$PubDefine_PageShowNum);
			if($offset<0) $offset=0;
		
			$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username' Limit $offset,$PubDefine_PageShowNum;"; 
				
			//echo $sql;
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
			
			$timenow = time();
			$timeval1 = mktime(0,0,0,date("m",$timenow),1,date("Y",$timenow));
			
			for($i=0;$i<$row_count;$i++)
			{
				$id  			= mysql_result($result,$i,"id");	
				$product_id		= mysql_result($result,$i,"product_id");	
				$begin_time 	= mysql_result($result,$i,"begin_time");	
				$end_time  		= mysql_result($result,$i,"end_time");	
				$status   		= mysql_result($result,$i,"status");		
				$auto_renew		= mysql_result($result,$i,"auto_renew");
				$has_data_flow	= mysql_result($result,$i,"has_data_flow");	
				$domain_num		= mysql_result($result,$i,"domain_num");	
				$data_flow		= mysql_result($result,$i,"data_flow");	
				$note			= mysql_result($result,$i,"note");		
				$down_dataflow_total = mysql_result($result,$i,"down_dataflow_total");	
				$request_total = mysql_result($result,$i,"request_total");		
				$dns_cname		= mysql_result($result,$i,"dns_cname");			
				
				$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$product_name  		= mysql_result($result2,0,"name");
					//$product_name = $product_name.'('.$id.')';
				}
				
				/*
				$sql = "SELECT * FROM domain_stat_product_month WHERE buy_id='$id' AND time=$timeval1";
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$RequestCount  	= mysql_result($result2,0,"RequestCount");
					$UploadCount  	= mysql_result($result2,0,"UploadCount");
					$DownloadCount  = mysql_result($result2,0,"DownloadCount");
					$IpCount  		= mysql_result($result2,0,"IpCount");
				}
				
				if(strlen($RequestCount)<=0) $RequestCount=0;
				if(strlen($UploadCount)<=0) $UploadCount=0;
				if(strlen($DownloadCount)<=0) $DownloadCount=0;
				if(strlen($IpCount)<=0) $IpCount=0;
				*/
								
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)" '.'id="tr_domain_'.$id.'">';
				echo '<td>'.$product_name.'</td>';
				echo '<td>'.$domain_num.'</td>';
				echo '<td align="right">'.PubFunc_MBToString($data_flow).'</td>';
				echo '<td align="right">'.$dns_cname.'</td>';
				echo '<td>'.date("Y-m-d",$begin_time).'</td>';
				echo '<td>'.date("Y-m-d",$end_time).'</td>';
				echo '<td align="right">'.PubFunc_GBToString($down_dataflow_total).'</td>';
				echo '<td align="right">'.$request_total.'</td>';
				//echo '<td>'.$PubDefine_HostStatus[$status]. '</td>';				
				echo '<td>';			
				echo '<a href="javascript:void(0);" onclick="javescript:FikCdn_RenewOrderBox('.$id.');">续费</a>&nbsp;
					<a href="stat_buy_product_bandwidth.php?buy_id='.$id.'"  onclick="javescript:FikCdn_SelectDomainStat();" >流量统计</a>&nbsp;</td>';
				echo '</tr>';
			}
		}while(0);
		
		mysql_close($db_link);
	}
?>
		 </table></div>
		 <table width="800" border="0" class="disc">
			<tr>
			<td bgcolor="#FFFFE6"><div class="div_page_bar"> 记录总数：<?php echo $total_host;?>条&nbsp;&nbsp;&nbsp;当前第<?php echo $nPage; ?>页|共<?php echo $total_pages; ?>页&nbsp;&nbsp;&nbsp;跳转
				<select id="pagesSelect" name="pagesSelect" style="width:50px" onChange="selectPage(this)">
				<?php
					for($i=1;$i<=$total_pages;$i++){
						if($nPage==$i)
						{
							echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
						}
						else
						{
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>							
				</select>
				页&nbsp;&nbsp;&nbsp;&nbsp;<a href="buy_list.php?page=1&action=first&gid=<?php echo $nGid; ?>">首页</a>&nbsp;&nbsp;
				<a href="buy_list.php?page=<?php echo $pageup; ?>&action=pageup&gid=<?php echo $nGid; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="buy_list.php?page=<?php echo $pagedown; ?>&action=pagedown&gid=<?php echo $nGid; ?>">下一页</a>&nbsp;&nbsp;
				<a href="buy_list.php?page=<?php echo $total_pages; ?>&action=tail&gid=<?php echo $nGid; ?>">尾页 </a></div></td>
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
