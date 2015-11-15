<link href="/css/web/user.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/js/web/user.js"></script>

<div class="tip">
    <div class="arrow"></div>
</div>
<div class="main">
    <dl class="regbox setsbox">
        <dt>
        <ul class="regbar_box">
            <li class="fl regbar regbar_on">个人信息设置</li>
        </ul>
        </dt>
        <dd id="reg_box" class="">
            <?php $this->beginContent('/user/sidebar'); ?> <?php $this->endContent(); ?>
            <div class="fl setbox">
                <div class="regform orderbox">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ordertab">
                        <tr>
                            <th width="148" align="center" valign="middle">订单号</th>
                            <th width="78" align="center" valign="middle">收货人</th>
                            <th width="56" align="center" valign="middle">金额</th>
                            <th width="74" align="center" valign="middle">付款方式</th>
                            <th width="128" align="center" valign="middle">下单时间</th>
                            <th width="125" align="center" valign="middle">订单状态</th>
                            <th width="141" align="center" valign="middle">操作</th>
                        </tr>
                        <<?php if(!empty($list)): ?>
                        <?php foreach($list as $row): ?>
                            <tr>
                                <td align="center" valign="middle">
                                    <a class="qing" href="/user/order/<?php echo $row['order_sn'];?>"><?php echo $row['order_sn'];?></a>
                                </td>
                                <td align="center" valign="middle"><?php echo $row['consignee']; ?></td>
                                <td align="center" valign="middle"><?php echo $row['order_amount']; ?></td>
                                <td align="center" valign="middle"><?php echo $row['pay_name']; ?></td>
                                <td align="center" valign="middle"><?php echo date('Y-m-d H:i:s',$row['add_time']); ?></td>
                                <td align="center" valign="middle"><?php echo $row['order_status_txt']; ?></td>
                                <td align="center" valign="middle">
                                    <a class="qing" href="/user/order/<?php echo $row['order_sn']; ?>">查看详情</a>
                                    <?php if($row['order_status'] == 0): ?>
                                        <a class="btn btn-small btn-primary white" href="/shop/pay/<?php echo $row['order_sn']; ?>">
                                            立即付款</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>

                    </table>
                    <!--页码-->
                    <div class="page_box"> <?php echo isset($pages) ? $pages['str'] : ''; ?> </div>

                </div>
            </div>
            <div class="clear"></div>
        </dd>
    </dl>
</div>