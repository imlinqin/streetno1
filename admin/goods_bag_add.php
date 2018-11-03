<?php

/**
 * EC_AIYO 论坛管理程序
 * ============================================================================
 * 版权所有 2009-2012 上海哎呦网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.aiyonet.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: lium $
 * $Id: goods_bag_add.php 2009-05-12 09:37:33Z lium $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);
$imagetype = "|png|jpg|jpeg|gif|";
include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件



/*------------------------------------------------------ */
//-- 帖子列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
      /* 检查权限 */
    admin_priv('goods_export');
    
   
	
	
	
	$topic_list = topic_list();
	

   
    //add by lium
    $smarty->assign('topic_list',   $topic_list['topic_list']);
	
  
  //  $smarty->assign('boardnames',    get_board_list());
    
    $smarty->assign('full_page',    1);
    $smarty->assign('sort_topic_id', '<img src="images/sort_desc.gif">');

    assign_query_info();
    $smarty->display('goods_bag_add_list.htm');
}

/*------------------------------------------------------ */
//-- ajax返回版块列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    
    $topic_list = topic_list();
    $smarty->assign('topic_list',   $topic_list['topic_list']);
    $smarty->assign('filter',       $topic_list['filter']);
    $smarty->assign('record_count', $topic_list['record_count']);
    $smarty->assign('page_count',   $topic_list['page_count']);

    $sort_flag  = sort_flag($topic_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('goods_bag_add_list.htm'), '', array('filter' => $topic_list['filter'], 'page_count' => $topic_list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加帖子 --前台备用下拉列表
//    <td><select name="board_id">
//      <option value="0">{$lang.not_special_rank}</option>
//      {html_options options=$boardnames selected=$topic.board_id}
//    </select></td>
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
     /* 检查权限 */
    admin_priv('goods_export');

/*    $board_id = 0;
	if($_GET[id] > 0)
	{	//从版块列表得到版块ID
		$board_id = $_GET[id];
	}*/
    $topic = array( 'board_id'   	=> $_GET[board_id],
    				'category_id'   	=> 0,
    				'board_type'   	=> $_GET[board_type],
    				'topic_title'   	=> "",
                    'topic_state'   	=> 0,
                    'topic_adduser'   => "admin",
                    'topic_email' => "",
                    'topic_password'   	=> "",
                    'topic_content'   	=> "",
                    );

    create_html_editor('topic_content', $topic['topic_content']);

    $smarty->assign('ur_here',          $_LANG['04_topics_add']);
    //$smarty->assign('action_link',      array('text' => $_LANG['03_topics_list'], 'href'=>'goods_bag_add.php?act=list'));
    $smarty->assign('form_action',      'insert');

    $smarty->assign('topic',            $topic);
   // $smarty->assign('boardnames',    get_board_list());
   // $smarty->assign('categorys',   	 get_category_list($topic['board_id']));    
	/*查询访问次数等信息*/
    assign_query_info();
    $smarty->display('goods_bag_add_info.htm');
}

/*------------------------------------------------------ */
//-- 添加版块-insert操作
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
     /* 检查权限 */
    admin_priv('goods_export');

    $csv_id = empty($_POST['csv_id']) ? 0 : intval($_POST['csv_id']);
   
    
	if (empty($_POST['csv_title']))
	{
	$csv_title = empty($_POST['csv_title_bao']) ? '' :'['.date('m-d').']'. trim($_POST['csv_title_bao']);
	}
	else
	{
	$csv_title = empty($_POST['csv_title']) ? '' : trim($_POST['csv_title']);
	}
	
		
    $csv_title_a = empty($_POST['csv_title_a']) ? '' : trim($_POST['csv_title_a']);
    
  
    
   $upload_name='';
   
   if (!empty($_POST['csv_upload']))
    {
	$upload_name =$_POST['csv_upload'];
	}
	
	else 
	
	{
	if (isset($_FILES['topic_upload'])  )
    {
		$upload_name = uploadfiles($_FILES['topic_upload'], 'csv');
    }
	
	}

    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('csv') .
            " (csv_id,csv_title, csv_title_a, csv_upload)".
            " VALUES (NULL, '$csv_title','$csv_title_a','$upload_name')";
    $db->query($sql);

    /* 记录管理员操作 */
    admin_log($_POST['username'], 'insert', 'topics');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'goods_bag_add.php?act=list');
    sys_msg(sprintf($_LANG['add_success'], $topic_title), 0, $link);
}

