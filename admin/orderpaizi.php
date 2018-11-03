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

require(dirname(__FILE__) . '/includes/initpaizi.php');
//require_once(ROOT_PATH . 'includes/lib_order.php');
//require_once(ROOT_PATH . 'includes/lib_goods.php');
//require_once(ROOT_PATH . 'includes/cls_matrix.php');
//include_once(ROOT_PATH . 'includes/cls_certificate.php');
//require('leancloud_push.php');

require(dirname(__FILE__) . '/Classes/PHPExcel.php');
require(dirname(__FILE__). '/Classes/PHPExcel/IOFactory.php');
/*------------------------------------------------------ */
//-- 订单查询
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'login')
{
   

    $smarty->assign('islogin', $islogin);


    
    /* 显示模板 */
    assign_query_info();
    $smarty->display('delivery_paizi.htm');
}


/*------------------------------------------------------ */
//-- 发货单和商品列表列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'delivery_email')
{
    /* 检查权限 */
   // admin_priv('delivery_view');
   // $matrix = new matrix();
    //$matrix->get_bind_info(array('ecos.ome'))?$smarty->assign('node_info',true):$smarty->assign('node_info',false);
    //获取 url 牌子商 识别代码

    
    $brand_name = strtoupper($_REQUEST['brand']) ? strtoupper($_REQUEST['brand']) : 0;
     //print_r ($brand_name);
    
     $sql = "SELECT brand_name , password_paizi FROM " . $ecs->table('brand') . 
        " WHERE brand_name = '$brand_name' ";
     $brand = $db->getRow($sql);
     
     $password_paizi = $brand['password_paizi'] == $_REQUEST['password'] ? 1:0 ;
    
    $islogin = ($brand_name && $password_paizi)? 1 :  0;
    //print_r ($islogin);
    if ($islogin == 0){
        print_r ('brand or passsword is incorrect!');
        return;
    }
    /* 查询 */
    $result = delivery_email();


    if ($_REQUEST['korea_start_date'] and $_REQUEST['korea_end_date'])
	{
	$delivery = array(
		 
            'korea_start_date' => $_REQUEST['korea_start_date'],
            'korea_end_date'   => $_REQUEST['korea_end_date']
          
        );
	}
	else
	{
	$delivery = array(
		 
             'korea_start_date' => local_date('Y-m-d', local_strtotime('-20 day')),
            'korea_end_date'   => local_date('Y-m-d')
          
        );
	}

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['09_delivery_order']);

    $smarty->assign('korea_start_date',  $delivery['korea_start_date']);
    $smarty->assign('korea_end_date',    $delivery['korea_end_date']);

    $smarty->assign('os_unconfirmed',   OS_UNCONFIRMED);
    $smarty->assign('cs_await_pay',     CS_AWAIT_PAY);
    $smarty->assign('cs_await_ship',    CS_AWAIT_SHIP);
    $smarty->assign('full_page',        1);
    $smarty->assign('lang',         $_LANG);
     $smarty->assign('brand_list',   get_brand_list());
    $smarty->assign('delivery_list',   $result['delivery']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);
    $smarty->assign('sort_update_time', '<img src="images/sort_desc.gif">');
    $smarty->assign('islogin', $islogin);


    
    /* 显示模板 */
    assign_query_info();
    $smarty->display('delivery_paizi.htm');
}


