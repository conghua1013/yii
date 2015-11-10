<div class="tip"></div>
<div class="main">
    <div class="flowbox">
        <div class="ch_t">
            <h1 class="fl">提交订单成功</h1>
            <span class="fl">我们将马上处理您的订单</span>
            <div class="clear"></div>
        </div>
        <dl class="over_box">
            <dt>
            <h2>订单提交成功，还有最后一步哦</h2>
            </dt>
            <dd>
                <div class="item over_item"> <span class="tieshi">如果您当前的浏览器可能不支持银行网站付款，您可以使用IE浏览器登录“<a class="blue" href="/user/orderlist">设置中心&gt;我的订单</a>”，完成支付</span>
                    <div class="clear"></div>
                </div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="cinfo_box cart_box over_tab">
                    <tr>
                        <th width="25%" align="center" valign="middle" style="border-left:1px solid #f4f4f4;">订单号</th>
                        <th width="25%" align="center" valign="middle">支付金额</th>
                        <th width="25%" align="center" valign="middle">支付方式</th>
                        <!-- <th width="25%" align="center" valign="middle">获得积分</th> -->
                    </tr>
                    <tr>
                        <td width="25%" align="center" valign="middle" style="border-left:1px solid #fff;"><a href="/user/order/orderSn/<?php echo $oInfo['order_sn']; ?>" class="blue"><?php echo $oInfo['order_sn']; ?></a></td>
                        <td width="25%" align="center" valign="middle"><code>¥<?php echo $oInfo['need_pay_amount']; ?></code></td>
                        <td width="25%" align="center" valign="middle">支付宝</td>
                        <!-- <td width="25%" align="center" valign="middle"><code>{$oInfo.order_amount}</code></td> -->
                    </tr>
                </table>
                <ul>
                    <li><b>提示：</b></li>
                    <li>1.付款完成之后，我们将立即处理您的订单，未付款的订单将被保留24小时，请在24小时之内完成支付。</li>
                    <li>2.每天16:00以前的订单将在当天发货，16:00-0:00的订单将在第二天发货。</li>
                    <li>3.收货后请及时验货，如果发现商品损毁或不符，请及时联系我们。<a href="/public/guide/" class="qing">退换货政策&gt;&gt;</a></li>
                </ul>
                <div class="over_btn"> <a class="fl white btn btn-large btn-brown" target="_blank" href="/order/pay/<?php echo $oInfo['order_sn']; ?>" id="pay_btn">立即付款</a>
                    <div class="clear"></div>
                </div>
            </dd>
        </dl>
    </div>
</div>


