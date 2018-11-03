<?php

/**
 * ECSHOP 订单管理
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: yehuaixiao $
 * $Id: order.php 17219 2011-01-27 10:49:19Z yehuaixiao $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');
require_once(ROOT_PATH . 'includes/cls_matrix.php');
include_once(ROOT_PATH . 'includes/cls_certificate.php');
require('leancloud_push.php');

require(dirname(__FILE__) . '/Classes/PHPExcel.php');
require(dirname(__FILE__). '/Classes/PHPExcel/IOFactory.php');
/*------------------------------------------------------ */
//-- 订单查询
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'order_query')
{
    /* 检查权限 */
    admin_priv('order_view');

    /* 载入配送方式 */
    $smarty->assign('shipping_list', shipping_list());

    /* 载入支付方式 */
    $smarty->assign('pay_list', payment_list());

    /* 载入国家 */
    $smarty->assign('country_list', get_regions());

    /* 载入订单状态、付款状态、发货状态 */
    $smarty->assign('os_list', get_status_list('order'));
    $smarty->assign('ps_list', get_status_list('payment'));
    $smarty->assign('ss_list', get_status_list('shipping'));

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['03_order_query']);
    $smarty->assign('action_link', array('href' => 'order.php?act=list', 'text' => $_LANG['02_order_list']));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_query.htm');
}


    /* 订单运费表 */
    elseif ($_REQUEST['downorder'] = 'downorder')
	{
       

        /* 赋值公用信息 */
        $smarty->assign('shop_name',    $_CFG['shop_name']);
        $smarty->assign('shop_url',     $ecs->url());
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone',$_CFG['service_phone']);
        $smarty->assign('print_time',   local_date($_CFG['time_format']));
        $smarty->assign('action_user',  $_SESSION['admin_name']);

      


      
   

 
        require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
        require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
        $PHPExcel = new PHPExcel();
        
        //设置excel属性基本信息
        $PHPExcel->getProperties()->setCreator("Neo")
        ->setLastModifiedBy("Neo")
        ->setTitle("streetno1")
        ->setSubject("订单列表")
        ->setDescription("")
        ->setKeywords("订单列表")
        ->setCategory("");
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->getActiveSheet()->setTitle("订单列表");
        //填入表头主标题
        $PHPExcel->getActiveSheet()->setCellValue('A1', $_CFG['shop_name'].'订单列表');
        //填入表头副标题
        $PHPExcel->getActiveSheet()->setCellValue('A2', '操作者：'.$_SESSION['admin_name'].' 导出日期：'.date('Y-m-d',time()).' 地址：'.$_CFG['shop_address'].' 电话：'.$_CFG['service_phone']);
        //合并表头单元格
        $PHPExcel->getActiveSheet()->mergeCells('A1:T1');
        $PHPExcel->getActiveSheet()->mergeCells('A2:T2');
		
        //设置表头行高
        $PHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
        $PHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
        $PHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
        
        //设置表头字体
        $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
        $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('宋体');
        $PHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $PHPExcel->getActiveSheet()->getStyle('A3:T3')->getFont()->setBold(true);
 
        //设置单元格边框
		$styleArray = array(  
			'borders' => array(  
				'allborders' => array(  
					//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的  
					'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框  
					//'color' => array('argb' => 'FFFF0000'),  
				),  
			),  
		);
		
        //表格宽度
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);//订单编号
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);//下单时间
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);//付款时间
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);//发货时间
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);//发货单号
       
        
        //表格标题
        $PHPExcel->getActiveSheet()->setCellValue('A3', '订单编号');
        $PHPExcel->getActiveSheet()->setCellValue('B3', '下单时间');
        $PHPExcel->getActiveSheet()->setCellValue('C3', '单费');
        $PHPExcel->getActiveSheet()->setCellValue('D3', '运费');
        $PHPExcel->getActiveSheet()->setCellValue('E3', '状态');
       
        $hang = 4; 

            $korea_start_date    = isset($_REQUEST['korea_start_date']) ? trim($_REQUEST['korea_start_date']) : '2018-09-01';
             $korea_end_date    = isset($_REQUEST['korea_end_date']) ? trim($_REQUEST['korea_end_date']) : local_date('Y-m-d');


         $where = 'WHERE 1 ';
      
            $where .= " AND o.add_time >=".strtotime($korea_start_date)." AND  o.add_time <=".(strtotime($korea_end_date)+60*60*24)." ";

            /* 取得发货单商品 */
             $sql = "SELECT o.order_sn ,o.order_status ,o.pay_status ,o.goods_amount ,o.shipping_fee ,o.add_time    
                  FROM " . $GLOBALS['ecs']->table('order_info')  . " AS o ".
                  $where.
                   " ORDER BY o.add_time  desc ";
                  // order_status 1 为已确认 5 为已分单
                  // shipping_stauts 3已配货  5发货中  1已发货   0未发货
                  // pay_stauts 2 已付款   
             $res        = $db->getAll($sql);
            $res2        = $db->query($sql);
            
               $shuliang = 0;
            $chanpin    = $hang;
             foreach ($res as $row) {
          //  print_r ($rec_val);
                print_r ('<br/>');
          
           
            //print_r ($db->fetchRow($res2));
           //print_r ('<br/>---');
           // print_r ($rec_val);
            
             
              
                 $PHPExcel->getActiveSheet()->setCellValue('A' . $chanpin, $row['order_sn']);
                 $PHPExcel->getActiveSheet()->setCellValue('B' . $chanpin, local_date($_CFG['time_format'], $row['add_time']));

                 $PHPExcel->getActiveSheet()->setCellValue('C' . $chanpin, $row['goods_amount']);
                  $PHPExcel->getActiveSheet()->setCellValue('D' . $chanpin, $row['shipping_fee']);
                 $PHPExcel->getActiveSheet()->setCellValue('E' . $chanpin, $row['order_status']);
                
                  if($row['order_status']==0 || $row['order_status']==2 || $row['order_status']==4 ){ //非发货的
                //     //设置填充的样式和背景色
                     $PHPExcel->getActiveSheet()->getStyle('A' . $chanpin . ':M' . $chanpin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $PHPExcel->getActiveSheet()->getStyle('A' . $chanpin . ':M' . $chanpin)->getFill()->getStartColor()->setARGB('FFFFF68F');
                 }

                 $chanpin      = $chanpin + 1;

                

             for ($kk = $hang; $kk < ($hang + $shuliang); $kk++) {
			// 	//合并单元格
                 $PHPExcel->getActiveSheet()->mergeCells('A' . $hang . ':A' . $kk);
                 $PHPExcel->getActiveSheet()->mergeCells('B' . $hang . ':B' . $kk);
                 $PHPExcel->getActiveSheet()->mergeCells('C' . $hang . ':C' . $kk);
                 $PHPExcel->getActiveSheet()->mergeCells('D' . $hang . ':D' . $kk);
                 $PHPExcel->getActiveSheet()->mergeCells('E' . $hang . ':E' . $kk);
               
             }
          
			
           
        }
         $hang = $hang + $shuliang;
		// //设置单元格边框
		 $PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->applyFromArray($styleArray);
		 //设置自动换行
		 $PHPExcel->getActiveSheet()->getStyle('A4:T'.$hang)->getAlignment()->setWrapText(true);
		// //设置字体大小
		 $PHPExcel->getActiveSheet()->getStyle('A4:T'.$hang)->getFont()->setSize(12);
		// //垂直居中
		 $PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// //水平居中
		 $PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $Writer = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
         $Writer->save(str_replace('.php', '.xls', __FILE__));
         $url = "orderdown.xls";
         ecs_header("Location: $url\n");
         exit;
    }
    /* 导出订单功能结束 */

