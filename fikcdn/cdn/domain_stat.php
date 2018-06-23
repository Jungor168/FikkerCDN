<?php
include_once("./head.php");
?>
<script type="text/javascript">	
function FikCdn_DomainDel(domain_id){
	var returnVal = window.confirm("您确认要删除此域名吗？","删除域名");
	if(!returnVal){
		return;
	}
	var postURL="./ajax_domain.php?mod=domain&action=del";
	var postStr="domain_id="+domain_id;
	
	AjaxClientBasePost("domain","del","POST",postURL,postStr);		
}

function FikCdn_DomainStart(domain_id)
{	
	var returnVal = window.confirm("您确认要开启此域名的加速吗？","开启加速");
	if(!returnVal){
		return;
	}
	var postURL="./ajax_domain.php?mod=domain&action=start";
	var postStr="domain_id="+domain_id;
	
	AjaxClientBasePost("domain","start","POST",postURL,postStr);		
}

function FikCnd_DomainStop(domain_id)
{
	var returnVal = window.confirm("您确认要暂停此域名的加速吗？","暂停加速");
	if(!returnVal){
		return;
	}
	var postURL="./ajax_domain.php?mod=domain&action=stop";
	var postStr="domain_id="+domain_id;
	
	AjaxClientBasePost("domain","stop","POST",postURL,postStr);	
}

function selectPage(obj){
	var pagesSelect    =document.getElementById("pagesSelect").value;
	window.location.href="domain_list.php?page="+pagesSelect+"&action=ump";
}

</script>

<div style="min-width:1160px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">域名列表</span></td>
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
				<th align="center" width="160">网站域名</th>
				<th align="center" width="140">统计开始时间</th>
				<th align="center" width="140" align="center">统计结束时间</th>
				<th align="center" width="145" align="center">用户访问量</th>
				<th align="center" width="85" align="center">独立IP数</th>		
				<th align="center" width="65" align="center">用户上传量</th>
				<th align="center" width="85" align="center">用户下载量</th>
				<th align="center" width="85" align="center">用户下载量</th>				
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
		do
		{
			$total_host 	= 0;
			
			$sql = "SELECT count(*) FROM fikcdn_domain WHERE username='$client_username';"; 
			
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
		
			$sql = "SELECT * FROM fikcdn_domain WHERE username='$client_username' Limit $offset,$PubDefine_PageShowNum;"; 
				
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
			
			for($i=0;$i<$row_count;$i++)
			{
				$id  			= mysql_result($result,$i,"id");	
				$hostname  		= mysql_result($result,$i,"hostname");	
				$username	 	= mysql_result($result,$i,"username");	
				$add_time  		= mysql_result($result,$i,"add_time");	
				$status   		= mysql_result($result,$i,"status");	
				$buy_id	   		= mysql_result($result,$i,"buy_id");		
				$upstream		= mysql_result($result,$i,"upstream");
				$begin_time		= mysql_result($result,$i,"begin_time");	
				$end_time		= mysql_result($result,$i,"end_time");		
			
				$admin_url = $ip.":"."$admin_port"."/fikker/";	
				
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)" '.'id="tr_domain_'.$id.'">';
				echo '<td>'.$hostname.'</td>';
				echo '<td>'.date("Y-m-d H:i:s",$add_time).'</td>';
				echo '<td>'.date("Y-m-d H:i:s",$add_time).'</td>';
				echo '<td>'.'0'.'</td>';
				echo '<td>'.'0'. '</td>';	
				echo '<td>'.'0'.'</td>';
				echo '<td>'.'0'.'</td>';		
				echo '<td>'.'0'.'</td>';			
				echo '<td>';
				echo '&nbsp;<a href="javascript:void(0);" onclick="javescript:FikCdn_DomainDel('.$id.');" title="详细统计信息">详细统计信息</a> </td>';
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
				页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="domain_list.php?page=1&action=first&gid=<?php echo $nGid; ?>">首页</a>&nbsp;&nbsp;
				<a href="domain_list.php?page=<?php echo $pagedown; ?>&action=pagedown&gid=<?php echo $nGid; ?>">下一页</a>&nbsp;&nbsp;
				<a href="domain_list.php?page=<?php echo $pageup; ?>&action=pageup&gid=<?php echo $nGid; ?>">上一页</a>&nbsp;&nbsp;
				<a href="domain_list.php?page=<?php echo $total_pages; ?>&action=tail&gid=<?php echo $nGid; ?>">尾页 </a></div></td>
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
