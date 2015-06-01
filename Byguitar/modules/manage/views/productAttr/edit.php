<div class="pageContent">
    <form method="post" action="manage/product/ProductAttrEdit" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="57">
            <p>
                <label>上级菜单：</label>
                <select name="parent_id">
                    <option value="0" >顶级分类</option>
                    <?php if($select): ?>
                        <?php foreach($select as $row): ?>
                            <option value="<?php echo $row->id; ?>" <?php if($row->id == $info->parent_id){ echo 'selected';} ?> ><?php echo $row->attr_name; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </p>
            <div class="divider"></div>
            <p>
                <label>属性名称：</label>
                <input type="text" name="attr_name" size="30" value="<?php echo $info->attr_name; ?>"/>
            </p>
            <input type="hidden" name="id" value="<?php echo $info->id; ?>" />
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