/*------------------------------------------------------ */
//-- 编辑帖子
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
     /* 检查权限 */
    admin_priv('goods_export');

    $sql = "SELECT csv_id,csv_title,csv_title_a,csv_upload,csv_ip,csv_click ".
        " FROM " .$ecs->table('csv'). " WHERE csv_id='$_GET[id]'";

    $row = $db->GetRow($sql);
	$topic = array();

    if ($row)
    {
        //$user['birthday']       = date($row['birthday']);
        $topic['csv_id']        = $row['csv_id'];
       $topic['csv_title']        = $row['csv_title'];
	   $topic['csv_title_a']        = $row['csv_title_a'];
	   $topic['csv_ip']        = $row['csv_ip'];
    	$topic_upload_all = explode(',',$row['csv_upload']);//将字符串转换为数组
		
		$lone_ip = explode(',', $row['csv_ip']);
        $click_ip=count($lone_ip); //计算个数
		$topic['csv_num']        =   $click_ip;
		$topic['csv_click']        =  $row['csv_click'];
    }
    else
    {
        $topic['csv_id']        = 0;
       
        $topic['csv_title']        = "";
		 $topic['csv_title_a']        = "";
		  $topic['csv_ip']        = "";
      
     }
	//判断版块类型
   


    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['topics_edit']);
    $smarty->assign('action_link',      array('text' => $_LANG['01_topics_list'], 'href'=>'goods_bag_add.php?act=list&' . list_link_postfix()));
    $smarty->assign('topic',             $topic);
    $smarty->assign('topic_upload_all',             $topic_upload_all);
  //  $smarty->assign('comment_list',             $comment_list);
    $smarty->assign('form_action',      'update');
   // $smarty->assign('boardnames',    get_board_list());
   // $smarty->assign('categorys',   	 get_category_list($topic['board_id'])); 
    $smarty->display('goods_bag_add_info.htm');
}

/*------------------------------------------------------ */
//-- 更新帖子
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
     /* 检查权限 */
    admin_priv('goods_export');

   
 $csv_id = empty($_POST['csv_id']) ? 0 : intval($_POST['csv_id']);
   
   if (empty($_POST['csv_title']))
	{
	$csv_title = empty($_POST['csv_title_bao']) ? '' :'['.date('m-d').']'. trim($_POST['csv_title_bao']);
	}
	else
	{
	$csv_title = empty($_POST['csv_title']) ? '' : trim($_POST['csv_title']);
	}
	
	
	
	
    $csv_title_a = empty($_POST['csv_title_a']) ? '' : trim($_POST['csv_title_a']);
	
	
	
   
   
	/*添加版块信息*/
    $other =  array();
    //$other['topic_id'] = $_GET['id'];
	
	 
   if (!empty($_POST['csv_upload']))
    {
	$upload_name =$_POST['csv_upload'];
	$other['csv_upload'] =  $upload_name;
	}
	
	else 
	
	{
	
	
	}
	
	

   $other['csv_title'] =  $csv_title;
  $other['csv_title_a'] = $csv_title_a;
   
    $db->autoExecute($ecs->table('csv'), $other, 'UPDATE', "csv_id = '$csv_id'");
    /* 记录管理员操作 */
    admin_log($topicname, 'edit', 'topics');
    /* 提示信息 */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'goods_bag_add.php?act=list&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';
    sys_msg($_LANG['update_success'], 0, $links);
}

/*------------------------------------------------------ */
//-- 删除帖子
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
     /* 检查权限 */
    admin_priv('goods_export');

	

   

   

    /* 删除帖子 */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('csv') . " WHERE csv_id = '" . $_GET['id'] . "' LIMIT 1";
    //$sql .= "topic_title='" . $topicname . "' LIMIT 1";
    $db->query($sql);

    /* 记录管理员操作 */
    admin_log(addslashes($topicname), 'remove', 'topics');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'goods_bag_add.php?act=list');
    sys_msg(sprintf($_LANG['remove_success'], $topicname), 0, $link);
}



/**
 *  返回版块列表数据
 *
 * @access  public
 * @param
 *
 * @return void
 */
function topic_list()
{
   
        $sql = "SELECT csv_id,csv_title,csv_title_a,csv_upload,csv_click ,csv_ip".
                " FROM " . $GLOBALS['ecs']->table('csv') .
                " ORDER by csv_id desc"  ;

 
   
	$topic_list = $GLOBALS['db']->getAll($sql);
   
	
    $arr = array('topic_list' => $topic_list);
    return $arr;
}


/**add by lium
 * 处理上传文件，并返回上传图片名(上传失败时返回图片名为空）
 *
 * @access  public
 * @param array     $upload     $_FILES 数组
 * @param array     $type       图片所属类别，即data目录下的文件夹名
 *
 * @return string               上传图片名
 */
 function uploadfiles($upload, $file_dir, $type='')
 {
     $filenames = "";
     foreach ($upload["error"] as $key=> $error)
     {
         if (!empty($upload['name'][$key]))
         {
             if (!empty($type))
             {
                 $ftype = check_file_type($upload['tmp_name'][$key], $upload['name'][$key], $type);
             }
             else
             {
                 $ftype = check_file_type($upload['tmp_name'][$key], $upload['name'][$key], '|png|jpg|jpeg|gif|doc|xls|txt|zip|ppt|pdf|rar|');
             }
             if (!empty($ftype))
             {
                 $name = date('Ymd');
                 for ($i = 0; $i < 6; $i++)
                 {
                     $name .= chr(mt_rand(97, 122));
                 }
 
                 $name = $_SESSION['user_id'] . '_' . $name . '.' . $ftype;
 
                 $target = ROOT_PATH . '/images/upload/Image/' . $file_dir . '/' . $name;
                 if (!move_upload_file($upload['tmp_name'][$key], $target))
                 {
                     $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_error'], 1);
 
                     return false;
                 }
                 else
                 {
                     if(!empty($filenames))
                     {
                         $filenames .= ",";
                     }
                     $filenames .= $name;
                 }
             }
             else
             {
                 $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_type'], 1);
                 return false;
             }
         }
         else
         {
             $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_error']);
             return false;
         }
     }
     return $filenames;
 }

?>