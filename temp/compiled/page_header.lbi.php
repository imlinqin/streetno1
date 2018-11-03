
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>

 

 

<div id="sideFloat" style="margin-top:10px;position: absolute;top:220px;right:50px;z-index:1000;
 ">
<a  class="sideFloata">
<img src="themes/default/images/sidefloaticon.jpg" />
<img src="themes/default/images/kefu.jpg" width=450 usemap="#Map" class="kefu" border="0" />
<map name="Map">
  <area shape="rect" coords="11,414,220,552" href="http://b.qq.com/webc.htm?new=0&sid=2448637759&o=streetno1.com&q=7" target="_blank">
  <area shape="rect" coords="151,222,313,248" href="http://www.taobao.com/webww/ww.php?ver=3&touid=jimmyjimmyjimjimmy%3Astreetno1&siteid=cntaobao&status=1&charset=utf-8" target="_blank">
  <area shape="rect" coords="150,250,314,275" href="http://www.taobao.com/webww/ww.php?ver=3&touid=jimmyjimmyjimjimmy%3Astreetno1&siteid=cntaobao&status=1&charset=utf-8" target="_blank">
</map>
</a>
</div>

<div class="top-bar">
  <div class="fd_top fd_top1">
    <div class="bar-left">
          <div class="top_menu1"> <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?> <font id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </font>
            |
           <a href="http://weibo.com/6292672783/profile?topnav=1&wvr=6&is_all=1" target="_blank">
           <img width=20 style="vertical-align:middle"  src="themes/default/images/weibo.png" />
           streetno1官方微博</a>
           </div>
         
    </div>
    <div class="bar-cart">
      <div class="fl cart-yh">
       <a href="goods_bag_add.php" class="">淘宝数据包下载</a>
        <a href="user.php" class="">用户中心</a>
        <a href="user.php" class="">我的订单</a>
      </div>
    
    </div>
  </div>
</div>
<div class="nav-menu">
  <div class="wrap">
  <a style="display:block;float:left;margin-right:470px;padding-top:15px;" href="/article.php?id=87">
    <img style="width:100px;display:none" src="../images/upload/Image/zhengpin.jpg"  />
    </a>
    
    <div class="logo"><a href="index.php" name="top"><img style="width:230px" src="themes/default/images/logo.png?2" /></a></div>
    
    <div id="mainNav" class="clearfix maxmenu" style="display: none">
      <div class="m_left" >
      <ul>
        <li><a href="index.php"<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['lang']['home']; ?></a></li>
        <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
        <?php if (($this->_foreach['nav_middle_list']['iteration'] == $this->_foreach['nav_middle_list']['total'])): ?>
        <li><a href="<?php echo $this->_var['nav']['url']; ?>" 
        
          <?php if ($this->_var['nav']['opennew'] == 1): ?>
          target="_blank"
          <?php endif; ?>
          ><?php echo $this->_var['nav']['name']; ?></a></li>
        <?php else: ?>
        <li><a href="<?php echo $this->_var['nav']['url']; ?>" 
        
          <?php if ($this->_var['nav']['opennew'] == 1): ?>
          target="_blank"
          <?php endif; ?>
          ><?php echo $this->_var['nav']['name']; ?></a></li>
        <?php endif; ?>
        <?php if ($this->_var['nav']['active'] == 1): ?>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
      </div>
    </div>
    <div class="serach-box">
      <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td ><input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="B_input"  /></td>
            <td><input name="imageField" type="submit" value="搜索" class="go" style="cursor:pointer;" /></td>
          </tr>
        </table>
      </form>
    </div>
    <div class="header-tel" style="display: none">
    	<p class="tel">Tel:18026330752</p>
    	<p>
    		<a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&touid=%E4%B8%89%E8%A7%92%E6%A2%A8
&siteid=cntaobao&status=1&charset=utf-8"><img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid=%E4%B8%89%E8%A7%92%E6%A2%A8
&site=cntaobao&s=1&charset=utf-8" alt="点这里给我发消息" /></a>
    	</p>
    </div>
  </div>
  <div class="clear0 "></div>

<div class="nav-bar">
	<div class="wrap">
		<div class="left">
	<!--<a class="brand">
		品牌中心
	</a>-->
  
	<a class="link" href='/brand.php' onmouseover=this.innerHTML="BRANDS" onmouseout=this.innerHTML="品牌中心">
		品牌中心
	</a>

  <div class="link featureBrand" style="margin-let:100px">
    <a href="index.php?best=1" class="link" onmouseover=this.innerHTML="BEST" onmouseout=this.innerHTML="畅销区">
		畅销区
	</a>
   
   
   <div class="featureBrandCon">
     	
<img src="http://img.streetno1.com/images/upload/Image/best/1.jpg?1" usemap="#mapbest"  style="width:500px;display:block;z-index:9999" />
<map name="#mapbest">
  <area shape="rect" coords="15,16,167,250" href=" http://www.streetno1.com/goods.php?id=3427
">
  <area shape="rect" coords="171,16,325,250" href="http://www.streetno1.com/goods.php?id=3324">
  <area shape="rect" coords="326,13,484,248" href="http://www.streetno1.com/goods.php?id=3360">
  <area shape="rect" coords="15,256,169,471" href="http://www.streetno1.com/goods.php?id=3656">
  <area shape="rect" coords="177,252,327,478" href="http://www.streetno1.com/goods.php?id=3432">
  <area shape="rect" coords="327,252,479,472" href="http://www.streetno1.com/goods.php?id=3487">
