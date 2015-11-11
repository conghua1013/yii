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
                    <div class="pinlist likelist">
                        <div class="pzone clearfix">

                            <?php if(!empty($list)): ?>
                                <?php foreach($list as $row): ?>
                                    <div class="fl pinbox spinbox shadow" pid="<?php echo $row['product_id']; ?>">
                                        <div class="pinimg">
                                            <?php if($row['discount'] > 0): ?>
                                                <span class="discount"><?php echo $row['discount']; ?>折</span>
                                            <?php endif; ?>

                                            <span class="pinlike pinlike_on xinon del_like"></span>
                                            <a href="/item/<?php echo $row['product_id']; ?>">
                                                <img width="180" height="180" src="{$vo.pinfo.img.0.img_300}" /></a>
                                        </div>
                                        <div class="pininfo">
                                            <h3><a href="/shop/item/<?php echo $row['product_id']; ?>"><?php echo isset($productList[$row['product_id']]) ? $row['product_name'] : ''; ?></a></h3>
                                            <p class="pinprice"><b>¥<?php echo isset($productList[$row['product_id']]) ? $productList[$row['product_id']]['sell_price'] : ''; ?></b> |
                                                <del>¥<?php echo isset($productList[$row['product_id']]) ? $productList[$row['product_id']]['market_price'] : ''; ?></del></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                暂时没有收藏
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="page_box"> <?php echo isset($pages) ? $pages['str'] : ''; ?> </div>
                </div>
            </div>
            <div class="clear"></div>
        </dd>
    </dl>
</div>