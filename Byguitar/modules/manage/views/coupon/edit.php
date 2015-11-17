<div class="pageContent">

    <form method="post" action="manage/coupon/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>优惠券编号：</label>
                <?php echo $info->coupon_sn; ?>
            </div>

            <div class="unit">
                <label>优惠券面值：</label>
                <input type="text" name="coupon_amount" class="required" value="<?php echo $info->coupon_amount; ?>" />
            </div>

            <div class="unit">
                <label>满足金额：</label>
                <input type="text" name="satisfied_amount" value="<?php echo $info->satisfied_amount; ?>" />
            </div>

            <div class="unit">
                <label>开始时间：</label>
                <input type="text" name="start_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $info->start_time ? date('Y-m-d H:i:s',$info->start_time) : ''; ?>" />
            </div>

            <div class="unit">
                <label>结束时间：</label>
                <input type="text" name="end_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $info->end_time ? date('Y-m-d H:i:s',$info->end_time) : ''; ?>" />
            </div>

            <input type="hidden"  name="id" value="<?php echo $info->id; ?>"><!--修改记录的id必须-->

        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
