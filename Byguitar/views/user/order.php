<link href="/css/web/user.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/js/web/user.js"></script>

<div class="tip">
    <div class="arrow"></div>
</div>
<div class="main">
<dl class="regbox setsbox">
<dt> <ul class="regbar_box"> <li class="fl regbar regbar_on">订单详情</li> </ul> </dt>
<dd id="reg_box" class="">
    <?php $this->beginContent('/user/sidebar'); ?> <?php $this->endContent(); ?>
    <div class="fl setbox">
        <div class="regform orderbox">
            <div class="myorder_tip">
                <div class="myorder_top" id="orderInfo" oid="<?php echo $info['id']; ?>" orderSn="<?php echo $info['order_sn']; ?>">
                    <span class="fl"><b>订单号：<?php echo $info['order_sn']; ?></b></span>
                    <span class="fl"><b>&nbsp;&nbsp;&nbsp;&nbsp;状态：</b><strong>
                            <?php echo $info['order_status_txt']; ?><!-- 未付款 已付款 配送中 --></strong></span>
                    <span class="fr">
                    <?php if($info['order_status'] == 0): ?>
                        <a class="fl btn btn-large btn-primary white" href="/pay/<?php echo $info['order_sn']; ?>">立即付款</a>
                    <?php endif; ?>

                    <?php if($info['order_status'] == 0): ?>
                        <a class="fl btn btn-small cancel_btn">取消订单</a>
                    <?php endif; ?>

                    <?php if($info['order_status'] == 5): ?>
                        <a class="fl btn btn-small btn-primary white" id="receiveBtn">确认收货</a>
                    <?php endif; ?>

                    </span>
                    <div class="clear"></div>
                </div>

                <?php if($info['shipping_status'] == 1): ?>
                <div class="myorder_div">
                    <span>配送方式：快递</span>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;快递公司：<?php echo $info['shipping_name']; ?></span>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;货运单号：<?php echo $info['shipping_sn']; ?></span>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="qing" href="">查看订单配送状态&gt;&gt;</a></span>
                </div>
                <?php endif; ?>

            </div>
            <div class="order_going">
                <?php if(!empty($status)): ?>
                <?php foreach($status as $key => $row): ?>
                    <div class="fl order_step">
                        <?php if($row['status']): ?>
                            <div class="ordstep_line ordstep_lineed  <?php if($key == 'create'): ?>ordstep_f<?php elseif($key == 'receive'): ?>ordstep_l<?php endif; ?>">&nbsp;</div>
                            <div class="ordstep_arrow ordstep_arrowed">&nbsp;</div>
                            <div class="ordstep_txt ordstep_txton">
                                <p><strong><?php echo $row['name']; ?></strong></p><?php echo $row['time']; ?>
                            </div>
                        <?php else: ?>
                            <div class="ordstep_line <?php if($key == 'create'): ?>ordstep_f<?php elseif($key == 'receive'): ?>ordstep_l<?php endif; ?>">&nbsp;</div>
                            <div class="ordstep_arrow">&nbsp;</div>
                            <div class="ordstep_txt ">
                                <p><strong><?php echo $row['name']; ?></strong></p><?php echo $row['time']; ?>
                            </div>
                        <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <div class="clear"></div>
        </div>
        <div class="order_box">
            <div class="order_boxtop"><strong>订单跟踪</strong></div>
            <div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ordergo_tab">
                    <tr>
                        <th width="156">操作时间</th>
                        <th width="500">操作信息</th>
                        <th>操作人</th>
                    </tr>

                    <?php if(!empty($logs)): ?>
                    <?php foreach($logs as $row): ?>
                        <tr>
                            <td valign="bottom"><?php echo $row['add_time']>0 ? date('Y-m-d H:i:s',$row['add_time']) : ''; ?></td>
                            <td valign="bottom"><?php echo $row['msg']; ?></td>
                            <td valign="bottom"><?php echo $row['admin_name']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </table>
                <br/>
                <br/>
                <br/>

                <?php if($info['shipping_status'] == 1): ?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ordergo_tab">
                        <tr>
                            <td width="605">配送方式：快递&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                快递公司：<?php echo $info['shipping_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                货运单号：<?php echo $info['shipping_sn']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>承运人电话：<?php echo $info['phone']; ?></td>
                            <td>
                                <a href="#" target="_blank" class="blue">查看订单配送状态&gt;&gt;</a>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>

            </div>
        </div>
        <div class="order_box">
            <div class="order_boxtop"><strong>收货人信息</strong></div>
            <div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="orderinfo_tab">
                    <tr>
                        <td width="78" align="right" valign="top">收货人姓名：</td>
                        <td align="left" valign="top"><?php echo $info['consignee']; ?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">所在城市：</td>
                        <td align="left" valign="top"><?php echo $info['province_name'].$info['city_name'].$info['district_name']; ?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">详细地址：</td>
                        <td align="left" valign="top"><?php echo $info['address']; ?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">手机号码：</td>
                        <td align="left" valign="top"><?php echo $info['mobile']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="order_boxtop"><strong>配送与付款方式</strong></div>
            <div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="orderinfo_tab">
                    <tr>
                        <td width="78" align="right" valign="top">配送方式：</td>
                        <td align="left" valign="top"><?php echo $info['shipping_name']; ?></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">付款方式：</td>
                        <td align="left" valign="top"><?php echo $info['pay_name']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="order_boxtop"><strong>商品清单</strong></div>
            <div>
                <div id="ordlist_top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="41%">商品</td>
                            <td width="13%" align="center">单价</td>
                            <td width="14%" align="center">数量</td>
                            <td width="16%" align="center">小计</td>
                        </tr>
                    </table>
                </div>
                <div id="ordlist">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <?php if(!empty($orderProduct)): ?>
                            <?php foreach($orderProduct as $row): ?>
                            <tr>
                                <td width="10%">
                                    <?php if($row['type'] == 1): ?>
                                        <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank" ><img src="<?php echo $row['images']['cover']; ?>" width="60" /></a>
                                    <?php elseif($row['type'] == 2): ?>
                                        <a href="/zine/<?php echo $row['product_id']; ?>" target="_blank" ><img src="<?php echo $row['images']['cover']; ?>" width="60" /></a>
                                    <?php else: ?>
                                        <a href="/item/<?php echo $row['product_id']; ?>" target="_blank"><img src="<?php echo $row['images']['image_120']; ?>" width="60" /></a>
                                    <?php endif; ?>
                                </td>
                                <td width="30%">
                                    <?php if($row['type'] == 1): ?>
                                        <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?></a>
                                    <?php elseif($row['type'] == 2): ?>
                                        <a href="/zine/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                    <?php else: ?>
                                        <a href="/item/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                    <?php endif; ?>
                                </td>
                                <td width="14%" align="center">¥<?php echo $row['sell_price']; ?></td>
                                <td width="15%" align="center"><?php echo $row['quantity']; ?></td>
                                <td width="15%" align="center"><b>¥<?php echo $row['total_price']; ?></b></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <div>
                <div class="fl fp_box">

                </div>
                <ul class="fr cart_sum" style="padding-right:0;">
                    <li>订单商品金额：<b>¥<?php echo $info['product_amount']; ?></b></li>
                    <li>优惠券折扣：<b>- ¥<?php echo $info['coupon_amount']; ?></b></li>
                    <li>折扣：<b>- ¥<?php echo $info['discount']; ?></b></li>
                    <li>运费：<b>+ ¥<?php echo $info['shipping_fee']; ?></b></li>
                    <li>现金账号支付：<b>-¥<?php echo $info['pay_amount']; ?></b></li>
                    <li>
                        <p class="sum_num">应付金额：<font>¥<?php echo $info['need_pay_amount']; ?></font></p>
                    </li>

                    <?php if($info['order_status'] == 0): ?>
                        <li> <a class="btn btn-large btn-primary white" style="margin:0;" href="/pay/<?php echo $info['order_sn']; ?>">立即付款</a> </li>
                    <?php endif; ?>

                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
</dd>
</dl>
</div>