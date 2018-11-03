<?php if ($this->_var['full_page']): ?> <?php echo $this->fetch('pageheader.htm'); ?> <?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 订单搜索 -->
<div class="form-div">


  <form action="javascript:searchOrder()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" /> date
    <input name="korea_start_date" type="date" value='<?php echo $this->_var['korea_start_date']; ?>' size="12" maxlength="10" /> -
    <input name="korea_end_date" type="date" size="12" value='<?php echo $this->_var['korea_end_date']; ?>' maxlength="10" /> order_sn
    <input name="order_sn" type="text" size="20" value='' maxlength="20" />

    <select name="status_paizi">
      <option value="-1">상품발송상태선택</option>
      <option value="0">준비중</option>
      <option value="1">품절</option>
      <option value="2">발송</option>
      <option value="3">예약배송</option>

    </select>
    <select name="orderStatus">
      <option value="-1">주문장상태선택</option>
      <option value="1">미발송주문장</option>
      <option value="2">발송완료주문장</option>
      <option value="3">not include cancel order</option>
    </select>

    <input type="submit" value="조회" class="button" />
  </form>
</div>

<!-- 订单列表 -->

<form method="post" action="orderpaizi.php" name="listForm" onsubmit="return check()">
  <div class="list-div" id="listDiv">
    <?php endif; ?>

    <table cellpadding="3" cellspacing="1">
      <tr>
        <th>
          <input onclick='listTable.selectAll(this, "rec_id")' type="checkbox" <?php if ($this->_var['node_info']): ?>disabled<?php endif; ?>/>
          <a href="javascript:listTable.sort('delivery_sn', 'DESC'); "><?php echo $this->_var['lang']['label_order_sn']; ?></a><?php echo $this->_var['sort_delivery_sn']; ?>
        </th>
        <th>
          <a href="#">img</a>
        </th>
        <th>
          <a href="javascript:listTable.sort('order_sn', 'DESC'); ">상품명 <!--名称--></a><?php echo $this->_var['sort_order_sn']; ?></th>
        <th>
          <a href="#"> 브랜드 <!--韩国名称/牌子--></a>
        </th>

        <th>
          <a href="javascript:listTable.sort('add_time', 'DESC'); ">품번 <!--货号--></a><?php echo $this->_var['sort_add_time']; ?></th>
        <th>
          <a href="javascript:listTable.sort('consignee', 'DESC'); ">색상 사이즈 <!--颜色码数--></a><?php echo $this->_var['sort_consignee']; ?></th>
        <th>
          <a href="javascript:listTable.sort('update_time', 'DESC'); ">Number <!--数量--></a><?php echo $this->_var['sort_update_time']; ?></th>

        <th>주문일자 <!--下单时间--></th>

        <th>handler</th>
        <tr>
          <?php $_from = $this->_var['delivery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
          <tr>
            <td valign="top" nowrap="nowrap">
              <input type="checkbox" name="rec_id[]" value="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['node_info']): ?>disabled<?php endif; ?> /><?php echo $this->_var['goods']['order_sn']; ?></td>
            <td>
              <img width="100" src="../../<?php echo $this->_var['goods']['goods_thumb']; ?>" />
            </td>
            <td><?php echo $this->_var['goods']['goods_name']; ?> </td>
            <td><?php echo $this->_var['goods']['korea_name']; ?> <?php echo $this->_var['goods']['brand_name']; ?> </td>
            <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
            <td><?php echo $this->_var['goods']['goods_attr']; ?></td>
            <td><?php echo $this->_var['goods']['goods_number']; ?></td>

            <td><?php echo $this->_var['goods']['add_time']; ?>
              <br />
               handler:<?php echo $this->_var['goods']['paizi_time']; ?>
            </td>

            <td>
            <?php if ($this->_var['goods']['order_status'] == 5): ?>
               <?php if ($this->_var['goods']['status'] == 2): ?>
              <p style="color:blue">발송완료(중)
                <!--已发货完成-->
              </p> 
               <?php elseif ($this->_var['goods']['status'] == 4): ?>
              <p style="color:red">取消
                <!--取消-->
              </p>
              <?php endif; ?>
            
              준비중 <!--(准备中）-->
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status_paizi'] == 0): ?>checked="checked"
                <?php endif; ?> onclick="listTable.toggle_a(this, 0, <?php echo $this->_var['goods']['rec_id']; ?>)" /> 품절<!--(缺货）-->
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status_paizi'] == 1): ?>checked="checked" <?php endif; ?> onclick="listTable.toggle_a(this, 1, <?php echo $this->_var['goods']['rec_id']; ?>)"
              />  
              </br>
               발송<!--(发货）-->
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status_paizi'] == 2): ?>checked="checked" <?php endif; ?> onclick="listTable.toggle_a(this, 2, <?php echo $this->_var['goods']['rec_id']; ?>)"
              /> 예약배송<!--(预售）-->
              <input type="radio" name="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['status_paizi'] == 3): ?>checked="checked" <?php endif; ?> onclick="listTable.toggle_a(this, 3, <?php echo $this->_var['goods']['rec_id']; ?>)"
              />
              
            
            
           


              <br/> remark<!--(备注)-->
              <input type="text" name="<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['remark_paizi']; ?>" onclick="listTable.edit_a(this, 'edit_remark_paizi', <?php echo $this->_var['goods']['rec_id']; ?>)"
              />
            <?php elseif ($this->_var['goods']['order_status'] == 1 && $this->_var['goods']['pay_status'] == 0): ?>
              <span style="color:red">결제진행중</span>
            <?php else: ?> <span style="color:red">order cancel</span><?php endif; ?>
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

<input name="delivery_export" type="submit" id="btnSubmit3" value="download" class="button" disabled="true" onclick="{if(confirm('download?')){return true;}return false;}"
/>
    <?php if ($this->_var['full_page']): ?>

  </div>
</form>
<script language="JavaScript">
  console.log('filter', listTable)
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
      // listTable.filter['brand_id'] = document.forms['searchForm'].elements['brand_id'].value;
      // listTable.filter['delivery_sn'] = document.forms['searchForm'].elements['delivery_sn'].value;
      listTable.filter['korea_start_date'] = document.forms['searchForm'].elements['korea_start_date'].value;
      listTable.filter['korea_end_date'] = document.forms['searchForm'].elements['korea_end_date'].value;
      listTable.filter['order_sn'] = document.forms['searchForm'].elements['order_sn'].value;
      listTable.filter['status_paizi'] = document.forms['searchForm'].elements['status_paizi'].value;
      //  listTable.filter['status_paizi'] = document.forms['searchForm'].elements['status_paizi'].value;
      listTable.filter['orderStatus'] = document.forms['searchForm'].elements['orderStatus'].value;



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

      var res = Ajax.call(listTable.url, "act=ordergoodstatus" + "&val=" + act + "&id=" + id, null, "POST", "JSON", false);
      console.log(111, act)
      if (res.message) {
        alert(res.message);
      }

      if (res.error == 0) {
        //obj.src = (res.content > 0) ? 'images/yes_a.gif' : 'images/no_a.gif';
        // console.log(112,res)
      }
    }

    /**
     * 创建一个可编辑区
     */
    listTable.edit_a = function (obj, act, id) {
      // var tag = obj.firstChild.tagName;



      /* 编辑区失去焦点的处理函数 */
      obj.onblur = function (e) {

        res = Ajax.call(listTable.url, "act=" + act + "&val=" + encodeURIComponent(Utils.trim(obj.value)) + "&id=" + id, null, "POST", "JSON", false);

        if (res.message) {
          alert(res.message);
        }

        console.log('remark', listTable)
        if (Utils.trim(obj.value).length > 0) {
          // res = Ajax.call(listTable.url, "act=" + act + "&val=" + encodeURIComponent(Utils.trim(obj.value)) + "&id=" + id, null, "POST", "JSON", false);

          // if (res.message) {
          //   alert(res.message);
          // }

          // console.log('remark', obj.value)
          // obj.value = (res.error == 0) ? res.content : '';
        }
        else {
          obj.value = '';
        }
      }
    }


</script>  <?php echo $this->fetch('pagefooter.htm'); ?> <?php endif; ?>