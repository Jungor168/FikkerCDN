	
<?php	

//全局定义
$PubDefine_ResultOK 		=10000;			//结果OK
$PubDefine_ResultOK2 		=10001;			//结果OK，重复或其他

$PubDefine_ErrParam			=20000;			//参数错误
$PubDefine_ErrConnectDB		=20010;			//连接数据库错误
$PubDefine_ErrQuery			=20011;			//结果查询失败，无结果集	
$PubDefine_ErrInsert		=20012;			//插入数据库失败
$PubDefine_ErrDB			=20013;			//数据库操作失败
$PubDefine_ErrHasExist		=20014;			//写入的数据已经存在
$PubDefine_ErrUpdate		=20015;			//更新数据库失败
$PubDefine_ErrDel			=20016;			//删除数据库表记录失败
$PubDefine_ErrNoExist		=20017;			//要修改的记录不存在
$PubDefine_ErrDelUsing		=20018;			//删除时还有其他关联的数据表内容

$PubDefine_ErrNoLogin		=30000;			//没有登录或者登录过期
$PubDefine_ErrForbidLogin	=30001;			//禁止登录

$PubDefine_ErrOldPasswd		=30002;			//密码错误
$PubDefine_ErrNoUser		=30003;			//用户不存在
$PubDefine_ErrCheckCode		=30004;			//验证码错误
$PubDefine_ErrNoPower		=30005;			//没有权限

$PubDefine_ErrConnFik		=40000;			//连接 fikker节点服务器错误
$PubDefine_ErrReturnFalse	=40001;			//Fikker 返回错误
$PubDefine_ErrServerBusy	=40002;			//Fikker 服务器忙
$PubDefine_ErrFikPasswd		=40003;			//登录Fikker 密码错误

$PubDefine_ErrPrice			=40008;			//价格错误
$PubDefine_ErrNoMoney		=40009;			//账户不够钱了

$PubDefine_ErrDomainOverdue	=50000;			//域名已经过期
$PubDefine_ErrDomainStop	=50001;			//域名已经停止加速
$PubDefine_ErrDomainNotExist=50002;			//域名不存在
$PubDefine_ErrDomainHasExist=50003;			//域名已经存在
$PubDefine_ErrDomainTooMore	=50004;			//域名过多


$PubDefine_ErrNoBuy			=51000;			//没有购买产品

$PubDefine_ErrPasswd		=60000;			//密码错误

// 后台任务类型
$PubDefine_TaskModifyUpstream		= 10;	//修改源站任务
$PubDefine_TaskDelDomain			= 11;	//删除域名任务
$PubDefine_TaskModifyDomainStatus	= 12;	//修改域名状态任务	
$PubDefine_TaskAddProxy				= 13;	//将域名添加到服务器中

$PubDefine_TaskAdminClearCache		= 20;	//管理员清理缓存
$PubDefine_TaskClearCache			= 21;	//清理缓存的任务
$PubDefine_TaskDirClearCache		= 22;	//目录文件清理


$PubDefine_AddFCache				= 30;	//添加页面缓存
$PubDefine_ModifyFCache				= 31;	//修改页面缓存
$PubDefine_DelFCache				= 32;	//删除页面缓存
$PubDefine_UpFCache					= 33;	//上移
$PubDefine_DownFCache				= 34;	//下移
$PubDefine_SyncFCache				= 35;	//同步页面缓存
$PubDefine_DelAllFCache				= 36;	//删除全部页面缓存

$PubDefine_AddRCache				= 40;	//添加拒绝缓存
$PubDefine_ModifyRCache				= 41;	//添加拒绝缓存
$PubDefine_DelRCache				= 42;	//删除拒绝缓存
$PubDefine_UpRCache					= 43;	//上移
$PubDefine_DownRCache				= 44;	//下移
$PubDefine_SyncRCache				= 45;	//同步拒绝缓存
$PubDefine_DelAllRCache				= 46;	//删除全部拒绝缓存

$PubDefine_AddRewrite				= 50;	//添加转向规则
$PubDefine_ModifyRewrite			= 51;	//修改转向规则
$PubDefine_DelRewrite				= 52;	//删除转向规则
$PubDefine_UpRewrite				= 53;	//上移
$PubDefine_DownRewrite				= 54;	//下移
$PubDefine_SyncRewrite				= 55;	//同步转向规则
$PubDefine_DelAllRewrite			= 56;	//删除全部转向规则



