<?php

include_once('../db/db.php');
include_once('../function/pub_function.php');
include_once('../function/define.php');
include_once('../function/fik_api.php');
include_once("function.php");

//是否登录
if(!FuncClient_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}

$sMod 	 	 = isset($_GET['mod'])?$_GET['mod']:'';
$sAction 	 = isset($_GET['action'])?$_GET['action']:'';

if($sMod=='buy')
{
	
}
else if($sMod=='order')
{
	if($sAction=="add")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$product_id = isset($_POST['product_id'])?$_POST['product_id']:'';
		$month 	= isset($_POST['month'])?$_POST['month']:'';
		$txtNote = isset($_POST['note'])?$_POST['note']:'';
		
		if( !is_numeric($product_id) || !is_numeric($month) || $month<=0 || strlen($txtNote)>128)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$txtNote = htmlspecialchars($txtNote);
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$txtNote = mysql_real_escape_string($txtNote);
			
			//产品套餐
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$domain_num  = mysql_result($result,0,"domain_num");
			$data_flow  = mysql_result($result,0,"data_flow");
			$price  = mysql_result($result,0,"price");
			$group_id = mysql_result($result,0,"group_id");
			
			if($price<0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，套餐价格错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}

			/*
			//我是否已经购买了此产品
			$sql = "SELECT * FROM fikcdn_buy WHERE product_id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，我已经购买了此产品，请选择续费。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			*/
			
			$total_money = ($price*$month);
			$timenow = time();
				
			$frist_month_money = (round($price/30,0))*(30-date("d"));
			if($frist_month_money<=0)
			{
				$frist_month_money=0;
			}
			
			//增加到订单列表中
			$sql = "INSERT INTO fikcdn_order(id,username,product_id,buy_time,status,auto_renew,price,month,type,domain_num,data_flow,note,frist_month_money) 
						VALUES(NULL,'$client_username',$product_id,$timenow,1,1,$price,$month,$PubDefine_BuyTypeNew,$domain_num,$data_flow,'$txtNote',$frist_month_money)";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'添加到订单列表失败，写入数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$order_id = mysql_insert_id($db_link);
			
			$aryResult = array('Return'=>'True','order_id'=>$order_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);									
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'添加到订单列表失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}			
	}
	else if($sAction=="renewal")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$buy_id = isset($_POST['buy_id'])?$_POST['buy_id']:'';
		$month 	= isset($_POST['month'])?$_POST['month']:'';
		$txtNote = isset($_POST['note'])?$_POST['note']:'';
		
		if( !is_numeric($buy_id) || !is_numeric($month) || $month<=0 || strlen($txtNote)>128)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$txtNote = htmlspecialchars($txtNote);
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$txtNote = mysql_real_escape_string($txtNote);
			
			//我是否已经购买了此产品
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，记录不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$product_id = mysql_result($result,0,"product_id");
			$begin_time	= mysql_result($result,0,"begin_time");
			$end_time	= mysql_result($result,0,"end_time");
			$status		= mysql_result($result,0,"status");
			$price 		= mysql_result($result,0,"price");
			$auto_renew	= mysql_result($result,0,"auto_renew");	
			$has_data_flow	= mysql_result($result,0,"has_data_flow");	
			$data_flow	= mysql_result($result,0,"data_flow");	
			$domain_num = mysql_result($result,0,"domain_num");
			$note	 	= mysql_result($result,0,"note");
					
			//产品套餐
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$product_domain_num  = mysql_result($result,0,"domain_num");
			$product_data_flow  = mysql_result($result,0,"data_flow");
			$product_price  = mysql_result($result,0,"price");
			$product_group_id = mysql_result($result,0,"group_id");
			
			if($price<0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'添加到订单列表失败，套餐价格错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$total_money = ($price*$month);
			$timenow = time();
			
			$frist_month_money = $price;
			
			//增加到订单列表中
			$sql = "INSERT INTO fikcdn_order(id,username,product_id,buy_time,status,auto_renew,price,month,type,domain_num,data_flow,note,buy_id,frist_month_money) 
						VALUES(NULL,'$client_username',$product_id,$timenow,1,1,$price,$month,$PubDefine_BuyTypeRenew,$domain_num,$data_flow,'$txtNote',$buy_id,'$frist_month_money')";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'添加到订单列表失败，写入数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$order_id = mysql_insert_id($db_link);
			
			$aryResult = array('Return'=>'True','order_id'=>$order_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);									
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'添加到订单列表失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}		
	}
	else if($sAction=="del")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$order_id 	= isset($_POST['order_id'])?$_POST['order_id']:'';
		
		if(!is_numeric($order_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}		
	
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{				
			$sql="SELECT * FROM fikcdn_order WHERE id='$order_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'删除的订单失败，您要删除的订单不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}		
		
			$product_id 	= mysql_result($result,0,"product_id");
			$username 		= mysql_result($result,0,"username");			
			
			if(strlen($username)<=0 ||$username !=$client_username)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'删除的订单失败，您不能删除不属于您的订单。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$sql = "DELETE FROM fikcdn_order WHERE id=$order_id";
			$result = mysql_query($sql,$db_link);
			if(!result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'删除的订单失败，操作数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}			
		
			$aryResult = array('Return'=>'True','id'=>$order_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);	
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'删除的订单失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
	}
	else if($sAction=="pay")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$order_id = isset($_POST['order_id'])?$_POST['order_id']:'';
		$txtNote = isset($_POST['note'])?$_POST['note']:'';
		
		if( !is_numeric($order_id) || strlen($txtNote)>128)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}	
	
		$txtNote = htmlspecialchars($txtNote);
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$txtNote = mysql_real_escape_string($txtNote);
			
			//产品订单
			$sql = "SELECT * FROM fikcdn_order WHERE id='$order_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'支付订单列表失败，订单不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);				
			}	
			
			$id  			= mysql_result($result,0,"id");	
			$username   	= mysql_result($result,0,"username");
			$product_id   	= mysql_result($result,0,"product_id");
			$buy_time  		= mysql_result($result,0,"buy_time");	
			$status   		= mysql_result($result,0,"status");	
			$type   		= mysql_result($result,0,"type");	
			$price		   	= mysql_result($result,0,"price");
			$month	   		= mysql_result($result,0,"month");
			$domain_num		= mysql_result($result,0,"domain_num");
			$data_flow 	    = mysql_result($result,0,"data_flow");
			$auto_renew  	= mysql_result($result,0,"auto_renew");
			$buy_id  		= mysql_result($result,0,"buy_id");
			$note  			= mysql_result($result,0,"note");
			
			$is_buy_expire = false;
			
			$frist_month_money= mysql_result($result,0,"frist_month_money");
			
			if($type!=$PubDefine_BuyTypeNew && $type!=$PubDefine_BuyTypeRenew)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'支付订单列表失败，订单信息错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$total_money = $price*$month;
			if($total_money<0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrPrice,'ErrorMsg'=>'订单支付失败，产品套餐价格信息错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
				
			if($type==$PubDefine_BuyTypeRenew)
			{			
				$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username';"; 
				$result = mysql_query($sql,$db_link);
				if(!$result || mysql_num_rows($result)<=0)
				{
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'支付订单列表失败，您要续费的已购买套餐不存在。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}

				$this_end_time	= mysql_result($result,0,"end_time");
				
				//续费前是否已经过期
				if(time()>=$this_end_time)
				{
					$is_buy_expire = true;
				}
			}	
						
			//产品套餐
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'订单支付失败，产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$group_id = mysql_result($result,0,"group_id");
			$dns_cname = mysql_result($result,0,"dns_cname");
			
			//查找用户余额
			$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username' ;"; 
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoUser,'ErrorMsg'=>'订单支付失败，登录用户不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$client_money = mysql_result($result,0,"money");
			$enable_login = mysql_result($result,0,"enable_login");
			
			if(!$enable_login)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrForbidLogin,'ErrorMsg'=>'订单支付失败，您的用户帐号已经被冻结。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			//余额不足
			if($total_money>$client_money)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoMoney,'ErrorMsg'=>'订单支付失败，您的账户余额不足。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			mysql_query("START TRANSACTION",$db_link);
			
			$sql ="UPDATE fikcdn_client SET money=money-$total_money WHERE username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				mysql_query("ROLLBACK",$db_link);
				
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'订单支付失败，更新数据库记录失败。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			//查找用户余额
			$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username' ;"; 
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoUser,'ErrorMsg'=>'订单支付失败，登录用户不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$this_client_money = mysql_result($result,0,"money");
			$timenow = time();
			if($type==$PubDefine_BuyTypeNew)
			{
				$next_month = date("m")+$month;
				
				//Y-m-d H:i:s
				$end_time = mktime(date("H"),date("i"),date("s"),$next_month,date("d"),date("Y"));
				
				//插入一个购买产品
				$sql = "INSERT INTO fikcdn_buy(id,username,product_id,begin_time,end_time,status,auto_renew,price,has_data_flow,domain_num,data_flow,note,dns_cname)
							VALUES(NULL,'$client_username',$product_id,$timenow,$end_time,1,$auto_renew,$price,$data_flow,$domain_num,$data_flow,'$txtNote','$dns_cname')";
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{
					mysql_query("ROLLBACK",$db_link);
					
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'订单支付失败，插入数据库记录失败。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}
				
				$buy_id = mysql_insert_id($db_link);
			}
			else
			{
				//过期3天都从过期日算起, 否则从当前之日算起
				if($timenow<=$this_end_time)
				{
					$next_month = date("m",$this_end_time)+$month;
					$end_time = mktime(date("H",$this_end_time),date("i",$this_end_time),date("s",$this_end_time),$next_month,date("d",$this_end_time),date("Y",$this_end_time));
				}
				else
				{
					$next_month = date("m")+$month;
					$end_time = mktime(date("H"),date("i"),date("s"),$next_month,date("d"),date("Y"));
				}
				
				$sql = "UPDATE fikcdn_buy SET end_time='$end_time',auto_renew=$auto_renew,domain_num=$domain_num,data_flow=$data_flow,note='$txtNote' WHERE id='$buy_id'";
				$result = mysql_query($sql,$db_link);				
				if(!$result)
				{
					mysql_query("ROLLBACK",$db_link);
					
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'订单支付失败，更新数据库记录失败。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}
			}
			$client_ip = PubFunc_GetRemortIP();
			
			//插入一个购买记录
			$sql = "INSERT INTO fikcdn_buyhistory(id,username,buy_id,price,month,buy_time,end_time,type,auto_renew,domain_num,data_flow,balance,ip,note,frist_month_money)
						VALUES(NULL,'$client_username',$buy_id,$price,$month,$timenow,$end_time,$type,$auto_renew,$domain_num,$data_flow,$this_client_money,'$client_ip','$txtNote',$frist_month_money)";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				mysql_query("ROLLBACK",$db_link);
				
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'订单支付失败，插入数据库记录失败。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			$buy_histroy_id = mysql_insert_id($db_link);
			
			//删除订单
			$sql = "DELETE FROM fikcdn_order WHERE id='$order_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				mysql_query("ROLLBACK",$db_link);
				
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'订单支付失败，删除数据库记录失败。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			mysql_query("COMMIT",$db_link);
			
			//echo 'is_buy_expire='.$is_buy_expire;
			
			//如果之前套餐到期，就需要重新启用套餐内的域名
			if($is_buy_expire)
			{
				//查找这个套餐的所有域名，并且启用
				$sql = "SELECT * FROM fikcdn_domain WHERE buy_id='$buy_id'";
				$result10 = mysql_query($sql,$db_link);
				$row_count10 = mysql_num_rows($result10);
				if($result10 && $row_count10>0)
				{
					for($iii=0;$iii<$row_count10;$iii++)
					{
						$start_domain_id	 = mysql_result($result10,$iii,"id");
						$start_group_id = mysql_result($result10,$iii,"group_id");
						$start_hostname = mysql_result($result10,$iii,"hostname");
						$stop_status = mysql_result($result10,$iii,"status");
						
						if($stop_status==$PubDefine_HostStatusStop)
						{
							//修改域名状态为启用
							$sql = "UPDATE fikcdn_domain SET status=$PubDefine_HostStatusOk WHERE id=$start_domain_id";
							$result21 = mysql_query($sql,$db_link);
							
							//删除还没有执行完成的任务
							$sql = "DELETE FROM fikcdn_task WHERE domain_id=$start_domain_id AND type=$PubDefine_TaskModifyDomainStatus";
							$result22 = mysql_query($sql,$db_link);
							
							$sql = "SELECT * FROM fikcdn_node WHERE groupid='$start_group_id'";	
							$result11 = mysql_query($sql,$db_link);
							$row_count11 = mysql_num_rows($result11);
							if($result11 && $row_count11>0)
							{
								for($kkk=0;$kkk<$row_count11;$kkk++)
								{
									$start_node_id	 = mysql_result($result11,$kkk,"id");
									$start_node_ip 		 = mysql_result($result11,$kkk,"ip");
									$start_node_password	 = mysql_result($result11,$kkk,"password");
									$start_node_admin_port = mysql_result($result11,$kkk,"admin_port");
									$start_node_auth_domain= mysql_result($result11,$kkk,"auth_domain");
									$start_node_SessionID	 = mysql_result($result11,$kkk,"SessionID");
									
									//加入后台任务
									$timenow2 = time();
									$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id) 
									VALUES(NULL,'$client_username',$PubDefine_TaskModifyDomainStatus,$timenow2,$start_domain_id,$start_node_id,$product_id,$buy_id,'$start_hostname',$start_group_id)";
									$result12 = mysql_query($sql,$db_link);
								}	
							}
						}
					}
				}
			}
			
			$aryResult = array('Return'=>'True','buy_id'=>$buy_id,'buy_histroy_id'=>$buy_histroy_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);	
		}		
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'订单支付失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
	}
	else if($sAction=="submit")
	{
		$nMoney= isset($_POST['Money'])?$_POST['Money']:'';
		$txtCheckNum= isset($_POST['CheckNum'])?$_POST['CheckNum']:'';
		$txtNote =isset($_POST['Note'])?$_POST['Note']:'';
		
		if(strlen($txtCheckNum)<=0 || strlen($txtCheckNum)>20 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'请输入验证码。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		$nMoney =(int)$nMoney;
		if(!is_int($nMoney))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'请输入正确的充值金额。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}

		//$AuthNum = trim($AuthNum);
				
		$txtNote = htmlspecialchars($txtNote);
		$txtCheckNum = htmlspecialchars($txtCheckNum);

		$sPayCheckCode = $_SESSION['PayCheckCode'];
		if($sPayCheckCode!=$txtCheckNum)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'请输入正确的验证码。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$_SESSION['PayCheckCode']="";
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$txtNote = mysql_real_escape_string($txtNote);
			
			$client_username	=$_SESSION['fikcdn_client_username'];
			
			//查询这个用户的信息
			$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'提交充值错误，此用户不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
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
			
			$order_time = time();
			$client_ip = PubFunc_GetRemortIP(); //$_SERVER["REMOTE_ADDR"]; 
			/*
			//被冻结的帐号需解冻后再购买
			if(!$agents_enable_login)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrForbidLogin,'ErrorMsg'=>'此账户已经被冻结，不能充值授权。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			*/
			
			$year_code = array('a','b','c','d','e','f','g','h','i','j');
			$order_id = $year_code[intval(date('y'))-2010].strtoupper(dechex(date('m'))).date('d').
								substr(time(),-5).substr(microtime(),2,5).sprintf('d',rand(0,99));
			$order_id = strtoupper($order_id);		
								
			//插入到订单
			$sql = "INSERT INTO fikcdn_recharge(id,order_id,username,time,sub_ip,money,status,bank_name,balance,note) VALUES(NULL,'$order_id','$client_username','$order_time','$client_ip','$nMoney','1','支付宝','$money','$txtNote')";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				//echo mysql_error();
				//echo '<br/>'.$sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'提交订单错误，插入数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$insert_id = mysql_insert_id($db_link);
			
			$aryResult = array('Return'=>'True','id='=>$insert_id,'order_id'=>$order_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'提交订单错误，连接数据库失败。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
	}
	else if($sAction=="rechdel")
	{
		$order_id	 = isset($_POST['order_id'])?$_POST['order_id']:'';
		
		if(strlen($order_id)<=0 || strlen($order_id)>32 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误，无订单号。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
			
		$order_id = htmlspecialchars($order_id);
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$order_id = mysql_real_escape_string($order_id);
			
			$client_username	=$_SESSION['fikcdn_client_username'];			
			
			$sql = "DELETE FROM fikcdn_recharge WHERE order_id='$order_id' AND username='$client_username';";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'删除订单错误，数据库删除操作失败。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True','order_id'=>$order_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'删除订单错误，连接数据库失败。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}	
	}		
}

?>
