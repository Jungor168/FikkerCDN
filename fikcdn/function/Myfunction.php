<?php 
/**
                 * 导出excel
                 * @param       string  strName  excel名称
                 * @param       array   arrExcelTitle 标头文字说明
                 * @param       array   arrExcelCont  数据列表
                 * @param       array   arrExcelTotalCont  底部统计
                 * @time        2011-12-09
                 */
 function ExcelExport($strName,$arrExcelTitle,$arrExcelCont,$arrExcelTotalCont=null) {
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Pragma: no-cache');
			header('Content-type: application/xls');
			header("Content-type: text/html; charset=utf-8");

			$filename = $strName.".xls" ;
			$filename = mb_convert_encoding($filename, 'gb2312', 'utf-8') ;
			header('Content-Disposition: attachment; filename="'.$filename.'"');

			// 标题处理
			$_strTitle = '';
			for($i=0;$i<sizeof($arrExcelTitle);$i++){
				$_strTitle .= mb_convert_encoding($arrExcelTitle[$i]."\t", 'gb2312', 'utf-8');
			}
			print_r($_strTitle);

			// 内容处理
			echo "\n";
			foreach($arrExcelCont as $k=>$v){
				foreach($v as $k2=>$v2){
					print_r(mb_convert_encoding($v[$k2]."\t", 'gb2312', 'utf-8'));
				}
				echo "\n";
			}

			// 底部总计
			// 修改于2011-12-14
			if($arrExcelTotalCont){
				echo "\t\n";
				foreach($arrExcelTotalCont as $k=>$v){
					foreach($v as $k2=>$v2){
						print_r(mb_convert_encoding($v[$k2]."\t", 'gb2312', 'utf-8'));					}
					echo "\n";
				}
			}
	   }


?>