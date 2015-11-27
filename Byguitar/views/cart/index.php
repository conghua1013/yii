<link href="/css/web/flow.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/js/web/flow.js"></script>

<div class="tip"></div>
<div class="main">

    <div class="flowbox">

        <div class="ch_t">
            <h1 class="fl">我的购物车</h1>
            <?php if(!empty($list)): ?><a class="fr white btn btn-small btn-brown checkbtn" id="tocheck-1" href="/cart/checkout">立即结算</a><?php endif; ?>
            <div class="clear"></div>
        </div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_box">
            <tr>
                <th width="90">商品</th>
                <th width="280">&nbsp;</th>
                <th>&nbsp;</th>
                <th width="70">单价</th>
                <th width="160">数量</th>
                <th width="100">小计</th>
                <th width="70">操作</th>
            </tr>

            <?php if(empty($list)): ?>
                <?php if(empty($this->user_id)): ?>
                    <tr>
                        <td colspan="8" align="center" valign="middle"><p><img src="/images/public/cart_empty.gif" />&nbsp;&nbsp;如果您之前在购物车保存过商品，请 <a class="qing" href="/public/login" target="_blank">登录&gt;&gt;</a> 后取出</p></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="8" align="center" valign="middle"><p><img src="/images/public/cart_empty.gif" />&nbsp;&nbsp;您的购物车中没有商品，快去挑选吧。 <a class="qing" href="/" target="_blank">回到首页&gt;&gt;</a></p></td>
                    </tr>
                <?php endif; ?>

            <?php else: ?>

                <volist name="list" id="vo">
                <?php foreach($list as $row): ?>
                    <tr class="g1" cid="<?php echo $row['id']; ?>" id="cart-<?php echo $row['id']; ?>">
                        <td align="center">
                            <?php if($row['type'] == 1): ?>
                                <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank"><img src="<?php echo $row['images']['cover']; ?>" width="60" id="pimg_<?php echo $row['id']; ?>"/></a>
                            <?php elseif($row['type'] == 2): ?>
                                <a href="/zine/<?php echo $row['product_id']; ?>" target="_blank" ><img src="<?php echo $row['images']['cover']; ?>" width="60" id="pimg_<?php echo $row['id']; ?>"/></a>
                            <?php else: ?>
                                <a href="/item/<?php echo $row['product_id']; ?>" target="_blank"><img src="<?php echo $row['images']['image_120']; ?>" width="60" id="pimg_<?php echo $row['id']; ?>"/></a>
                            <?php endif; ?>
                        </td>
                        <td align="left">
                            <p class="cart_name">
                                    <?php if($row['type'] == 1): ?>
                                    <a href="/tab/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                    <?php elseif($row['type'] == 2): ?>
                                    <a href="/zine/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                    <?php else: ?>
                                    <a href="/item/<?php echo $row['product_id']; ?>" target="_blank" id="pname_<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </a>
                                <?php endif; ?>
                            </p>
                        </td>
                        <td align="center"><!-- <span class="pbars pbars2">特价</span> --></td>
                        <td align="center">¥<?php echo $row['sell_price']; ?></td>

                        <td align="center"><p class="num_line"><b class="fl numopt num_down">-</b>
                                <input class="fl num_input" id="pnum_<?php echo $row['id']; ?>" type="text" value="<?php echo $row['quantity']; ?>" />
                                <b class="fl numopt num_up">+</b></p></td>
                        <td align="center"><span><b class="itemprice" id="pprice_<?php echo $row['id']; ?>">¥<?php echo $row['total_price']; ?></b></span></td>
                        <td align="center"><span class="del_opt">删除</span></td>
                    </tr>
                <?php endforeach; ?>

            <?php endif;?>

        </table>

        <?php if(!empty($list)): ?>
            <div class="cart_info">

            </div>
            <div class="ch_xiaoji">
                <ul class="fr cart_sum">
                    <li>
                        商品金额（不含运费）：<b id="cart_sumnum">¥<?php echo $total['product_amount']; ?></b></li>
                    <li class="sum_num">应付商品金额：<font id="sum_num">¥<?php echo $total['product_amount']; ?></font></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="cart_btn"> <a class="fr white btn btn-large btn-brown checkbtn" id="tocheck" href="/cart/checkout">立即结算</a>
                <div class="clear"></div>
            </div>
        <?php endif;?>

        <div class="clear"></div>
    </div>

</div>

<?php $this->beginContent('/public/publicpops'); ?> <?php $this->endContent(); ?>