<?php if ($this->_var['full_page']): ?> <?php echo $this->fetch('pageheader.htm'); ?> <?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 订单搜索 -->
<div class="form-div">
  <form method="post" action="order.php?act=fahuoupload" enctype="multipart/form-data">
    <div>发货Excel表导入：</div>
    <input type="file" name="file_stu" />
    <input type="submit" value="导入" />
  
  </form>
  <p></p>
  <form action="javascript:searchOrder()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <!--<?php echo $this->_var['lang']['label_delivery_sn']; ?><input name="delivery_sn" type="text" id="delivery_sn" size="15">
    <?php echo $this->_var['lang']['order_sn']; ?><input name="order_sn" type="text" id="order_sn" size="15">
    <?php echo htmlspecialchars($this->_var['lang']['consignee']); ?><input name="consignee" type="text" id="consignee" size="15">
    <?php echo $this->_var['lang']['label_delivery_status']; ?>
    <select name="status" id="status">
      <option value="-1" selected="selected"><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['lang']['delivery_status'],'selected'=>'-1')); ?>
    </select>-->
    日期
    <input name="korea_start_date" type="date" value='<?php echo $this->_var['korea_start_date']; ?>' size="12" maxlength="10" /> -
    <input name="korea_end_date" type="date" size="12" value='<?php echo $this->_var['korea_end_date']; ?>' maxlength="10" />
    订单号
    <input name="order_sn" type="text" size="20" value='' maxlength="20" />
    <!-- 品牌 -->
    <select name="brand_id"><option value="-1">所有品牌</option><?php echo $this->html_options(array('options'=>$this->_var['brand_list'])); ?></select>
    <select name="status"><option value="-1">请选择商品发货状态</option>
      <option value="0">商品未发货</option>
      <option value="1">商品缺货</option>
      <option value="2">商品已发货</option>
      <option value="3">商品已到货</option>
      <option value="4">商品已取消</option>
      <option value="5">牌子已发货</option>
      <option value="6">牌子已发货+未</option>
    </select>
    <select name="orderStatus"><option value="-1">请选择订单状态</option>
      <option value="1">订单未发货</option>
      <option value="2">订单已发货</option>
      <option value="3">订单不含取消</option>
    </select>
     (到货筛选 是
    <input name="todaydaohuo" type="radio" value=1 /> 否
    <input name="todaydaohuo" type="radio" checked value=0 /> ) 
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<!-- 订单列表 -->
<form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
  <div class="list-div" id="listDiv">
    <?php endif; ?>

    <table cellpadding="3" cellspacing="1">
      <tr>
        <th>
          <input onclick='listTable.selectAll(this, "rec_id")' type="checkbox" <?php if ($this->_var['node_info']): ?>disabled<?php endif; ?>/><a href="javascript:listTable.sort('delivery_sn', 'DESC'); "><?php echo $this->_var['lang']['label_order_sn']; ?></a><?php echo $this->_var['sort_delivery_sn']; ?>
        </th>
        <th>
          <a href="#">图片</a>
        </th>
         <th><a href="javascript:listTable.sort('order_sn', 'DESC'); ">名称</a><?php echo $this->_var['sort_order_sn']; ?></th>
          <th><a href="#">韩国名称</a></th>
        <th><a href="javascript:listTable.sort('order_sn', 'DESC'); ">牌子</a><?php echo $this->_var['sort_order_sn']; ?></th>
        <th><a href="javascript:listTable.sort('add_time', 'DESC'); ">货号</a><?php echo $this->_var['sort_add_time']; ?></th>
        <th><a href="javascript:listTable.sort('consignee', 'DESC'); ">颜色码数</a><?php echo $this->_var['sort_consignee']; ?></th>
        <th><a href="javascript:listTable.sort('update_time', 'DESC'); ">数量</a><?php echo $this->_var['sort_update_time']; ?></th>
       
        <th>下单时间</th>
       
        <th><?php echo $this->_var['lang']['handler']; ?></th>
        <th>发货</th>
        <tr>
          <?php $_from = $this->_var['delivery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
          <tr>
            <td valign="top" nowrap="nowrap"><input type="checkbox" name="rec_id[]" value="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['node_info']): ?>disabled<?php endif; ?> /><?php echo $this->_var['goods']['order_sn']; ?></td>
            <td>
              <img width="100" src="../../<?php echo $this->_var['goods']['goods_thumb']; ?>" />
            </td>
             <td><?php echo $this->_var['goods']['goods_name']; ?></td>
             <td><?php echo $this->_var['goods']['korea_name']; ?></td>
            <td><?php echo $this->_var['goods']['brand_name']; ?></td>
            <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
            <td><?php echo $this->_var['goods']['goods_attr']; ?></td>
            <td><?php echo $this->_var['goods']['goods_number']; ?></td>
            
            <td><?php echo $this->_var['goods']['add_time']; ?><br />
             商品<?php echo $this->_var['goods']['delivery_time']; ?>
            </td>
           
            <td>
              <?php if ($this->_var['goods']['order_status'] == 5): ?>
               <?php if ($this->_var['goods']['status_paizi'] == 2): ?>
              <p style="color:blue">牌子发货
              </p>
             
              <?php endif; ?>
              未<input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status'] == 0): ?>checked="checked"<?php endif; ?>  onclick="listTable.toggle_a(this, 0, <?php echo $this->_var['goods']['rec_id']; ?>)" />
              缺<input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status'] == 1): ?>checked="checked"<?php endif; ?>  onclick="listTable.toggle_a(this, 1, <?php echo $this->_var['goods']['rec_id']; ?>)" /></br>
              发<input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status'] == 2): ?>checked="checked"<?php endif; ?> onclick="listTable.toggle_a(this, 2, <?php echo $this->_var['goods']['rec_id']; ?>)" />
              到
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status'] == 3): ?>checked="checked" <?php endif; ?> onclick="listTable.toggle_a(this, 3, <?php echo $this->_var['goods']['rec_id']; ?>)"/>
              消
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status'] == 4): ?>checked="checked" <?php endif; ?> onclick="listTable.toggle_a(this, 4, <?php echo $this->_var['goods']['rec_id']; ?>)"
              />
              <?php if ($this->_var['goods']['status_paizi'] == 3): ?>
              <p style="color:blueviolet">预售</p>
              <?php endif; ?>
              <p>
                <?php echo $this->_var['goods']['remark_paizi']; ?>
              </p>
              <?php else: ?>
              <span style="color:red">订单已取消</span>
              
              <?php endif; ?>
            </td>
            <td>
               <?php if ($this->_var['goods']['order_status'] == 5): ?>
              <a href="order.php?act=delivery_info&delivery_id=<?php echo $this->_var['goods']['delivery_id']; ?>" target="_blank">发货</a>
               <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>

    <!-- 分页 -->
    <table id="page-table" cellspacing="0">
      <tr>
        <td align="right" nowrap="true">
          <?php echo $this->fetch('page.htm'); ?>
        </td>
      </tr>
    </table>

    <?php if ($this->_var['full_page']): ?>
  </div>
  <div>

    <input name="delivery_export" type="submit" id="btnSubmit3" value="发送email" class="button" disabled="true" onclick="{if(confirm('是否发送')){return true;}return false;}"
    />
   
  </div>
</form>
<script language="JavaScript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    

    onload = function () {
      // 开始检查订单
      startCheckOrder();

      //
      listTable.query = "delivery_email_query";
    }

    /**
     * 搜索订单
     */
    function searchOrder() {
      // listTable.filter['order_sn'] = Utils.trim(document.forms['searchForm'].elements['order_sn'].value);
      // listTable.filter['consignee'] = Utils.trim(document.forms['searchForm'].elements['consignee'].value);
      // listTable.filter['status'] = document.forms['searchForm'].elements['status'].value;
      listTable.filter['brand_id'] = document.forms['searchForm'].elements['brand_id'].value;
      // listTable.filter['delivery_sn'] = document.forms['searchForm'].elements['delivery_sn'].value;
      listTable.filter['korea_start_date'] = document.forms['searchForm'].elements['korea_start_date'].value;
      listTable.filter['korea_end_date'] = document.forms['searchForm'].elements['korea_end_date'].value;
      listTable.filter['order_sn'] = document.forms['searchForm'].elements['order_sn'].value;
      listTable.filter['status'] = document.forms['searchForm'].elements['status'].value;
      listTable.filter['orderStatus'] = document.forms['searchForm'].elements['orderStatus'].value;
      listTable.filter['todaydaohuo'] = document.forms['searchForm'].elements['todaydaohuo'].value;

      
      listTable.filter['page'] = 1;
      listTable.query = "delivery_email_query";
      listTable.loadList();
    }

    function check() {
      var snArray = new Array();
      var eles = document.forms['listForm'].elements;
      for (var i = 0; i < eles.length; i++) {
        if (eles[i].tagName == 'INPUT' && eles[i].type == 'checkbox' && eles[i].checked && eles[i].value != 'on') {
          snArray.push(eles[i].value);
        }
      }
      console.log(111, eles)
      // console.log(111,snArray.toString())
      if (snArray.length == 0) {
        return false;
      }
      else {
        eles['rec_id'].value = snArray.toString();

        return true;
      }
      
    }


    /**
     * 订单货商品切换状态  by lin
     */
    listTable.toggle_a = function (obj, act, id) {
      //var val = (obj.src.match(/yes_a.gif/i)) ? 0 : 1;

      var res = Ajax.call(this.url, "act=ordergoodstatus" + "&val=" + act + "&id=" + id, null, "POST", "JSON", false);
      console.log(111,act)
      if (res.message) {
        alert(res.message);
      }

      if (res.error == 0) {
        //obj.src = (res.content > 0) ? 'images/yes_a.gif' : 'images/no_a.gif';
        console.log(112,res)
      }
    }

</script>
 <?php echo $this->fetch('pagefooter.htm'); ?> <?php endif; ?>