<div class="tip"></div>

<div class="main">
  <!--面包屑-->
  <div class="topnav">
    <a class="gray" href="/">彼岸商场</a> >
    <a class="gray" href="/category/<?php echo $cake['catone']['id']; ?>"><?php echo $cake['catone']['cat_name']; ?></a>  >
    <a class="gray" href="/category/<?php echo $cake['cattwo']['id']; ?>"><?php echo $cake['cattwo']['cat_name']; ?></a>
  </div>

  <!--商品购买区域信息-->
  <ul class="pinfo">
    <li class="pname">
      <h1 id="pInfo" pid="<?php echo $pInfo['id'];?>"><?php echo $pInfo['product_name'];?></h1>
      <p><?php echo $pInfo['subhead'];?></p>
      <p>
        <label>品牌</label>
        <?php echo $brandInfo['brand_name'];?>
      <!-- <a class="gray" href="/shop/brand/{$pInfo.brand_id}" target="_blank"><?php //echo $brandInfo['brand_name']; ?></a> -->
      </p>
    </li>
    <li class="price">
      <p>
        <label>原价</label>
        <span class="oprice">￥<?php echo $pInfo['market_price'];?></span></p>
      <p class="lbprice">
        <label>现价</label>
        <span class="sprice" id="sell_price">￥<?php echo $pInfo['sell_price'];?></span></p>
      <!-- <p>
        <label>评级</label>
        <span class="star s3"></span> ( <a class="gray" href="#pbarbox">共1条评价</a> )</p> -->
    </li>
    
    <!-- 同款不同色 mates_on-->
    <?php if(!empty($sameColors)): ?>
    <?php foreach($sameColors as $row): ?>
    <li class="mates">
      <label>同款</label>
      <volist name="sameColors" id="vo">
      <a href="/item/{$vo.id}"><img class="mateson" width="48" height="48" title="" src="{$vo.img.img_50}"></a>
      </volist>
    </li>
    <?php endforeach; ?>
    <?php endif;?>
    
    
    <!-- 商品的规格属性 -->
    <?php if(!empty($stock)): ?>
    <li class="style"> 
        <?php foreach($stock as $key => $row): ?>
            <?php if($key == 0): ?>  <!-- 默认选中第一个 -->
            <span class="guige guige_on" size="<?php echo $row['attr_id']; ?>" quantity="<?php echo $row['quantity']; ?>"><?php echo $attrList[$row['attr_id']]; ?></span>
            <?php else: ?>
            <span class="guige" size="<?php echo $row['attr_id']; ?>" quantity="<?php echo $row['quantity']; ?>"><?php echo $attrList[$row['attr_id']]; ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
      <span id="error-style" class="error-tip" style="display:none">请选择规格</span>
    </li>
    <?php else: ?> <!-- 没有库存写入隐藏的库存值 -->
    <li class="style" style="display:none;">
        <span class="guige guige_on" size="none" quantity="<?php echo $pInfo['quantity']; ?>">xx</span>
    </li>
    <?php endif;?>



    <li class="pnum"> 
      <!--<label>数量</label>--> 
      <span class="">
        <span class="pnumadd" id="mins">-</span>
        <input class="input" type="text" id="buynum" value="1">
        <span class="pnumadd" id="plus">+</span>
      </span>
      <span id="error-nums" class="fl error-tip" style="display:none"></span>
      <div class="clear"></div>
    </li>
    <li class="pbuy">
      <div class="fl btn btn-large btn-brown pbtn-buy">立即购买</div>
      <div class="fl btn btn-large btn-primary pbtn-shopping">加入购物车</div>
      <div class="pbtn pbtn-like <notempty name='is_like'> xinon pbtn-like_on</notempty> " title="点击标记喜欢这个商品"><span><?php echo $pInfo['like_num'];?></span></div>
      <div class="clear"></div>
    </li>
    <!-- <li class="pbuy">
      <p class="pbuy-empty"><span>抱歉，暂时卖光了。</span><br />
        选择到货通知，到货后您将收到免费短信提醒。</p>
        <div class="clear"></div>
    </li>  -->
    <!-- <li class="pben">
      <p style="padding-top:10px;">●　该商品参加 <a class="qing" href="#">满199元包邮</a> 活动</p>
      <p>●　全场满59全场满59元赠元赠 <a class="qing" href="#">满199元包邮</a> 数量有限赠完即止</p>
    </li> -->
    
    <?php if(!empty($pInfo['tags'])): ?>
    <li class="ptag">
      <label>标签</label>
      <?php foreach($pInfo['tags'] as $row): ?>
      <a href="#"><?php echo $row; ?></a>
      <?php endforeach; ?>
    </li>
    <?php endif;?>

  </ul>

  <!--商品4个轮播主图部分-->
  <div class="pic">
    <div id="pic_box">
        <?php if(!empty($pInfo['images'])): ?>
        <?php $imagaNum = 1; ?>
        <?php foreach($pInfo['images'] as $row): ?>
        <a class="cloud-zoom" href="<?php echo $row['images']['image_800']; ?>" rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4" <?php if($imagaNum ==1): ?>style="display:none;"<?php endif; ?> >
        <img width="600" height="600" src="<?php echo $row['images']['image_300']; ?>" class="switch_item" <?php if($imagaNum == 1): ?>id="first_img"<?php endif; ?> /></a>
        <?php $imagaNum++; ?>
        <?php endforeach; ?>
        <?php endif;?> 
    </div>
    <ul class="pic_index clearfix">
        <?php if(!empty($pInfo['images'])): ?>
        <?php $imagaNum = 1; ?>
        <?php foreach($pInfo['images'] as $row): ?>
        <li class="pic_li <?php if($imagaNum == 1): ?>pic_on<?php endif; ?>"><img width="80" height="80" title="" src="<?php echo $row['images']['image_100']; ?>"></li>
        <?php $imagaNum++; ?>
        <?php endforeach; ?>
        <?php endif;?>
    </ul>
  </div>
  <div class="clear"></div>

  <!--微博分享区域-->
  <div class="snsbox" style="margin-right:5px; padding-bottom:20px;">
    <p class="snsbtn fr"> <span class="fl">分享：</span> <a class="sina" href="javascript:void(0)" onclick="bg_share('sina')" rel="external nofollow" title="分享到新浪微博">新浪微博</a> <a class="qq" href="javascript:void(0)" onclick="bg_share('qq')" rel="external nofollow" title="分享到QQ聊天窗口">QQ聊天</a> <a class="qzone" href="javascript:void(0)" onclick="bg_share('qzone')" rel="external nofollow" title="分享到QQ空间">QQ空间</a> <a class="tencent" href="javascript:void(0)" onclick="bg_share('qblog')" rel="external nofollow" title="分享到腾讯微博">腾讯微博</a> <a class="douban" href="javascript:void(0)" onclick="bg_share('douban')" rel="external nofollow" title="分享到豆瓣">豆瓣</a> <a class="renren" href="javascript:void(0)" onclick="bg_share('renren')" rel="external nofollow" title="分享到人人网">人人网</a> </p>
    <div class="clear"></div>
    <!--商品分享出去时候的文案，需要程序生成url,title,content,img信息的变量-->
    <script language="javascript">
        var bgshare ={
          url:'<?php $this->webUrl; ?>/zine/49/',
          title:'彼岸吉他商品分享',
          content: '商品名称等文案！',
          img : '<?php $this->webUrl; ?>__PUBLIC__/Images/zine/bg7year-2.jpg'
        }
      </script> 
  </div>

  <!--商品详情介绍区域的3个选项卡bar-->
  <div class="pbarbox" id="pbarbox">
    <ul class="pbar clearfix">
      <li class="pbars pbars_on"><a href="#pstory">商品详情</a></li>
      <li class="pbars"><a href="#pcomments">买家评论</a></li>
      <li class="pbars"><a href="#pservices">服务承诺</a></li>
      <div class="btn btn-large btn-brown pbtn-buy">立即购买</div>
    </ul>
  </div>

  <!--商品详情区-货品详情图区-->
  <div class="pdetail pstory" id="pstory">
    <!--商品参数排练区-->
    <div class="pdetails">
      <dl class="clearfix">
        <dt><?php echo $pInfo['describtion']; ?></dt>
          <?php if(!empty($extendAttrList)): ?>
          <?php foreach($extendAttrList as $row): ?>
          <dd><?php echo $row['attr_name']."：".$row['attr_content']; ?></dd>
          <?php endforeach; ?>
          <?php endif;?>
        <dd>退换政策：查看详细规则»</dd>
      </dl>
    </div>


    <!--商品配视频介绍区，如果有的话-->
    <?php if(!empty($pInfo['vedio_url'])): ?>
    <div class="pvideo">
      <embed src="<?php echo $pInfo['vedio_url'];?>" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
    </div>
    <?php endif; ?>


    <!--商品详情长图区-->
    <?php if(!empty($pInfo['detail'])): ?>
    <div class="pimgs">
      <?php echo $pInfo['detail'];?>
    </div>
    <?php endif; ?>
  </div>

  <!--商品详情区-货品评价以及推荐产品区-->
  <div class="pdetail pcomments" id="pcomments">

    <!--商品评论-咨询区-->
    <dl class="fl zping" id="zping">
      <!--商品评论咨询区选项卡bar-->
      <!-- <dt class="zpboxtop">
        <ul class="askbar clearfix">
          <li class="askbar_on">买家评论</li>
          <li>商品咨询</li>
        </ul>
      </dt> -->
      <!--商品评论列表区-->
      <include file="*item-comments" />
      <!--商品咨询列表-->
      <include file="*item-consults" />

    </dl>
    <!--商品推荐区-->
    <include file="*item-recommend" />
    <div class="clear"></div>
  </div>

  <!--商品相关服务介绍区域-->
  <div class="pdetail pservices" id="pservices">
    <!-- <h3>库房物流</h3>
    <img src="__PUBLIC__/Images/shop/service1.jpg"><br />
    <br />
    <h3>商品包装</h3>
    <img src="__PUBLIC__/Images/shop/service2.jpg"><br />
    <br /> -->
    <h3>服务承诺</h3>
    <img src="__PUBLIC__/Images/shop/services.jpg"><br />
    <br />
  </div>

</div>

<!--购买按钮弹出层-包含在了公共弹出层模板public下的regloginpopups模板里了！只要是商品也就判断调用-->
<?php $this->beginContent('/public/publicpops'); ?> <?php $this->endContent(); ?>