$PubDefine_TaskName[$PubDefine_TaskModifyUpstream]		='修改源站';
$PubDefine_TaskName[$PubDefine_TaskDelDomain]			='删除域名';
$PubDefine_TaskName[$PubDefine_TaskModifyDomainStatus]	='修改域名状态';
$PubDefine_TaskName[$PubDefine_TaskClearCache]			='单个缓存更新';
$PubDefine_TaskName[$PubDefine_TaskAddProxy]			='添加域名';
$PubDefine_TaskName[$PubDefine_TaskAdminClearCache]		='单个缓存更新';
$PubDefine_TaskName[$PubDefine_TaskDirClearCache]		='批量缓存更新';

$PubDefine_TaskName[$PubDefine_AddFCache]		='添加页面缓存';
$PubDefine_TaskName[$PubDefine_ModifyFCache]	='修改页面缓存';
$PubDefine_TaskName[$PubDefine_DelFCache]		='删除页面缓存';
$PubDefine_TaskName[$PubDefine_UpFCache]		='上移页面缓存';
$PubDefine_TaskName[$PubDefine_DownFCache]		='下移页面缓存';
$PubDefine_TaskName[$PubDefine_SyncFCache]		='同步页面缓存';
$PubDefine_TaskName[$PubDefine_DelAllFCache]	='删除全部页面缓存';

$PubDefine_TaskName[$PubDefine_AddRCache]		='添加拒绝缓存';
$PubDefine_TaskName[$PubDefine_ModifyRCache]	='修改拒绝缓存';
$PubDefine_TaskName[$PubDefine_DelRCache]		='删除拒绝缓存';
$PubDefine_TaskName[$PubDefine_UpRCache]		='上移拒绝缓存';
$PubDefine_TaskName[$PubDefine_DownRCache]		='下移拒绝缓存';
$PubDefine_TaskName[$PubDefine_SyncRCache]		='同步拒绝缓存';
$PubDefine_TaskName[$PubDefine_DelAllRCache]	='删除全部拒绝缓存';

$PubDefine_TaskName[$PubDefine_AddRewrite]		='添加转向规则';
$PubDefine_TaskName[$PubDefine_ModifyRewrite]	='修改转向规则';
$PubDefine_TaskName[$PubDefine_DelRewrite]		='删除转向规则';
$PubDefine_TaskName[$PubDefine_UpRewrite]		='上移转向规则';
$PubDefine_TaskName[$PubDefine_DownRewrite]		='下移转向规则';
$PubDefine_TaskName[$PubDefine_SyncRewrite]		='同步转向规则';
$PubDefine_TaskName[$PubDefine_DelAllRewrite]	='删除全部转向规则';


$PubDefine_NodeStatus[0]	='关闭';
$PubDefine_NodeStatus[1]	='正常';
$PubDefine_NodeStatus[2]	='连接失败';
$PubDefine_NodeStatus[3]	='密码错误';
$PubDefine_NodeStatus[4]	='登录失败';

$PubDefine_ClientStatus[0]	='冻结';
$PubDefine_ClientStatus[1]	='正常';
$PubDefine_ClientStatus[2]	='过期';

$PubDefine_PullStatus[0] = '任务取消';
$PubDefine_PullStatus[1] = '等待执行';
$PubDefine_PullStatus[2] = '正在拉取';
$PubDefine_PullStatus[3] = '拉取失败';
$PubDefine_PullStatus[4] = '拉取完成';

$PubDefine_HostStatus[0] = '停止加速';
$PubDefine_HostStatus[1] = '正在加速';
$PubDefine_HostStatus[2] = '审核中';


$PubDefine_HostStatusStop		=0;
$PubDefine_HostStatusOk			=1;
$PubDefine_HostStatusVerify		=2;	

$PubDefine_AdminLoginLog	=1;
$PubDefine_ClientLoginLog	=2;

//节点组统计表名称
$PubDefine_DomainStatTableName			="domain_stat_";
$PubDefine_RealtimeListTableName  		="realtime_list_";
$PubDefine_RealtimeTotalStatTableName  	="realtime_totalstat_";

$PubDefine_BankName[0]="工商银行帐号";
$PubDefine_BankName[1]="建设银行帐号";
$PubDefine_BankName[2]="农业银行帐号";
$PubDefine_BankName[3]="支付宝帐号";
$PubDefine_BankName[4]="公司开户行帐号";

$PubDefine_BuyTypeStr[0]	='购买';
$PubDefine_BuyTypeStr[1]	='续费';

$PubDefine_SSLOptStr[0]	='HTTP';
$PubDefine_SSLOptStr[1]	='HTTPS';
$PubDefine_SSLOptStr[2] ='HTTP+HTTPS';

$PubDefine_BuyTypeNew		=0;
$PubDefine_BuyTypeRenew		=1;

$PubDefine_PageShowNum	= 50;		//每页显示数目

$PubDefine_TaskMaxExecuteCount = 3;  //后台任务最大执行次数



?>	