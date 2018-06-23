<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */

require_once("alipay.config.php");
require_once("alipay_api/lib/alipay_notify.class.php");

include_once('../db/db.php');
include_once('../function/pub_function.php');
include_once("function.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title>Fikker CDN系统在线充值</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.title{
    color: #ADADAD;
    font-size: 14px;
    font-weight: bold;
    padding: 8px 16px 5px 10px;
}
.hidden{
	display:none;
}

.new-btn-login-sp{
	border:1px solid #D74C00;
	padding:1px;
	display:inline-block;
}

.new-btn-login{
    background-color: transparent;
    background-image: url("images/new-btn-fixed.png");
    border: medium none;
}
.new-btn-login{
    background-position: 0 -198px;
    width: 82px;
	color: #FFFFFF;
    font-weight: bold;
    height: 28px;
    line-height: 28px;
    padding: 0 10px 3px;
}
.new-btn-login:hover{
	background-position: 0 -167px;
	width: 82px;
	color: #FFFFFF;
    font-weight: bold;
    height: 28px;
    line-height: 28px;
    padding: 0 10px 3px;
}
.bank-list{
	overflow:hidden;
	margin-top:5px;
}
.bank-list li{
	float:left;
	width:153px;
	margin-bottom:5px;
}

#main{
	width:750px;
	text-align:center;
	margin:0 auto;
	padding-top:50px;
	font-size:14px;
	font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
	font-size: 15px;
}
#logo{
	background-color: transparent;
    background-image: url("images/new-btn-fixed.png");
    border: medium none;
	background-position:0 0;
	width:166px;
	height:35px;
    float:left;
}
.red-star{
	color:#f00;
	width:10px;
	display:inline-block;
}
.null-star{
	color:#fff;
}
.content{
	margin-top:5px;
}

.content dt{
	width:160px;
	display:inline-block;
	text-align:right;
	float:left;
	
}
.content dd{
	margin-left:100px;
	margin-bottom:5px;
}
#foot{
	margin-top:10px;
}
.foot-ul li {
	text-align:center;
}
.note-help {
    color: #999999;
    font-size: 12px;
    line-height: 130%;
    padding-left: 3px;
}

.cashier-nav {
    font-size: 14px;
    margin: 15px 0 10px;
    text-align: left;
    height:30px;
    border-bottom:solid 2px #CFD2D7;
}
.cashier-nav ol li {
    float: left;
}
.cashier-nav li.current {
    color: #AB4400;
    font-weight: bold;
}
.cashier-nav li.last {
    clear:right;
}
.alipay_link {
    text-align:right;
}
.alipay_link a:link{
    text-decoration:none;
    color:#8D8D8D;
}
.alipay_link a:visited{
    text-decoration:none;
    color:#8D8D8D;
}
</style>
</head>
<body text=#000000 bgColor=#ffffff leftMargin=0 topMargin=4>
	<div id="main">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) 
{//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];
	
	//$out_trade_no = "4139808835259D";
	//$trade_no = "4139808835259D33232";
	//$trade_status = 'TRADE_FINISHED';

    if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//如果有做过处理，不执行商户的业务程序
			
		$db_link = FikCDNDB_Connect();
		if(!$db_link)
		{
			exit("数据库连接错误。");
		}
		
		$sql = "SELECT * FROM fikcdn_recharge WHERE order_id='$out_trade_no'";
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			exit("您支付的订单不存在。");
		}
		
		$id  			= mysql_result($result,0,"id");	
		$order_id   	= mysql_result($result,0,"order_id");
		$status   		= mysql_result($result,0,"status");
		$username   	= mysql_result($result,0,"username");
		$rechgmoney		= mysql_result($result,0,"money");	
		$time  		 	= mysql_result($result,0,"time");	
		$transactor   	= mysql_result($result,0,"transactor");	
		$bank_name   	= mysql_result($result,0,"bank_name");	
		$serial_no   	= mysql_result($result,0,"serial_no");
		$balance	   	= mysql_result($result,0,"balance");
		$note   	    = mysql_result($result,0,"note");
			
		//等待付款状态
		if($status==1)
		{
			mysql_query("START TRANSACTION",$db_link);
		
			$sql = "SELECT * FROM fikcdn_client WHERE username='$username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				exit("充值用户帐号不存在。");
			}
			
			$id  			=mysql_result($result2,0,"id");
			$real_name		=mysql_result($result2,0,"realname");	
			$phone 			=mysql_result($result2,0,"phone");	
			$qq 			=mysql_result($result2,0,"qq");
			$addr 			=mysql_result($result2,0,"addr");
			$note			=mysql_result($result2,0,"note");
			$curmoney		=mysql_result($result2,0,"money");
			$enable_login	=mysql_result($result2,0,"enable_login");
			$last_login_ip	=mysql_result($result2,0,"last_login_ip");
			$last_login_time=mysql_result($result2,0,"last_login_time");
			$login_count	=mysql_result($result2,0,"login_count");		
						
			$pay_time = time();
				
			//充值
			$sql="UPDATE fikcdn_client SET money=money+$rechgmoney WHERE username='$username';";			
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{   
				mysql_query("ROLLBACK",$db_link);   
				
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$sql = "SELECT * FROM fikcdn_client WHERE username='$username'";
			$result2 = mysql_query($sql,$db_link);
			if($result2 && mysql_num_rows($result2)>0)
			{
				$client_id      =mysql_result($result2,0,"id");
				$curmoney	   	=mysql_result($result2,0,"money");
				
				$sql="UPDATE fikcdn_recharge SET status='0',time='$pay_time',ali_trade_no='$trade_no' WHERE order_id='$out_trade_no';";			
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{   
					mysql_query("ROLLBACK",$db_link);   
					
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate);
					PubFunc_EchoJsonAndExit($aryResult,$db_link);
				}
				
				mysql_query("COMMIT",$db_link);
			}
		}

		mysql_close($db_link);		
    }
    else {
      //echo "trade_status=".$_GET['trade_status'];
    }
		
	echo '在线支付成功，当前帐号余额：'.$curmoney.'元，<a href="main.php">返回平台</a>&nbsp;查看是否已经在线充值成功，如果有任何问题，请和工作人员联系。<br />';

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
	</div>
</body>
</html>