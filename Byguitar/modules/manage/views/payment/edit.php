<div class="pageContent">

    <form method="post" action="/manage/payment/edit" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>支付方式名称：</label>
                <input type="text" class="required" name="pay_name" value="<?php echo $info->pay_name; ?>" />
            </div>

            <div class="unit">
                <label>支付方式编号：</label>
                <input type="text" class="required" name="pay_code" value="<?php echo $info->pay_name; ?>" />
            </div>

            <div class="unit">
                <label>支付方式图片：</label>
                <input type="file" name="payment_logo" />
                <?php if($info->payment_logo):?>
                <image width="80" src="<?php echo $info->payment_logo;?>" alt="<?php echo $info->payment_logo;?>"/>
                <?php endif; ?>
            </div>

            <div class="unit">
                <label>密钥a：</label>
                <input type="text" name="keya" value="<?php echo $info->keya; ?>" />
            </div>

            <div class="unit">
                <label>密钥b：</label>
                <input type="text" name="keyb" value="<?php echo $info->keyb; ?>" />
            </div>

            <div class="unit">
                <label>是否开启：</label>
                <input type="radio" name="is_valid" value="0" <?php if($info->is_valid == 0){echo "checked";} ?> />否
                <input type="radio" name="is_valid" value="1" <?php if($info->is_valid == 1){echo "checked";} ?> />是
            </div>

            <div class="unit">
                <label>是否是支付平台：</label>
                <input type="radio" name="is_plat" value="0" <?php if($info->is_plat == 0){echo "checked";} ?> />否
                <input type="radio" name="is_plat" value="1" <?php if($info->is_plat == 1){echo "checked";} ?> />是
            </div>

            <div class="unit">
                <label>排序字段：</label>
                <input type="text" name="sort" value="<?php echo $info->sort; ?>" />
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
