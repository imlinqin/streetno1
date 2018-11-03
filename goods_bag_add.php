<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

//判断ID是否存在，如果不存在则返回到首页

	 $csv_id=intval($_GET['id']);

	


$before_ip=$GLOBALS['db']->getone("SELECT csv_ip FROM  ".$GLOBALS['ecs']->table("csv")." WHERE csv_id='$csv_id'");
$new_ip=!empty($before_ip)?$_SESSION['user_name']. ',' .$before_ip  : $_SESSION['user_name'] ;

$db->query("update ".$ecs->table('csv')." set csv_ip='".$new_ip."' where csv_id=$csv_id");

$lone_ip = explode(',', $new_ip);
$num_ip=array_unique($lone_ip);  //删重复
$click_ip=count($num_ip); //计算个数

$db->query("update ".$ecs->table('csv')." set csv_click='".$click_ip."' where csv_id=$csv_id");



assign_template();

$smarty->assign('page_title','streetno1'); 
   // 页面标题
$use_name = $_COOKIE['last_user'];
$smarty->assign('use_name',$use_name); 
   
   if (!empty($_SESSION['user_id']))
{   
    $user_id=$GLOBALS['db']->getone("SELECT user_rank FROM  ".$GLOBALS['ecs']->table("users")." WHERE user_id='".$_SESSION['user_id']."'");
	if ($user_id !=0)
	{
	$smarty->assign('login','yes');
	}
	else 
	{
	$smarty->assign('login','user_rank');
	}
}else{
	$smarty->assign('login',false);
}






	$topic_list = topic_list();
	
   
    //add by lium
    $smarty->assign('topic_list',   $topic_list['topic_list']);
  

    $smarty->assign('sort_topic_id', '<img src="images/sort_desc.gif">');

    
	function topic_list()
{
   
        $sql = "SELECT csv_id,csv_title,csv_title_a,csv_upload ,csv_click".
                " FROM " . $GLOBALS['ecs']->table('csv') .
                " ORDER by csv_id desc"  ;

        
        

    $topic_list = $GLOBALS['db']->getAll($sql);

    $arr = array('topic_list' => $topic_list);

    return $arr;
}

if(isset($_GET['id']))

{
$rows=$GLOBALS['db']->getone("SELECT csv_upload FROM  ".$GLOBALS['ecs']->table("csv")." WHERE csv_id='$csv_id'");

$_GET['id'] > 959 ? header('Location: '.$rows.'') :	header('Location: images/upload/Image/csv/'.$rows.'');
		//header('Location: '.$rows.'');

}


/* 处理会员的登录 */

if ($_REQUEST['act'] == 'act_login')

{
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $back_act = isset($_POST['back_act']) ? trim($_POST['back_act']) : '';
    setcookie("last_user", $_POST['username'],time()+3600*24*30); //历史记录

    $captcha = intval($_CFG['captcha']);
    if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
    {
        if (empty($_POST['captcha']))
        {
            show_message($_LANG['invalid_captcha'], $_LANG['relogin_lnk'], 'user.php', 'error');
        }

        /* 检查验证码 */
        include_once('includes/cls_captcha.php');

        $validator = new captcha();
        $validator->session_word = 'captcha_login';
        if (!$validator->check_word($_POST['captcha']))
        {
            show_message($_LANG['invalid_captcha'], $_LANG['relogin_lnk'], 'user.php', 'error');
        }
    }

    if ($user->login($username, $password))
    {
        update_user_info();
        recalculate_price();

        $ucdata = isset($user->ucdata)? $user->ucdata : '';
		
     header("Location: goods_bag_add.php\n");
    }
	
    else
    {
        $_SESSION['login_fail'] ++ ;
        show_message('您输入的用户名或密码出错!', '返回上一页', 'goods_bag_add.php', 'error');
    }
}



else{
	

$smarty->display('goods_bag_add.dwt');	
}

//根据ID获取板块信息，返回成数组











?>
