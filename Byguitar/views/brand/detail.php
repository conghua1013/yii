
<div class="tip"></div>

<div class="main">

    <!--品牌资料部分-->
    <div class="brandpin">
        <a class="fl brandlogo"><img width="100" height="100" src="<?php echo $brandInfo['brand_logo']; ?>" ></a>
        <div class="fl brandinfo">
            <h3><?php echo $brandInfo['brand_name']; ?></h3>
            <p class="gray pdt10"><strong>简介：</strong><?php echo $brandInfo['describtion']; ?>......</p>
        </div>
    </div>
    <div class="clear"></div>

    <!--品牌商品列表title，包含显示品牌下商品数量-->
    <div class="sortline clearfix">
        <p class="fl">
            <label>品牌商品</label>
        </p>
        <p class="fr">
            <span>共 <b><?php echo $count; ?></b> 件商品 </span>
        </p>
    </div>

    <!--商品列表区-->
    <div class="pinlist">
        <!--商品列表第二层box-->
        <div class="pzone clearfix">
            <!--单个商品块区-->
            <!--每个单品位在制作时候包含下面这个pin公共模板循环即可！-->
            <?php if(!empty($list)): ?>
            <?php foreach($list as $row): ?>
                    <div class="fl pinbox shadow">
                        <div class="pinimg">

                            <?php if($row['discount'] > 0): ?>
                                <span class="discount"><?php echo $row['discount']; ?>折</span>
                            <?php endif; ?>

                            <?php if(isset($row['is_like']) && $row['is_like'] == 1): ?>
                                <span class="pinlike pinlike_on xinon" title="点击标记喜欢这个商品" pid="<?php echo $row['id']; ?>"></span>
                            <?php else: ?>
                                <span class="pinlike" title="点击标记喜欢这个商品" pid="<?php echo $row['id']; ?>"></span>
                            <?php endif; ?>

                            <a href="/item/<?php echo $row['id']; ?>"><img width="320" height="320" src="<?php echo  $row['images'] ? $row['images']['image_300'] : ''; ?>" alt="<?php echo $row['product_name']; ?>"></a>
                        </div>
                        <div class="pininfo">
                            <h3><a href="/item/<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a></h3>
                            <p class="fl pinprice">
                                <b>¥<?php echo $row['sell_price']; ?> </b> | <del><?php echo $row['market_price']; ?></del></p>
                            <p class="fr pinnums" id="like_num_<?php echo $row['id']; ?>">
                                <?php echo $row['like_num']; ?>
                            </p>
                        </div>
                    </div>
            <?php endforeach; ?>
            <?php else: ?>
                没有找到符合条件的商品！
            <?php endif; ?>

        </div>
    </div>
    <div class="clear"></div>
    <!--页码-->
    <div class="page_box">
        <?php echo isset($pages['str']) ? $pages['str'] : ''; ?>
    </div>

</div>

<!--购买按钮弹出层-包含在了公共弹出层模板public下的regloginpopups模板里了！只要是商品也就判断调用-->
<?php $this->beginContent('/public/publicpops'); ?> <?php $this->endContent(); ?>