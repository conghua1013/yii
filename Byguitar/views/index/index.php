<div class="tip"></div>
<div class="main">

<!--左侧分类模块-->
<div class="fl indexcat">
    <h1>全部商品分类</h1>
    <ul class="catlist catlist_on" id="catlist">
        <?php if($this->params['cateList']): ?>
        <?php foreach($this->params['cateList'] as $row): ?>
        <volist name="cateTree" id="vo">
        <li class="catitem">
            <h3><a href="<?php if($row['url']){ echo $row['url']; }else{ echo '/shop/category/'.$row['id'] ;} ?>" ><?php echo $row['cat_name']; ?></a></h3>
            <div class="subcatlist">
                <?php if($row['child']): ?>
                <?php foreach($row['child'] as $child): ?>
                    <p><a href="<?php if($child['url']){ echo $child['url']; }else{ echo '/shop/category/'.$child['id'] ;} ?>"><?php echo $child['cat_name']; ?></a></p>  
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<!-- flash模块 -->
<div class="fr flashbox sflashbox">
  <ul id="fbox">
    <?php if($lunbo): ?>
    <?php foreach($lunbo as $row): ?>
    <li class="switch_item"><a target="_blank" href="<?php echo $row['link'];?>" title="<?php echo $row['title'];?>">
    <img src="<?php echo $row['img'];?>" width="776" height="348"></a></li>
    <?php endforeach; ?>
    <?php endif; ?>
  </ul>
  <ul id="fbar">
    <?php if($lunbo): ?>
    <?php foreach($lunbo as $key => $row): ?>
    <li class="fbar"><?php echo $key;?></li>
    <?php endforeach; ?>
    <?php endif; ?>
  </ul>

  <!--banner模块-->
  <div class="sbanner clearfix">
    <?php if($lunbo): ?>
    <?php $bannerNum = 1; ?>
    <?php foreach($banner as $key => $row): ?>
  	<a <?php if($bannerNum == 1): ?>class="fr" <?php else: ?> class="fl" <?php endif;?> target="_blank" href="<?php echo $row['link'];?>" title="<?php echo $row['title'];?>">
    <img src="<?php echo $row['img'];?>" width="380" height="172"></a>
    <?php $bannerNum++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>
<div class="clear"></div>


<?php if($module): ?>
<?php foreach($module as $row): ?>
<div class="shopzone  clearfix">
<h2><?php echo $row['title']; ?></h2>
	<a class="fl" target="_blank" href="<?php echo $row['link']; ?>" title="<?php echo $row['title']; ?>">
    <img src="<?php echo $row['img']; ?>" width="207" height="382"></a>
    <?php if($row['list']): ?>
    <?php $productNum = 1; ?>
    <?php foreach($row['list'] as $key => $pInfo): ?>
    <?php if($productNum == 1): ?>
    	<div class="fl pinbox bpinbox shadow">
            <div class="pinimg">
                <span class="discount"><?php echo $pInfo['discount']; ?>折</span>
                <span class="pinlike"></span>
                <a href="/shop/item/<?php echo $pInfo['id']; ?>" title="<?php echo $pInfo['product_name']; ?>">
                    <img width="380" height="380" src="<?php echo $pInfo['images']['image_300']; ?>">
                </a>
            </div>
            <div class="pininfo">
                <h3><a href="/shop/item/<?php echo $pInfo['id']; ?>" title="<?php echo $pInfo['product_name']; ?>"><?php echo $pInfo['product_name']; ?></a></h3>
                <p class="pinprice"><b>¥<?php echo $pInfo['sell_price']; ?> </b> | <del>¥<?php echo $pInfo['market_price']; ?></del></p>
            </div>
        </div>
    <?php else: ?>
        <div class="fl pinbox spinbox shadow">
            <div class="pinimg">
                <span class="discount"><?php echo $pInfo['discount']; ?>折</span>
                <span class="pinlike"></span>
                <a href="/shop/item/<?php echo $pInfo['id']; ?>"><img width="180" height="180" src="<?php echo $pInfo['images']['image_300']; ?>"></a>
            </div>
            <div class="pininfo">
                <h3><a href="/shop/item/<?php echo $pInfo['id']; ?>"><?php echo $pInfo['product_name']; ?></a></h3>
                <p class="pinprice"><b>¥<?php echo $pInfo['sell_price']; ?> </b> |  <del>¥<?php echo $pInfo['market_price']; ?></del></p>
            </div>
        </div>
    <?php endif; ?>
    <?php $productNum++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    
</div>
<?php endforeach; ?>
<?php endif; ?>

</div>





