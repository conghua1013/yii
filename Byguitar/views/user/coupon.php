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
                    <dl class="couponhbox">
                        <dt><strong>在账户中绑定新的优惠券</strong></dt>
                        <dd>
                            <div class="item uitem">
                                <label>输入代码:</label>
                                <input name="input_name" type="text" class="fl input sinput" id="input_name1" size="20" />
                                <span class="alert" style="display:none">不正确</span>
                                <div class="fl btn btn-primary" id="bandcoupon-btn">绑定</div>
                                <div class="clear"></div>
                            </div>
                        </dd>
                    </dl>
                    <div class="couponlist">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ordertab">
                            <tr>
                                <th width="77" align="center" valign="middle">券号</th>
                                <th width="77" align="center" valign="middle">面值</th>
                                <th width="196" align="center" valign="middle">名称/使用规则</th>
                                <th width="197" align="center" valign="middle">有效期</th>
                                <th width="67" align="center" valign="middle">状态</th>
                            </tr>

                            <?php if(!empty($list)): ?>
                                <?php foreach($list as $row): ?>
                                    <tr>
                                        <td align="center" valign="middle"><?php echo $row['coupon_sn']; ?></td>
                                        <td align="center" valign="middle">¥<?php echo $row['coupon_amount']; ?></td>
                                        <td align="center" valign="middle">
                                            <p class="coupon-nmae"><?php echo isset($couponTypeList[$row['coupon_type_id']])? $couponTypeList[$row['coupon_type_id']]['coupon_name'] : '-'; ?><br />
                                                <?php if($row['satisfied_amount'] == 0): ?>
                                                    满<?php echo $row['satisfied_amount']; ?>元可用
                                                <?php else: ?>
                                                    无金额使用限制
                                                <?php endif; ?>
                                            </p></td>
                                        <td align="center" valign="middle">
                                            <?php echo date('Y-m-d H:i:s',$row['start_time']); ?> 至
                                            <?php echo date('Y-m-d H:i:s',$row['end_time']); ?>
                                        </td>
                                        <td align="center" valign="middle"><span class="qing"><?php echo $row['coupon_status']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr> <td colspan="5">暂时没有数据！</td>  </tr>
                            <?php endif; ?>

                        </table>
                        <!--页码-->
                        <div class="page_box">
                            <?php echo $pages ? $pages['str'] : ''; ?>
                        </div>
                    </div>
                    <div class="yhq_intro">
                        <div><strong>如何使用优惠券？</strong></div>
                        <div>
                            <ol>
                                <li>如果您得到的是一串优惠券代码，那么你可以在购物车页或此页绑定优惠券。</li>
                                <li>如果优惠券直接发到了您的账户，那么您不需要绑定。</li>
                                <li>在购物车的优惠券模块中选用优惠券，将可以抵扣相应的金额。</li>
                                <li><a class="qing" href="">点击查看优惠券/礼品卡的示意图说明&gt;&gt;</a></li>
                            </ol>
                        </div>
                        <div><strong>优惠券使用规则：</strong></div>
                        <div>
                            <ol>
                                <li>购物车的商品金额总计满足一定金额时，优惠券才能使用。比如:购物车的商品金额总计超过50元时，5元优惠券可用；</li>
                                <li>每张订单只能使用一张优惠券，使用后若取消订单，该券将恢复；</li>
                                <li>优惠券必须在优惠券内使用，过期作废，优惠券不能兑换现金；</li>
                                <li>使用优惠券支付的订单，发生退货由用户自行承担运费；退款结算按照实际结算金额退款，优惠券不能用来抵扣商品运费。</li>
                            </ol>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </dd>
    </dl>
</div>