<script type="text/javascript" src="/js/web/region.js"></script>
<div class="tip"></div>
<div class="main">

    <!-- <div class="note" id="ch_note">很抱歉，您的积分不足，请删除一些积分换购的商品，再结算。</div> -->

    <div class="flowbox">

        <div class="ch_t">
            <h1 class="fl">填写核对订单信息</h1>
            <!--<p class="fr"><img src="imgs/public/flow_tel.gif" />&nbsp;&nbsp;7×24客服:400-696-8686</p>-->
            <div class="clear"></div>
        </div>

        <dl class="cinfo_box">
            <dt><b>收货人信息</b></dt>
            <dd id="addr_editbox" isshow="off">
                <ul class="addr_list" id="addr_list">

                    <!-- 引用地址公用块 -->
                    <?php if(!empty($addList)): ?>
                    <?php foreach($addList as $row): ?>
                        <li <?php if($row['is_default']): ?>class="addr_on"<?php endif; ?> id="addr-<?php echo $row['id'];?>" aid="<?php echo $row['id'];?>" >
                        <div>
                            <input checked="checked" type="radio" name="addr" id="addr_<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" />
                            <p><span><b><?php echo $row['consignee'];?></b></span><span><?php echo $row['mobile'];?></span></p>
                            <p><span><?php echo $row['province_name'];?>-<?php echo $row['city_name'];?>-<?php echo $row['district_name'];?></span>
                                <span><?php echo $row['address'];?></span></p>
                        </div>
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="clear"></div>
                </ul>
                <div class="clear"></div>
                <div class="uernewaddr" id="addr_modify">
                    <span>使用新地址</span>
                    <div class="yhqarrow addrarrow"></div>
                </div>
                <div class="addr_item" dd="dd" id="addnewaddrs" <?php if(!empty($addList)): ?>style="display:none;"<?php endif; ?> >
                <div class="item">
                    <label>收货人姓名:</label>
                    <input name="usname" type="text" class="fl input sinput" id="usname" size="20" />
                    <span></span>
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <label>收货人姓名:</label>
                    <select name="usprovince" class="fl mgr15" onchange="chgprovince(this.value);" id="usprovince">
                        <option value="0">请选择省</option>
                    </select>
                    <select name="uscity" class="fl mgr15" onchange="chgcity(this.value);" id="uscity">
                        <option value="0">请选择市</option>
                    </select>
                    <select name="usdistrict" class="fl mgr15"  id="usdistrict">
                        <option value="0">请选择区</option>
                    </select>
                    <span></span>
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <label>详细地址:</label>
                    <input name="usaddr" type="text" class="fl input binput" id="usaddr" size="78" />
                    <span></span>
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <label>手机号码:</label>
                    <input name="sumob" type="text" class="fl input sinput" id="usmob" size="20" />
                    <span></span>
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <label>&nbsp;</label>
                    <div class="fl btn btn-large btn-primary" id="addr_btn">添加新地址</div>
                    <span id="modaddr_alert"></span>
                    <div class="clear"></div>
                </div>
    </div>
    </dd>
    </dl>

    <dl class="cinfo_box">
        <dt id="wp_title"><b>付款方式</b></dt>
        <dd  id="payment_editbox" isshow="off">
            <div class="post_list">
                <div class="bank_box">
                    <div>

                        <?php if(!empty($payList['plat'])): ?>
                        <?php foreach($payList['plat'] as $row): ?>
                        <p class="fl">
                            <input type="radio" <?php if($row['id'] == 1):?>checked="checked"<?php endif; ?> value="<?php echo $row['id'];?>" way="<?php echo $row['pay_name'];?>" id="radio_<?php echo $row['id'];?>" name="pay_id">
                            <label for="radio_<?php echo $row['id'];?>">
                                <img width="131" height="37" src="/Public/Images/payment/<?php echo $row['payment_logo'];?>" alt="<?php echo $row['pay_name'];?>" />
                            </label>
                        </p>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="clear"></div>
                    </div>


                        <?php if(!empty($payList['bank'])): ?>
                        <div class="spline bank_split"></div>
                        <div>
                            <?php foreach($payList['bank'] as $row): ?>
                                <p class="fl">
                                    <input type="radio" value="<?php echo $row['id'];?>" way="<?php echo $row['pay_name'];?>" id="radio_<?php echo $row['id'];?>" name="pay_id">
                                    <label for="radio_<?php echo $row['id'];?>">
                                        <img width="131" height="37" src="/Public/Images/payment/<?php echo $row['payment_logo'];?>" alt="<?php echo $row['pay_name'];?>" />
                                    </label>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    <div class="clear"></div>
                </div>

            </div>
        </dd>
    </dl>

    <dl class="cinfo_box">
        <dt><b>购物清单</b><a class="qing" href="/cart/index">返回购物车修改</a></dt>
        <dd class="cinfo_off"   style="position:relative;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_box">
                <tr>
                    <th width="75">商品</th>
                    <th width="280">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th width="90">单价</th>
                    <th width="90">花费积分</th>
                    <th width="90">数量</th>
                    <th width="90">小计</th>
                </tr>
                <?php if(!empty($list)): ?>
                <?php foreach($list as $row): ?>
                    <tr cid="<?php echo $row['id']; ?>" id="cart-<?php echo $row['id']; ?>">
                        <td align="left">
                            <?php if($row['type'] == 1): ?>
                                <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"><img src="<?php echo $row['pInfo']['image']['image_120']; ?>" width="60" height="60" alt="<?php echo $row['product_name']; ?>"/></a>
                            <?php elseif($row['type'] == 2): ?>
                                <a href="/zine/<?php echo $row['product_id'];?>" target="_blank" id="pname_<?php echo $row['id'];?>"><img src="<?php echo $row['pInfo']['image']['image_120'];?>" width="60" height="60" alt="<?php echo $row['product_name'];?>"/></a>
                            <?php else: ?>
                                <a href="/item/<?php echo $row['product_id'];?>" target="_blank" id="pname_<?php echo $row['id'];?>"><img src="<?php echo $row['pInfo']['image']['image_120'];?>" width="60" height="60" alt="<?php echo $row['product_name'];?>"/></a>
                            <?php endif; ?>
                        </td>
                        <td align="left">
                            <p class="cart_name">
                                <?php if($row['type'] == 1): ?>
                                    <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                <?php  elseif($row['type'] == 2): ?>
                                    <a href="/zine/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                <?php else: ?>
                                    <a href="/item/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                <?php endif; ?>
                            </p>
                        </td>
                        <td align="center"><!-- <span class="pbars pbars2">特价</span> --></td>
                        <td align="center">¥<?php echo $row['sell_price']; ?></td>
                        <td align="center">0</td>
                        <td align="center"><?php echo $row['quantity']; ?></td>
                        <td align="center"><span><b>¥<?php echo $row['total_price']; ?></b></span></td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <div class="cart_info">
                <div class="cart_infoline" id="yhqbox1">
                    <label>输入优惠券/兑换券:</label>
                    <input class="fl input sinput" name="coupon_number" id='coupon_number' type="text" />
                    <!-- <p class="fl yhqyzm_box" style="display:;"> 验证码：<img src="Images/public/yzm.gif" width="69" height="21" />
                       <input class="input yhq_yzm" name="" type="text" />
                     </p>-->
                    <div class="fl useyhq_btn" id="useyhq_btn">使用</div>
                    <span class="alert1 alert"></span> <a class="qing" id="useryhq1">或使用账户中已有优惠券&nbsp;&gt;&gt;</a>
                    <div class="clear"></div>
                </div>
                <div class="cart_infoline" id="yhqbox2" style="display:none;">
                    <label>使用已有优惠券:</label>
                    <div class="fl yhq_select">
                        <input class="input yhq_input" id="yhq_input" name="" type="text" style="width:226px;" value="" />
                        <ul class="yhq_list">
                            <li class="yhq_off">请选择优惠券...</li>

                            <?php if(!empty($couponlist)): ?>
                            <?php foreach($couponlist as $row): ?>
                                <li class="yhq_on" couponsn="<?php echo $row['coupon_sn'];?>">¥<?php echo $row['coupon_amount'];?>（满¥<?php echo $row['satisfied_amount'];?>可用）有效期至<?php echo date('Y-m-d',$row['end_time']); ?>[<?php echo $row['coupon_name'];?>]</li>
                            <?php endforeach; ?>
                            <?php endif; ?>

                        </ul>
                        <div class="yhqarrow"></div>
                        <div class="yhqarrowbg"></div>
                    </div>
                    <a class="fl qing" id="useryhq2">或输入优惠券/兑换券&nbsp;&gt;&gt;</a>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="cart_infoline" id="ordermsg" style="display:;">订单留言：<input placeholder="选填：订单说明（比如颜色，特别要求如快递，送货时间，以及一些特殊赠品等的一些东西等。）" class="input yhq_input" id="ordermsginput" name="ordermsginput" type="text" style="width:426px;" value="" />
            </div>
            <div class="ch_xiaoji">
                <!--<div class="fl fapiao">
                  <div class="fpbox">
                    <div class="fp_sel">
                      <input name="" type="checkbox"  id="fp2" />
                      <label for="fp2">索要发票</label>
                      <label id="fpmod2" class="qing hide">修改</label>
                    </div>
                    <div class="hide fp_on" id="fpedit2" isshow="off">
                      <div class="item fpitem">
                        <label>发票抬头:</label>
                        <input name="fptaitou" type="text" class="fl input minput" id="fptaitou" />
                        <span></span>
                        <div class="clear"></div>
                      </div>
                      <div class="item fpitem">
                        <label>发票内容:</label>
                        <select name="fbneirong" id="fbneirong">
                          <option selected="selected" value="办公用品">办公用品</option>
                          <option value="其他用品">其他用品</option>
                        </select>
                      </div>
                      <div class="item fpitem">
                        <label>&nbsp;</label>
                        <div class="fl btn btn-small btn-primary" id="fpsure_btn2">确认</div>
                        <div class="fl btn btn-small btn-brown" id="fpcancle_btn2">取消</div>
                        <span id="fp2_alert"></span>
                        <div class="clear"></div>
                      </div>
                    </div>
                    <div class="hide" id="fpeditok2">
                      <div class="okitem"> <b>发票抬头:</b>
                        <p></p>
                        <div class="clear"></div>
                      </div>
                      <div class="okitem"> <b>发票内容:</b>
                        <p></p>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                </div>-->
                <div class="fr">
                    <ul class="fr cart_sum">
                        <li><!-- <span>花费积分:2000</span> -->商品金额（不含运费）:<b id="productAmount">¥<?php echo $total['product_amount'];?></b></li>
                        <li>运费:<b id="shippingFee">+ ¥<?php echo $total['shipping_fee'];?></b></li>
                        <li>优惠券折扣:<b id="couponAmount">- ¥<?php echo $total['coupon_amount'];?></b></li>
                        <li>折扣:<b id="reduceAmount">- ¥<?php echo $total['reduce_amount'];?></b></li>
                        <li class="sum_num">应付商品金额:<font id="finalAmount">¥<?php echo $total['final_amount'];?></font></li>
                        <!-- <li class="mgt10"><code>您将获得33积分</code></li> -->
                    </ul>
                    <div class="clear"></div>
                    <div class="fr cart_btn"><a class="fr btn btn-large btn-primary" id="postorder_btn">确认无误,提交订单</a>
                        <div class="clear"></div>
                        <div class="fr item sure_item"><span id="post_alert"></span> </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </dd>
    </dl>

</div>
</div>


<?php $this->beginContent('/public/publicpops'); ?> <?php $this->endContent(); ?>