/*------------------------------------------------------ */
//-- 搜索、排序、分页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'delivery_email_query')
{
    /* 检查权限 */
   // admin_priv('delivery_view');

    $result = delivery_email();


   $delivery = array(
		 
            'korea_start_date' => local_date('Y-m-d', local_strtotime('-20 day')),
            'korea_end_date'   => local_date('Y-m-d')
          
        );
    $smarty->assign('korea_start_date',  $delivery['korea_start_date']);
    $smarty->assign('korea_end_date',    $delivery['korea_end_date']);

    $smarty->assign('delivery_list',   $result['delivery']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);

    $sort_flag = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    make_json_result($smarty->fetch('delivery_paizi.htm'), '', array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}






// elseif ($_REQUEST['act'] == 'ordergoodstatus')
// {
    

//     $rec_id         = intval($_POST['id']);
//     $wait          = intval($_POST['val']);

//     //if ($exc->edit("is_hot = '$is_hot', last_update=" .gmtime(), $rec_id))
// 	if($db->query("UPDATE " . $ecs->table('order_goods') . " SET status = $wait , delivery_time = '" . gmtime() . "' WHERE rec_id ='$rec_id'"))
//     {
//         clear_cache_files();
//         make_json_result($wait);
//     }
// }

elseif ($_REQUEST['act'] == 'ordergoodstatus')
{
    

    $rec_id         = intval($_POST['id']);
    $delivering          = intval($_POST['val']);

    //if ($exc->edit("is_hot = '$is_hot', last_update=" .gmtime(), $rec_id))
	if($delivering == 1 )
    {
       $db->query("UPDATE " . $ecs->table('order_goods') . " SET status = '$delivering'  WHERE rec_id ='$rec_id'");
    }
    if($delivering == 3 )
    {
       $db->query("UPDATE " . $ecs->table('order_goods') . " SET status = '0'  WHERE rec_id ='$rec_id'");
    }

      $db->query("UPDATE " . $ecs->table('order_goods') . " SET status_paizi = '$delivering' ,paizi_time = '" . gmtime() . "'  WHERE rec_id ='$rec_id'");


}

/*------------------------------------------------------ */
//-- 修改商品名称
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_remark_paizi')
{
  
    $rec_id         = intval($_POST['id']);
    $remark = json_str_iconv(trim($_POST['val']));

    if($db->query("UPDATE " . $ecs->table('order_goods') . " SET remark_paizi = '$remark'  WHERE rec_id ='$rec_id'"))
    {
        // clear_cache_files();
        // make_json_result($rec_id);
       // $db->query("UPDATE " . $ecs->table('order_goods') . " SET status = '1'  WHERE rec_id ='$rec_id'");
    }
}

/* 货源导出订单功能开始  发货单 email */
elseif (isset($_REQUEST['delivery_export']))
	{
        if (empty($_REQUEST['delivery_export']))
        {
            sys_msg($_LANG['pls_select_order']);
        }

        /* 赋值公用信息 */
        $smarty->assign('shop_name',    $_CFG['shop_name']);
        $smarty->assign('shop_url',     $ecs->url());
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone',$_CFG['service_phone']);
        $smarty->assign('print_time',   local_date($_CFG['time_format']));
        $smarty->assign('action_user',  $_SESSION['admin_name']);

        $html = '';
        $rec_id_list=$_REQUEST['rec_id'];
        $rec_id_list = is_array($rec_id_list) ? $rec_id_list : array($rec_id_list);


        
      
   

 
       
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
        $PHPExcel->getActiveSheet()->setCellValue('A1', $_CFG['shop_name']);
        //填入表头副标题
        $PHPExcel->getActiveSheet()->setCellValue('A2', 'date:'.date('Y-m-d',time()).' 地址：'.$_CFG['shop_address'].'');
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
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);//支付方式
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);//配送方式
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);//配送费用
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);//收件人
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);//收货地址
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);//电话
        $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);//手机
        $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);//邮箱
        $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);//货号
        $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);//商品名称
        $PHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);//属性
        $PHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);//价格
        $PHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(6);//数量
        $PHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);//小计
        $PHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);//应付款金额

        //表格标题
        $PHPExcel->getActiveSheet()->setCellValue('A3', '주문번호');
      
         $PHPExcel->getActiveSheet()->setCellValue('B3', '브랜드');
        //$PHPExcel->getActiveSheet()->setCellValue('C3', '货号');
        $PHPExcel->getActiveSheet()->setCellValue('C3', '상품명');
        //$PHPExcel->getActiveSheet()->setCellValue('E3', '韩国名称');
        $PHPExcel->getActiveSheet()->setCellValue('D3', '색상');
        $PHPExcel->getActiveSheet()->setCellValue('E3', '사이즈');
       // $PHPExcel->getActiveSheet()->setCellValue('E3', '价格');
        $PHPExcel->getActiveSheet()->setCellValue('F3', '수량');
        //  $PHPExcel->getActiveSheet()->setCellValue('I3', '单价(韩币)');
        //  $PHPExcel->getActiveSheet()->setCellValue('J3', '合价');
        //   $PHPExcel->getActiveSheet()->setCellValue('K3', '手续费(%)');
        //    $PHPExcel->getActiveSheet()->setCellValue('L3', '商品优惠(%)');
        //   $PHPExcel->getActiveSheet()->setCellValue('M3', '计算价格');
        //$PHPExcel->getActiveSheet()->setCellValue('3', '小计');
       // $PHPExcel->getActiveSheet()->setCellValue('T3', '商品总金额');
 
        $hang = 4; 
        foreach ($rec_id_list as $rec_id) {
           

            $shuliang = 0;
 



                /* 取得发货单商品 */
             $sql = "SELECT d.* ,o.order_sn ,o.add_time ,  b.brand_name ,b.brand_id ,b.discount as bdiscount , o.order_status , o.shipping_status ,g.korea_name  ,g.supply_price    
                  FROM " . $GLOBALS['ecs']->table('order_goods')  . " AS d ".
                 // "LEFT JOIN " . $GLOBALS['ecs']->table('order_action') . ' AS a ON a.order_id = d.order_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . ' AS o ON o.order_id = d.order_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = d.goods_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' . 
                  
                   "WHERE d.rec_id = '$rec_id' ";
                  // order_status 1 为已确认 5 为已分单
                  // shipping_stauts 3已配货  5发货中  1已发货   0未发货
                  // pay_stauts 2 已付款      





            $res        = $db->query($sql);
            $shuliang   = 0;
            $chanpin    = $hang;
            while ($row = $db->fetchRow($res)) {
                $shuliang = $shuliang + 1;
               

               $row['promote'] = $row['promote'] == 0 ? 100 : $row['promote'];
                $row['promote'] = $row['promote'] <= 1 ? $row['promote'] * 100 : $row['promote'];
                if(strpos(explode(" ",$row['goods_attr'])[0], 'COLOR') !== false){
                   $yanse =  explode(" ",$row['goods_attr'])[0];

                }
                elseif(strpos(explode(" ",$row['goods_attr'])[1], 'COLOR') !== false){
                   $yanse =  explode(" ",$row['goods_attr'])[1];
                }
                elseif(strpos(explode(" ",$row['goods_attr'])[0], '颜色') !== false){
                    $yanse =  explode(" ",$row['goods_attr'])[0];
                 }
                 elseif(strpos(explode(" ",$row['goods_attr'])[1], '颜色') !== false){
                    $yanse =  explode(" ",$row['goods_attr'])[1];
                 }
                else{
                   // $yanse =  explode(" ",$row['goods_attr'])[2];
                }

               // $yanse =  $row['goods_attr'];

                 if(strpos(explode(" ",$row['goods_attr'])[0], 'SIZE') !== false){
                   $mashu =  explode(" ",$row['goods_attr'])[0];

                }
                elseif(strpos(explode(" ",$row['goods_attr'])[1], 'SIZE') !== false){
                   $mashu =  explode(" ",$row['goods_attr'])[1];
                }
                else{
                    $mashu =  explode(" ",$row['goods_attr'])[2];
                }


            //    $row['newdiscount'] =  $row['discount']!=0 ? $row['discount'] :$row['bdiscount'];
               
                // 韩国牌子折扣 ，优先取牌子韩国牌子折扣再获取品牌韩国牌子折扣
               $row['newdiscount'] =  !empty($row['discount']) && $row['discount'] !=0 ? $row['discount'] :$row['bdiscount'];
 
                $row['formated_subtotal']    = price_format($row['goods_price'] * $row['goods_number']);
                $row['formated_goods_price'] = price_format($row['goods_price']);
				
                //var_dump($order);die;
                //输出订单的商品，由于可能一个人购买多个商品，所以在这先输出了
                $PHPExcel->getActiveSheet()->setCellValue('A' . $chanpin, $row['order_sn']);
                $PHPExcel->getActiveSheet()->setCellValue('B' . $chanpin, $row['brand_name']);
                // $PHPExcel->getActiveSheet()->setCellValue('C' . $chanpin, $row['goods_sn']);
                $PHPExcel->getActiveSheet()->setCellValue('C' . $chanpin, $row['goods_name']);
               // $PHPExcel->getActiveSheet()->setCellValue('E' . $chanpin, $row['korea_name']);
                $PHPExcel->getActiveSheet()->setCellValue('D' . $chanpin, $yanse);
			//	$PHPExcel->getActiveSheet()->setCellValue('Q' . $chanpin, $row['goods_price']);
                 $PHPExcel->getActiveSheet()->setCellValue('E' . $chanpin, trim($mashu));
                $PHPExcel->getActiveSheet()->setCellValue('F' . $chanpin, $row['goods_number']);
                // $PHPExcel->getActiveSheet()->setCellValue('I' . $chanpin, $row['supply_price']);
                // $PHPExcel->getActiveSheet()->setCellValue('J' . $chanpin, $row['supply_price'] * $row['goods_number'] * ($row['promote']?$row['promote']:100) * 0.01);
                // $PHPExcel->getActiveSheet()->setCellValue('K' . $chanpin,  $row['newdiscount']);
                // $PHPExcel->getActiveSheet()->setCellValue('L' . $chanpin, $row['promote']);
                // $PHPExcel->getActiveSheet()->setCellValue('M' . $chanpin, ($row['promote']?$row['promote']:100) * 0.01*(100-$row['newdiscount']) * 0.01 * $row['supply_price'] * $row['send_number']);
              //  $PHPExcel->getActiveSheet()->setCellValue('S' . $chanpin, $row['formated_subtotal']);

                $chanpin      = $chanpin + 1;
            }

            for ($kk = $hang; $kk < ($hang + $shuliang); $kk++) {
				//合并单元格
                $PHPExcel->getActiveSheet()->mergeCells('A' . $hang . ':A' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('B' . $hang . ':B' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('C' . $hang . ':C' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('D' . $hang . ':D' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('E' . $hang . ':E' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('F' . $hang . ':F' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('G' . $hang . ':G' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('H' . $hang . ':H' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('I' . $hang . ':I' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('J' . $hang . ':J' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('K' . $hang . ':K' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('L' . $hang . ':L' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('M' . $hang . ':M' . $kk);
                $PHPExcel->getActiveSheet()->mergeCells('T' . $hang . ':T' . $kk);
            }
         
			
            $hang = $hang + $shuliang;
        }
		//设置单元格边框
		$PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->applyFromArray($styleArray);
		//设置自动换行
		$PHPExcel->getActiveSheet()->getStyle('A4:T'.$hang)->getAlignment()->setWrapText(true);
		//设置字体大小
		$PHPExcel->getActiveSheet()->getStyle('A4:T'.$hang)->getFont()->setSize(12);
		//垂直居中
		$PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//水平居中
		$PHPExcel->getActiveSheet()->getStyle('A1:T'.$hang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $Writer = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
        $Writer->save(str_replace('.php', '.xls', __FILE__));
        $url = "orderpaizi.xls";
        ecs_header("Location: $url\n");
        exit;
    }
    /* 导出订单功能结束 */


/*------------------------------------------------------ */
//-- 发货邮件通知
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'delivery_sendemail')
{
    
   $id         = intval($_REQUEST['delivery_id']);
    $sn          = $_REQUEST['sn'];
    $userid          = intval($_REQUEST['userid']);
    $invoice_no          = empty($_REQUEST['invoice_no']) ? '（单号暂未上传）' : $_REQUEST['invoice_no'] ;
    $consignee = !empty($_REQUEST['consignee']) ? $_REQUEST['consignee'] : '';
    $db->query("UPDATE " . $ecs->table('delivery_order') . " SET send_email = 1  WHERE delivery_id ='$id'");
    
    /* 发送邮件 */
     $user = user_info($userid);                                  
    $content = '亲爱的'.$user['user_name'] . '您的订单' . $sn.'已于'.local_date($_CFG['date_format']).'发货，圆通发货单号为'.$invoice_no.'，感谢您对我们的支持。';

   $content = '<p>亲爱的'.$user['user_name'].'----收货人('.$consignee.')。你好！<br />
                <br />
                您的订单'.$sn.'已于'.local_date($_CFG['date_format']).'按照您预定的配送方式给您发货了。<br />
                <br />
                圆通国际发货单号是'.$invoice_no.'。<br />
                <br />
                再次感谢您对我们的支持。欢迎您的再次光临。&nbsp;<br />
                <br />
                STREETNO1 FOR FASHION<br />'
                .local_date($_CFG['date_format']).'</p>';
    send_mail($user['user_name'], $user['email'], 'streetno1发货通知', $content,1);
}
/**
 *  获取发货单商品列表信息并发送email
 *
 * @access  public
 * @param
 *
 * @return void
 */
function delivery_email()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['delivery_sn'] = empty($_REQUEST['delivery_sn']) ? '' : trim($_REQUEST['delivery_sn']);
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        $filter['order_id'] = empty($_REQUEST['order_id']) ? 0 : intval($_REQUEST['order_id']);

        $filter['korea_start_date'] = empty($_REQUEST['korea_start_date']) ? '' : $_REQUEST['korea_start_date'];
		$filter['korea_end_date'] = empty($_REQUEST['korea_end_date']) ? '' : $_REQUEST['korea_end_date'];
		$filter['todaydaohuo'] =  $_REQUEST['todaydaohuo'];
        if ($aiax == 1 && !empty($_REQUEST['consignee']))
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : -1;
        $filter['status_paizi'] = isset($_REQUEST['status_paizi']) ? $_REQUEST['status_paizi'] : -1;
        $filter['orderStatus'] = isset($_REQUEST['status']) ? $_REQUEST['orderStatus'] : -1;
        $filter['brand_id'] = isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] : -1;
        $filter['brand_name'] = strtoupper($_REQUEST['brand']) ? strtoupper($_REQUEST['brand']) : 0;


          
       //$brand_name = strtoupper($_REQUEST['brand']) ? strtoupper($_REQUEST['brand']) : 0;

    //   $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('delivery_goods') ;
    //     $filter['record_count']   = $GLOBALS['db']->getOne($sql);
    
      $sql = "SELECT brand_id  FROM " . $GLOBALS['ecs']->table('brand') .
        " WHERE brand_name = '".$filter['brand_name']."' ";
      $brand_id = $GLOBALS['db']->getOne($sql);
        $filter['brand_id'] =    isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] :$brand_id;

       // print_r($brand_id);
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'update_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = 'WHERE 1 ';
        if ($filter['brand_id'] >= 0)
        {
            $where .= " AND b.brand_id = '" . mysql_like_quote($filter['brand_id']) . "'";
        }
        
        
        if ($filter['consignee'])
        {
            $where .= " AND consignee LIKE '%" . mysql_like_quote($filter['consignee']) . "%'";
        }
        if ($filter['status_paizi'] >= 0)
        {
            $where .= " AND d.status_paizi = '".$filter['status_paizi']."' ";
        }
        if ($filter['delivery_sn'])
        {
            $where .= " AND delivery_sn LIKE '%" . mysql_like_quote($filter['delivery_sn']) . "%'";
        }
        if (!$filter['order_sn'] && $filter['todaydaohuo']==0)
        {
         if ($filter['korea_start_date'] and $filter['korea_end_date'] )
        {
		
			$where .= " AND o.add_time >='".(strtotime($filter['korea_start_date']))."' AND  o.add_time < '".(strtotime($filter['korea_end_date'])+60*60*24)."'";
        }
    }

     if ($filter['todaydaohuo']==1)
        {
		
			$where .= " AND d.delivery_time >='".(strtotime($filter['korea_start_date']))."' AND  d.delivery_time < '".(strtotime($filter['korea_end_date'])+60*60*24)."'";
        }



    
        if ($filter['order_sn'])
        {
            $where .= " AND o.order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%'";
        }
        if ($filter['orderStatus'] == 1)
        {
             $where .= " AND (o.order_status = 1 OR o.order_status=5) AND (o.shipping_status = 3 OR o.shipping_status= 5   ) ";
        }else if($filter['orderStatus'] == 2){

             $where .= " AND (o.order_status = 1 OR o.order_status=5) AND (o.shipping_status = 2 OR o.shipping_status = 1  ) ";
        }else if($filter['orderStatus'] == 3){

             $where .= " AND (o.order_status = 1 OR o.order_status=5) AND (o.order_status = 1 OR o.order_status=5) AND (o.shipping_status = 3 OR o.shipping_status= 5 OR o.shipping_status = 2 OR o.shipping_status = 1   ) ";
        }
       
        
        /* 获取管理员信息 */
        $admin_info = admin_info();

        /* 如果管理员属于某个办事处，只列出这个办事处管辖的发货单 */
        if ($admin_info['agency_id'] > 0)
        {
            $where .= " AND agency_id = '" . $admin_info['agency_id'] . "' ";
        }

        /* 如果管理员属于某个供货商，只列出这个供货商的发货单 */
        if ($admin_info['suppliers_id'] > 0)
        {
            $where .= " AND suppliers_id = '" . $admin_info['suppliers_id'] . "' ";
        }

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 50;
        }

        /* 记录总数 */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_goods'). "AS d ".
         "LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . ' AS o ON o.order_id = d.order_id ' . 
         "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = d.goods_id ' . 
         "LEFT JOIN " . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' . 
         $where ;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT delivery_id, delivery_sn, order_sn, order_id, add_time, action_user, consignee, country,
                       province, city, district, tel, status,status_paizi, remark_paizi,update_time, email, suppliers_id
                FROM " . $GLOBALS['ecs']->table("order_goods") . "AS d ".
                 "LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . ' AS o ON o.order_id = d.order_id ' . 
                "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = d.goods_id ' . 
                "LEFT JOIN " . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' . 
                "$where
                ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. "
                LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";

       

                //  $sql = "SELECT o.*, g.goods_number AS storage, o.goods_attr, IFNULL(b.brand_name, '') AS brand_name " .
                // "FROM " . $ecs->table('order_goods') . " AS o ".
                // "LEFT JOIN " . $ecs->table('goods') . " AS g ON o.goods_id = g.goods_id " .
                // "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
                // "WHERE o.order_id = '$order[order_id]' ";

            /* 取得发货单商品 */
             $goods_sql = "SELECT d.* ,o.order_sn,g.goods_thumb ,o.add_time ,  b.brand_name ,b.brand_id , b.discount , o.order_status,o.pay_status , o.shipping_status , r.delivery_id 
                  FROM " . $GLOBALS['ecs']->table('order_goods')  . " AS d ".
                 // "LEFT JOIN " . $GLOBALS['ecs']->table('order_action') . ' AS a ON a.order_id = d.order_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . ' AS o ON o.order_id = d.order_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = d.goods_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' . 
                  "LEFT JOIN " . $GLOBALS['ecs']->table('delivery_order') . ' AS r ON r.order_id = d.order_id ' . "

                  $where
                  ORDER BY add_time  desc
                  LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";
  
  
                  // order_status 1 为已确认 5 为已分单
                  // shipping_stauts 3已配货  5发货中  1已发货  2已收货 0未发货
                  // pay_stauts 2 已付款



             //$goods_list = $GLOBALS['db']->getAll($goods_sql);

              set_filter($filter, $goods_sql);
    }
    else
    {
        // $sql    = $result['sql'];
        // $filter = $result['filter'];
    }

    /* 获取供货商列表 */
    // $suppliers_list = get_suppliers_list();
    // $_suppliers_list = array();
    // foreach ($suppliers_list as $value)
    // {
    //     $_suppliers_list[$value['suppliers_id']] = $value['suppliers_name'];
    // }

    //$row = $GLOBALS['db']->getAll($sql);
   
    $row = $GLOBALS['db']->getAll($goods_sql);
    


    /* 格式化数据 */
    foreach ($row AS $key => $value)
    {   
        // $row[$key]['delivery_goods'] = get_delivery_goods($value['delivery_id']);

        $row[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['add_time']);
        $row[$key]['delivery_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['delivery_time']);
        $row[$key]['paizi_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['paizi_time']);
         $row[$key]['goods_attr'] = str_replace(' ','<br/>',$value['goods_attr']);
       // $row[$key]['update_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['update_time']);
        // if ($value['status'] == 1)
        // {
        //     $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][1];
        // }
        // elseif ($value['status'] == 2)
        // {
        //     $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][2];
        // }
        // else
        // {
        //     $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][0];
        // }
        // $row[$key]['suppliers_name'] = isset($_suppliers_list[$value['suppliers_id']]) ? $_suppliers_list[$value['suppliers_id']] : '';
    }
    $arr = array('delivery' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}





/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . ADMIN_PATH . '/order_paizi.php', '', PHP_SELF);

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