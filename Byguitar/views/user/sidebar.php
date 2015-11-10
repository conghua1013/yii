<?php
    $menu_list = array(
        array(
            array('menu_name'=>'基本资料','key'=>array('index'),'url'=>'/user/index'),
            array('menu_name'=>'头像设置','key'=>array('setface','cutimg'),'url'=>'/user/setface'),
            array('menu_name'=>'资料修改','key'=>array('set'),'url'=>'/user/set'),
            array('menu_name'=>'更改密码','key'=>array('password'),'url'=>'/user/password'),
            array('menu_name'=>'我的消息','key'=>array('mailspull'),'url'=>'/user/mailspull'),
        ),
        array(
            array('menu_name'=>'地址管理','key'=>array('address'),'url'=>'/user/address'),
            array('menu_name'=>'我的订单','key'=>array('orderlist','orderSn'),'url'=>'/user/orderlist'),
            array('menu_name'=>'优惠券','key'=>array('coupon'),'url'=>'/user/coupon'),
            array('menu_name'=>'商品收藏','key'=>array('like'),'url'=>'/user/like'),
        ),
    );

?>

<ul class="fl setbar">
<?php if(!empty($menu_list)): ?>
    <?php $menu_num = 1; ?>
    <?php foreach($menu_list as $menu_row): ?>
    <?php if(empty($menu_row)){ continue; } ?>
        <?php foreach($menu_row as $menu):?>
            <?php if(in_array($action,$menu['key'])): ?>
                <li class="setbars setbars_on"><?php echo $menu['menu_name'];?></li>
            <?php else: ?>
                <li class="setbars"><a class="gray" href="<?php echo $menu['url'];?>"><?php echo $menu['menu_name'];?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if($menu_num < count($menu_list)): ?>
        <li class="setbar-line"></li>
        <?php endif; ?>
        <?php $menu_num++ ; ?>

    <?php endforeach; ?>
<?php endif; ?>
</ul>
