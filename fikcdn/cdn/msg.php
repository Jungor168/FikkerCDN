<link rel="stylesheet" href="../css/fikker.css" type="text/css" />
<script src="../js/urlencode.js"></script>
<script>
//msg.htm?1.3-DELPROXY-testproxy1-4
var sParam=document.location.href.split("?")[1];
var showMSG = sParam.split("&msg=")[1];
var tmpchar = sParam.split("&msg=")[0];
if(tmpchar.indexOf("-")==-1){
	var MSGID=tmpchar;
}else{
	tmpchar=tmpchar.split("-");
	var MSGID=tmpchar[0];
}

// x.y
var prefix = MSGID.split(".")[0];   // x 部分
var suffix = MSGID.split(".")[1];   // y 部分
if( (typeof(showMSG) == "undefined") || showMSG.length<=0){
	if(prefix==1){   // 1.x 错误
		switch(suffix){
			case "1":
				showMSG="您确定要删除此域名吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCdn_DelDomain();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;	
			case "2":
				showMSG="您确定要删除此订单吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCdn_DelOrder();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;		
			case "3":
				showMSG="您确认要购买此套餐吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCdn_BuyProduct();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;	
			case "4":
				showMSG="您确认要支付此订单吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCdn_PayOrder();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;
			case "5":
				showMSG="支付成功，您现在可以添加域名到已购买的套餐了。<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="域名列表" style="cursor:pointer;" onClick="javascript:parent.FikCdn_ToDomainList();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;
			case "6":
				showMSG="您确认要为此套餐续费吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCdn_RenewalProduct();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;		
			case "7":
				showMSG="您确定要删除此充值记录吗？<br><br><br><br>" ;
				showMSG += '<center><input name="btnOk"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="确定" style="cursor:pointer;" onClick="javascript:parent.FikCDN_DelRechgOrder();parent.closeMSGBOX();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				showMSG += '<input name="btnCancel"  type="submit" style="width:75px;height:26px" id="btnAddNode" value="取消" style="cursor:pointer;" onClick="javascript:parent.closeMSGBOX();" /></center>';
				break;																																								
		}
	}		
}else{
	showMSG = UrlDecode(showMSG);
}

document.write("<table width=\"95%\" align=center><tr><td height=80 width=\"100%\" style=\"font-size:12px;\">"+showMSG+"</td></tr></table>");

</script>
