
<div class="tip"></div>

<div class="main">

    <div class="sortline clearfix">
        <p class="fl">
            <label>合作品牌</label>
        </p>
    </div>

    <!--品牌列表循环部分，考虑到前期品牌合作数不做分页一页显示完毕-->
    <?php if(!empty($list)): ?>
    <?php foreach($list as $row): ?>

        <div class="brandspin">
            <a class="fl brandslogo" href="/brand/<?php echo $row['id']; ?>" target="_blank"><img width="100" height="100" src="<?php echo $row['brand_logo']; ?>" ></a>
            <div class="fl brandsinfo">
                <h3><a href="/brand/<?php echo $row['id']; ?>" target="_blank"><?php echo $row['brand_name']; ?></a></h3>
                <p class="gray pdt10"><a href="/brand/<?php echo $row['id']; ?>" target="_blank"><strong>简介：</strong><?php echo mb_substr($row['describtion'],0,20,'utf-8'); ?></a></p>
            </div>
        </div>
    <?php endforeach; ?>
        <?php else: ?>
        没有找到符合条件的商品！
    <?php endif; ?>

    <div class="clear"></div>
    <!--页码-->
    <div class="page_box">
        <?php echo isset($pages['str']) ? $pages['str'] : ''; ?>
    </div>

</div>

<!--购买按钮弹出层-包含在了公共弹出层模板public下的regloginpopups模板里了！只要是商品也就判断调用-->
<?php $this->beginContent('/public/publicpops'); ?> <?php $this->endContent(); ?>