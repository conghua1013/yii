<div class="pageContent">

    <form method="post" action="manage/shopConfig/add" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>配置项名称：</label>
                <input type="text" class="required" name="attribute_name" />
            </div>

            <div class="unit">
                <label>配置属性名称：</label>
                <input type="text" class="required" name="attribute" />
            </div>

            <div class="unit">
                <label>配置值：</label>
                <input type="text" class="required" name="value" />
            </div>
        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