</map>
</div>
    </div>

	
  <div class="link featureBrand" style="margin-let:100px">
    <a  href='/new.php' class="link" onmouseover=this.innerHTML="NEWITEM" onmouseout=this.innerHTML="新商品">
		新商品
	</a>
    <div class="featureBrandCon">
    
<img src="http://img.streetno1.com/images/upload/Image/new/1.jpg?3" usemap="#mapnew"  style="width:500px;display:block;z-index:20000" />
<map name="mapnew" id='mapnew'>
  <area shape="rect" coords="5,3,173,298" href="http://www.streetno1.com/goods.php?id=4163">
  <area shape="rect" coords="181,4,353,295" href="http://www.streetno1.com/goods.php?id=4145">
  <area shape="rect" coords="359,4,496,297" href="http://www.streetno1.com/goods.php?id=4007">
</map>
</div>
     
    </div>
  </div>



  <div class="link featureBrand" style="margin-let:100px">
    <a  href='/promote.php' class="link" onmouseover=this.innerHTML="SALE" onmouseout=this.innerHTML="特价">
		特价
	</a>
    <div class="featureBrandCon">
        <img usemap="#maptejia"  style="width:500px;display:block;z-index:20000" src="http://img.streetno1.com/images/upload/Image/tejia/1.jpg?4" />
 <map name="maptejia" id='maptejia' >
         
   <area shape="rect" coords="4,4,141,246" href="http://www.streetno1.com/goods.php?id=4102">
   <area shape="rect" coords="147,6,274,245" href="http://www.streetno1.com/goods.php?id=3585">
   <area shape="rect" coords="281,3,386,246" href="http://www.streetno1.com/goods.php?id=3708">
   <area shape="rect" coords="391,4,498,245" href="http://www.streetno1.com/goods.php?id=3916">
 </map>
     
</div>
  </div>

   <div class="link featureBrand" style="margin-let:100px">
    <a  href='/category.php?id=45' class="link" onmouseover=this.innerHTML="WOMEN" onmouseout=this.innerHTML="流行女装">
		流行女装
	</a>
    <div class="featureBrandCon">
    
        <img usemap="#mapwomen"  style="width:500px;display:block;z-index:20000" src="http://img.streetno1.com/images/upload/Image/women/1.jpg?1" />
 <map name="mapwomen" id='mapwomen' >
          <area shape="circle" coords="94,126,92" href="http://streetno1.com/brand.php?id=54">
          <area shape="circle" coords="253,101,89" href="http://streetno1.com/brand.php?id=81">
          <area shape="circle" coords="401,123,87" href="http://streetno1.com/brand.php?id=75">

     
</div>
  </div>

  
   <div class="link featureBrand" style="margin-let:100px">
    <a  href='/category.php?id=46' class="link" onmouseover=this.innerHTML="UNISEX" onmouseout=this.innerHTML="男女同款">
		男女同款
	</a>
    <div class="featureBrandCon">
    
        <img usemap="#mapmen"  style="width:500px;display:block;z-index:20000" src="http://img.streetno1.com/images/upload/Image/man/1.jpg?4" />
 <map name="mapmen" id='mapmen' >
          <area shape="circle" coords="94,126,92" href="http://streetno1.com/brand.php?id=5140">
          <area shape="circle" coords="253,101,89" href="http://streetno1.com/brand.php?id=5073">
          <area shape="circle" coords="401,123,87" href="http://streetno1.com/brand.php?id=4919">
   </map>
     
</div>
  </div>

<div class="link featureBrand" style="margin-let:100px">
    <a  href='#' class="link" onmouseover=this.innerHTML="FeatureBrand" onmouseout=this.innerHTML="个性品牌">
		个性品牌
	</a>
    <div class="featureBrandCon">
    
        <img usemap="#mapgebrand"  style="width:500px;display:block;z-index:20000" src="http://img.streetno1.com/images/upload/Image/brand_img/1.jpg?2" />
 <map name="mapgebrand" id='mapgebrand' >
          <area shape="circle" coords="94,126,92" href="http://streetno1.com/brand.php?id=82">
          <area shape="circle" coords="253,101,89" href="http://streetno1.com/brand.php?id=28">
          <area shape="circle" coords="401,123,87" href="http://streetno1.com/brand.php?id=71">
   </map>
     
</div>
  </div>
  
  
	</div>
	  <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?>

      <div class="cart right" id="ECS_CARTINFO"> <?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </div>
     
	</div>
</div>
</div>
<div class="wrap" style="position:relative">
 <div  style="margin-top:10px;position: absolute;top:40px;right:-120px;z-index:99;
 ">
<a  class="" href="/article.php?id=87">
<img style="width:100px;" src="http://img.streetno1.com/images/upload/Image/zhengpin.png" />
</a>
</div>
 <div  style="margin-top:10px;position: absolute;top:160px;right:-120px;z-index:99;
 ">
<a  class="" href="/article.php?id=92">
<img style="width:100px;" src="http://img.streetno1.com/images/upload/Image/xiadan.png" />
</a>
</div>
</div>
<div class="clear0 "></div>
