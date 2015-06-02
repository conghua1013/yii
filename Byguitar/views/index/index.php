<div class="tip"></div>
<div class="main">

<!--左侧分类模块-->
<div class="fl indexcat">
    <h1>全部商品分类</h1>
    <ul class="catlist catlist_on" id="catlist">
    
        <volist name="cateTree" id="vo">
        <li class="catitem">
            <empty name="vo.url">
            <h3><a href="/shop/category/{$vo.id}" >{$vo.cat_name}</a></h3>
            <else/>
            <h3><a href="{$vo.url}" >{$vo.cat_name}</a></h3>
            </empty>
            <div class="subcatlist">
                <volist name="vo.child" id="row">
                    <empty name="row.url">
                    <p><a href="/shop/category/{$row.id}">{$row.cat_name}</a></p>
                    <else/>
                    <p><a href="{$row.url}">{$row.cat_name}</a></p>
                    </empty>
                </volist>
            </div>
        </li>
        </volist>

    </ul>
</div>

<!-- flash模块 -->
<div class="fr flashbox sflashbox">
  

  <ul id="fbox">
    <volist name="lunbo" id="vo" >
    <li class="switch_item"><a target="_blank" href="{$vo.link}" title="{$vo.title}">
    <img src="{$vo.img}" width="776" height="348"></a></li>
    </volist>
    <!-- <li class="switch_item"><a target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/sflash-2.jpg" width="776" height="348"></a></li>
    <li class="switch_item"><a target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/sflash-1.jpg" width="776" height="348"></a></li>
    <li class="switch_item"><a target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/sflash-2.jpg" width="776" height="348"></a></li> -->
  </ul>
  <ul id="fbar">
    <volist name="lunbo" id="vo">
    <li class="fbar">{$key}</li>
    </volist>
    <!-- <li class="fbar">2</li>
    <li class="fbar">3</li>
    <li class="fbar">4</li> -->
  </ul>

  <!--banner模块-->
  <div class="sbanner clearfix">
    <volist name="banner" id="vo" mod="2">
  	<a <eq name="mod" value="1">class="fr" <else/>class="fl" </eq> target="_blank" href="{$vo.link}" title="{$vo.title}">
    <img src="{$vo.img}" width="380" height="172"></a>
    </volist>
    <!-- <a class="fr" target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/sbanner-2.jpg" width="380" height="172"></a> -->
  </div>

</div>
<div class="clear"></div>


<volist name="module" id="vo">
<div class="shopzone  clearfix">
<h2>{$vo.title}</h2>
	<a class="fl" target="_blank" href="{$vo.link}" title="{$vo.title}">
    <img src="{$vo.img}" width="207" height="382"></a>

    <volist name="vo.list" id="row">
    <eq name="key" value="0">
    	<div class="fl pinbox bpinbox shadow">
            <div class="pinimg">
                <span class="discount">{$row.discount}折</span>
                <span class="pinlike"></span>
                <a href="/shop/item/{$row.id}" title="{$row.product_name}">
                    <img width="380" height="380" src="{$row.img.0.img_300}">
                </a>
            </div>
            <div class="pininfo">
                <h3><a href="/shop/item/{$row.id}" title="{$row.product_name}">{$row.product_name}</a></h3>
                <p class="pinprice"><b>¥{$row.sell_price} </b> | <del>¥{$row.market_price}</del></p>
            </div>
        </div>
    <else/>
        <div class="fl pinbox spinbox shadow">
            <div class="pinimg">
                <span class="discount">7.5折</span>
                <span class="pinlike"></span>
                <a href="/shop/item/{$row.id}"><img width="180" height="180" src="{$row.img.0.img_300}"></a>
            </div>
            <div class="pininfo">
                <h3><a href="/shop/item/{$row.id}">{$row.product_name}</a></h3>
                <p class="pinprice"><b>¥{$row.sell_price} </b> |  <del>¥{$row.market_price}</del></p>
            </div>
        </div>
    </eq>
    </volist>
    
    <!-- <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div> -->
</div>
</volist>


<!-- <div class="shopzone  clearfix">
<h2>热卖商品</h2>
	<a class="fl" target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/szone-2.jpg" width="207" height="382"></a>
    <div class="fl bzone">
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    </div>
	<div class="fl pinbox bpinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="380" height="380" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    
</div>


<div class="shopzone  clearfix">
<h2>品牌精选</h2>
	<a class="fl" target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/szone-3.jpg" width="207" height="382"></a>
    
    <div class="fl szone">
   
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    </div>
	<div class="fl pinbox bpinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="380" height="380" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    <div class="fl szone" >    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    </div>
    

</div>


<div class="shopzone  clearfix">
<h2>热卖商品</h2>
	<a class="fl" target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/szone-4.jpg" width="207" height="382"></a>
    <div class="fl bzone">
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    </div>
    	<div class="fl pinbox bpinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="380" height="380" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>

</div>


<div class="shopzone  clearfix">
<h2>特卖商品</h2>
	<a class="fl" target="_blank" href="" title=""><img src="__PUBLIC__/Images/shop/szone-5.jpg" width="207" height="382"></a>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-1.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-2.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
    
    <div class="fl pinbox spinbox shadow">
        <div class="pinimg">
            <span class="discount">7.5折</span>
            <span class="pinlike"></span>
            <a href=""><img width="180" height="180" src="__PUBLIC__/Images/shop/zoompic-3.jpg"></a>
        </div>
        <div class="pininfo">
            <h3><a href="">彼岸2014新款民谣吉他</a></h3>
            <p class="pinprice"><b>¥599 </b> |  <del>¥799</del></p>
        </div>
    </div>
</div> -->


  
</div>





