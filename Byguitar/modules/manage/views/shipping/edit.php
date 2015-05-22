<div class="pageContent">

    <form method="post" action="manage/shipping/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>快递名称：</label>
                <input type="text" class="required" name="shipping_name" value="<?php echo $info->shipping_name;?>"/>
            </div>

            <div class="unit">
                <label>快递费用：</label>
                <input type="text" class="required" name="shipping_fee" value="<?php echo $info->shipping_fee;?>"/>
            </div>

            <div class="unit">
                <label>快递编码：</label>
                <input type="text" class="required" name="shipping_code" value="<?php echo $info->shipping_code;?>"/>
            </div>

            <div class="unit">
                <label>是否开启：</label>
                <input type="radio" name="is_show" value="0" <?php if($info->is_show ==0){ echo 'checked'; }?>/>否
                <input type="radio" name="is_show" value="1" <?php if($info->is_show ==1){ echo 'checked'; }?>/>是
            </div>

            <div class="unit">
                <label>快递描述：</label>
                <input type="text" name="detail" value="<?php echo $info->detail;?>"/>
            </div>

            <input type="hidden" name="id" value="<?php echo $info->id;?>" />
        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
