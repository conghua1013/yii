<div class="pageContent">

    <form method="post" action="manage/shipping/add" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>快递名称：</label>
                <input type="text" class="required" name="shipping_name" />
            </div>

            <div class="unit">
                <label>快递费用：</label>
                <input type="text" class="required" name="shipping_fee" />
            </div>

            <div class="unit">
                <label>快递编码：</label>
                <input type="text" class="required" name="shipping_code" />
            </div>

            <div class="unit">
                <label>是否开启：</label>
                <input type="radio" name="is_show" value="0" checked />否
                <input type="radio" name="is_show" value="1" />是
            </div>

            <div class="unit">
                <label>快递详情：</label>
                <input type="text" name="detail" />
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
