
<span class="cart_btn" size="4" pType="product" pid="30" num="1" buynow="0" >添加商品到购物车</span><br><br>

<span class="cart_btn" size="" pType="tab" pid="1" num="1" buynow="0" >添加谱子到购物车</span><br><br>
<span class="cart_btn" size="" pType="zine" pid="1" num="1" buynow="10" >添加杂志到购物车</span><br><br>

<script>
    $(document).ready(function(){
        $('.cart_btn').click(function(){
            var pid = $(this).attr('pid');
            var type = $(this).attr('pType');
            var size = $(this).attr('size');
            var num = $(this).attr('num');
            var buynow = $(this).attr('buynow');

            var data = "id="+pid+
                "&size="+size+
                "&buynow="+buynow+
                "&num="+num+
                '&type='+type;
            $.ajax({
                type: "POST",
                url: "/cart/addCart",
                dataType: "json",
                cache: false,
                data: data + "&ajax=1&m=" + Math.random(),
                success: function (re) {
                    if (re.status == 1 && re.buynow == '1') { //直接购买成功后 跳转到结账页面
                        //window.location.href = "/cart/checkout";
                    } else if (re.status == 1) {
                        //var sell_price = $('#sell_price').html();
                        //var price_amount = num * (sell_price.substring(1, sell_price.length - 1));
                        //$('#pop_product_href').attr('href', document.location);
                        //$('#pop_product_img').attr('src', $('#first_img').attr('src'));
                        //$('#pop_product_name').html($('#pInfo').html());
                        //$('#pop_product_num').html(num);
                        //$('#pop_product_price').html('￥' + price_amount);
                        //popdiv("#buy_pop", "570", "auto", 0.2);	//添加购物车后弹出层
                        //getMiniCart();//头部购物车加载
                    } else if (re.status == 2) {
                        alert('请登录')
                        //window.location.href= "/public/login";
                        //popdiv("#login_pop", "570", "auto", 0.2);
                    } else {
                        alert(re.msg);
                    }
                    //2 卖完;0 不足;-2 货品不可买;1购入OK
                }, error: function () {
                    return;
                }
            })

        })
    })

</script>