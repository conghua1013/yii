<div class="pageContent">

    <form method="post" action="/manage/coupon/makeCoupon" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>优惠券名称：</label>
                <?php echo $info->coupon_name; ?>
            </div>

            <div class="unit">
                <label>优惠券类型：</label>
                <?php if($info->coupon_type == 1){ echo 'A类券'; }else{ echo 'B类券'; } ?>
                <span>A类券为系统生成的，一张之可以使用一次，B类券是自己输入的，可以无限制的使用</span>
            </div>

            <div class="unit">
                <label>优惠券面值：</label>
                <?php echo $info->coupon_amount; ?>
            </div>

            <div class="unit">
                <label>满足金额：</label>
                <?php echo $info->satisfied_amount; ?>
            </div>

            <div class="unit">
                <label>开始时间：</label>
                <?php echo $info->start_time >0 ? date('Y-m-d H:i:s',$info->start_time) : ''; ?>
            </div>

            <div class="unit">
                <label>结束时间：</label>
                <?php echo $info->end_time>0 ? date('Y-m-d H:i:s',$info->end_time) : ''; ?>
            </div>

            <div class="unit">
                <label>备注描述：</label>
                <?php echo $info->detail; ?>
            </div>

            <div class="unit">
                <label>发放数量：</label>
                <input type="text" name="send_num"  />
            </div>

            <input type="hidden" name="id" value="<?php echo $info->id; ?>" />
        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