/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . ADMIN_PATH . '/order.php', '', PHP_SELF);

}


/**
 * 判断管理员是否是超级管理员（绑定云起的）
 */
function is_super_admin(){
    $sql = "SELECT action_list
            FROM " . $GLOBALS['ecs']->table('admin_user') . "
            WHERE user_id = {$_SESSION['admin_id']}";
    $rs=$GLOBALS['db']->getOne($sql);
    if(!empty($rs) and $rs=='all'){
        return 1;
    }
    return 0;
}

// 更新订单到crm
function update_order_crm($order_sn){
    $matrix = new matrix();
    $bind_info = $matrix->get_bind_info(array('ecos.taocrm'));
    if($bind_info){
        $is_succ = $matrix->updateOrder($order_sn,'ecos.taocrm');
        return $is_succ;
    }
    return true;
}
// 退款通知到crm
function send_refund_to_crm($data){
    $msg['tid'] = $data['order_id'];
    $msg['refund_id'] = $data['order_id'];
    $msg['refund_fee'] = $data['cur_money'];
    $msg['status'] = 'SUCC';
    $msg['t_begin'] = date('Y-m-d H:i:s',time());
    include_once(ROOT_PATH . 'includes/cls_matrix.php');
    $matrix = new matrix;
    $bind_info = $matrix->get_bind_info(array('ecos.taocrm'));
    if($bind_info){
        $is_succ = $matrix->send_refund_to_crm($msg);
    }
}


/**
*  数据导入
* @param string $file excel文件
* @param string $sheet
 * @return string   返回解析数据
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
*/
function importExecl($file='', $sheet=0){
	$file = iconv("utf-8", "gb2312", $file);   //转码
	if(empty($file) OR !file_exists($file)) {
		die('file not exists!');
	}
	//include('PHPExcel.php');  //引入PHP EXCEL类
	$objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象
	if(!$objRead->canRead($file)){
		$objRead = new PHPExcel_Reader_Excel5();
		if(!$objRead->canRead($file)){
			die('No Excel!');
		}
	}

	$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

	$obj = $objRead->load($file);  //建立excel对象
	$currSheet = $obj->getSheet($sheet);   //获取指定的sheet表
	$columnH = $currSheet->getHighestColumn();   //取得最大的列号
	$columnCnt = array_search($columnH, $cellName);
	$rowCnt = $currSheet->getHighestRow();   //获取总行数

	$data = array();
	for($_row=1; $_row<=$rowCnt; $_row++){  //读取内容
		for($_column=0; $_column<=$columnCnt; $_column++){
			$cellId = $cellName[$_column].$_row;
			$cellValue = $currSheet->getCell($cellId)->getValue();
             //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值
			if($cellValue instanceof PHPExcel_RichText){   //富文本转换字符串
				$cellValue = $cellValue->__toString();
			}

			$data[$_row][$cellName[$_column]] = $cellValue;
		}
	}

	return $data;
}



?>