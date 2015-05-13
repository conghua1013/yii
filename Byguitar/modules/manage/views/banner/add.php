<div class="pageContent">
    <form method="post" action="manage/banner/add" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="57">
            <p>
                <label>banner标题：</label>
                <input type="text" class="required" name="title" size="30" />
            </p>
            <div class="divider"></div>
            <p>
                <label>banner显示位置：</label>
                <select name="station">
                    <?php if($stations): ?>
                        <?php foreach($stations as $key => $row): ?>
                            <option value="<?php echo $key; ?>"> <?php echo $row; ?> </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </p>
            <div class="divider"></div>
            <p>
                <label>广告链接：</label>
                <input type="text" name="link" size="30" />
            </p>
            <div class="divider"></div>
            <div class="unit">
                <label>广告图片：</label>
                <input type="file" name="banner_image" />
            </div>
            <div class="divider"></div>
            <p>
                <label>开始时间：</label>
                <input type="text" name="start_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss"  />
            </p>
            <div class="divider"></div>
            <p>
                <label>结束时间：</label>
                <input type="text" name="end_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss"  />
            </p>
            <div class="divider"></div>
            <p>
                <label>状态：</label>
                <input type="radio" name="is_show" value="1" checked />显示
                <input type="radio" name="is_show" value="0" />不显示
            </p>
            <div class="divider"></div>
            <p>
                <label>排序：</label>
                <input type="text" name="sort" size="30" value="0"/>
            </p>
            <div class="divider"></div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
