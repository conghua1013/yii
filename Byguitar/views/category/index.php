
<div class="tip"></div>
<div class="main">
    <!--商品筛选区topbar-->
    <div class="filtertop clearfix">
        <!--所有分类列表-->
        <div class="fl allcat">
            <h2>全部分类</h2>
            <ul class="catlist" id="catlist"> 
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
        <!--所选分类-->
        <?php if($cakeInfo): ?>
        <div class="fl subcat">
            &gt;<a class="brown" href="/shop/category/{$cakeInfo.one.id}">{$cakeInfo.one.cat_name}</a> <notempty name="cakeInfo.two.cat_name">&gt; {$cakeInfo.two.cat_name}</notempty></div>
        <?php endif; ?>
        <!--筛选后的总数-->
        <div class="fr catnums">共<?php echo$count; ?>个商品</div>
    </div>

    <!--筛选区域-->
    <div class="filterbox">
        <dl class="filter clearfix">
            <dt>所有品牌</dt>
            <dd class="clearfix">
                <a <?php if(empty($filter['brand'])):?> class="filter_on" <?php endif; ?> href="/shop/category/<?php echo $filter['id'].'-0-'.$filter['price'].'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-'.$filter['sort']; ?>">全部</a>
                <?php if(!empty($options['brand'])): ?>
                <?php foreach($options['brand'] as $row): ?>
                <a <?php if($filter['brand'] == $row['id']):?> class="filter_on" <?php endif; ?> href="/shop/category/<?php echo $filter['id'].'-'.$row['id'].'-'.$filter['price'].'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-'.$filter['sort']; ?>"><?php echo $row['brand_name']; ?></a>
                <?php endforeach; ?>
                <?php endif; ?>
            </dd>
        </dl>
        <dl class="filter clearfix">
            <dt>价格区间</dt>
            <dd class="clearfix">
                <a <?php if(empty($filter['price'])):?> class="filter_on" <?php endif; ?> href="/shop/category/<?php echo $filter['id'].'-'.$filter['brand'].'-0-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-'.$filter['sort']; ?>">全部</a>
                <?php if(!empty($options['price'])): ?>
                <?php foreach($options['price'] as $key => $row): ?>
                <a <?php if($filter['price'] == $key):?> class="filter_on" <?php endif; ?> href="/shop/category/<?php echo $filter['id'].'-'.$filter['brand'].'-'.$key.'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-'.$filter['sort']; ?>"><?php echo $row; ?></a>
                <?php endforeach; ?>
                <?php endif; ?>
            </dd>
        </dl>
    </div>

    <!--排序区域-->
    <div class="sortline clearfix">
        <p class="fl">
        <label>排序</label>
        <a class="sortby <?php if($filter['sort']==1){ echo 'sortby_on'; } ?>" href="/shop/category/<?php echo $filter['id'].'-'.$filter['brand'].'-'.$filter['price'].'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-1'; ?>">热销</a>
        <a class="sortby <?php if($filter['sort']==2){ echo 'sortby_on'; } ?>" href="/shop/category/<?php echo $filter['id'].'-'.$filter['brand'].'-'.$filter['price'].'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-2'; ?>">最新</a>
        <a class="sortby <?php if($filter['sort']==3){ echo 'sortby_on'; } ?>" href="/shop/category/<?php echo $filter['id'].'-'.$filter['brand'].'-'.$filter['price'].'-'.$filter['size'].'-'.$filter['origin'].'-'.$filter['color'].'-3'; ?>">价格</a>
        </p>
        <div class="fr page_box"><?php echo $pageshort['str']; ?></div>
        <p class="fr">
        <span>共 <b><?php echo $count; ?></b> 件商品 |</span>    
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
                        <span class="discount">{$vo.discount}折</span>
                        <?php endif; ?> 
                        
                        <?php if($row['is_like']): ?>
                            <span class="pinlike pinlike_on xinon" title="点击标记喜欢这个商品" pid="<?php echo $row['id']; ?>"></span>
                        <?php else: ?>
                            <span class="pinlike" title="点击标记喜欢这个商品" pid="<?php echo $row['id']; ?>"></span>
                        <?php endif; ?>

                        <a href="/shop/item/<?php echo $row['id']; ?>"><img width="320" height="320" src="{$vo.img.0.img_300}" alt="<?php echo $row['product_name']; ?>"></a>
                    </div>
                    <div class="pininfo">
                        <h3><a href="/shop/item/<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a></h3>
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
    <!--页码-->
    <div class="page_box">
        <?php echo isset($pages['str']) ? $pages['str'] : ''; ?>
    </div>
</div>

<?php if(isset(Yii::app()->session['user_id']) && Yii::app()->session['user_id']): ?>
    <include file="Home:Public:regloginpopups" /> 
<?php endif; ?>  