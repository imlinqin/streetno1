<div class="foot-body">

 
 
  <div class="footer open hide" id="footerOpen" name="footerOpen">
	  <div class="wrap">
	<div class="inner clear">
		<div class="up">
			<div class="down" style="float: left;">
			<ul class="footerMenu clear">	
				<li><a href="/article.php?id=85">公司简介</a></li>
			
				<li><a href="#">FAQ</a></li>
				<li><a href="/article.php?id=81">客服中心</a></li>
				<li><a href="/article.php?id=86">充值预付款</a></li>
				<!--<li><a href="./?menuType=community&b_code=REFUND">换货ㆍ退货</a></li>-->
				
				<li><ul>
					<li><img src="themes/default/images/f_logo2.png" alt="visa master card"></li>
					
				</ul></li>
			</ul>
			<div class="text">
				<p class="t03" >联系电话:19927686670 电子邮件:contact@streetno1.com<br>
				Copyright ⓒstreetno1.com  All rights reserved.<br> <a style="color: #999" href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备17073220号</a>
				<br></p>
			</div>
		</div>
			<div class="cs">
				
				<h1>19927686670</h1>
				<p>周一 ～ 周五 AM 10:00 ~ PM 12:00 &nbsp;&nbsp;PM 13:00 ~ PM 19:00</p>
				<p>周六 AM 09:00 ~ PM 13:00 
				</p>
			</div>
		</div>
		
	</div>
	</div>
	</div>
  
  
 <?php if ($this->_var['helps']): ?>
    <div class="foot-help" style="height: 1px;overflow: hidden;padding-top: 0">
      <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['foo']['iteration']++;
?>
        <?php if ($this->_foreach['foo']['iteration'] < 5): ?>
        <dl>
          <dt class="xs-<?php echo $this->_foreach['foo']['iteration']; ?>"><?php echo $this->_var['help_cat']['cat_name']; ?></dt>
            <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <dd><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>"><?php echo $this->_var['item']['short_title']; ?></a></dd>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </dl>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <div class="foot-weixin">
          <div class="weixin-txt">关注demo微信</div>
          <div class="weixin-pic">
            <img src="themes/default/images/weixin.jpg">
          </div>
        </div>
    </div>
    <?php endif; ?> 
    
   
  
  

    
    
  
</div>
 


 <script language="javascript">
(function(){
var obj = document.getElementById("sideFloat");
var top = getTop(obj);

var isIE6 = /msie 6/i.test(navigator.userAgent);
window.onscroll = function(){
var bodyScrollTop = document.documentElement.scrollTop || document.body.scrollTop;
if (bodyScrollTop > top){
obj.style.position = (isIE6) ? "absolute" : "fixed";
obj.style.top = (isIE6) ? bodyScrollTop + "px" : "0px";
} else {
obj.style.position = "abosolue";
	obj.style.top = "210px";

}


}


//var isIE6 = /msie 6/i.test(navigator.userAgent);

function getTop(e){
var offset = e.offsetTop;
if(e.offsetParent != null) offset += getTop(e.offsetParent);
return offset;
}
})()
</script>
 

 

