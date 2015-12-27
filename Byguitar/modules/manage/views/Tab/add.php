<div class="pageContent">

    <form method="post" action="/manage/tab/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>地区名称：</label>
                <input type="text" class="required" name="region_name" value="<?php echo $info->region_name;?>"/>
            </div>

            <div class="unit">
                <label>地区编号：</label>
                <input type="text" class="required" name="area_code" value="<?php echo $info->area_code;?>"/>
            </div>

            <div class="unit">
                <label>父级编号：</label>
                <input type="text" class="required" name="parent_id" value="<?php echo $info->parent_id;?>"/>
            </div>

            <div class="unit">
                <label>是否开启：</label>
                <input type="radio" name="is_show" value="0" <?php if($info->is_show ==0){ echo 'checked'; }?> />否
                <input type="radio" name="is_show" value="1" <?php if($info->is_show ==1){ echo 'checked'; }?> />是
            </div>

            <div class="unit">
                <label>排序字段：</label>
                <input type="text" name="sort" value="0"/>
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
