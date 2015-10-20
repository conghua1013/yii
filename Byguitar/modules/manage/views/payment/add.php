<div class="pageContent">

    <form method="post" action="/manage/payment/add" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>支付方式名称：</label>
                <input type="text" class="required" name="pay_name" />
            </div>

            <div class="unit">
                <label>支付方式编号：</label>
                <input type="text" class="required" name="pay_code" />
            </div>

            <div class="unit">
                <label>支付方式图片：</label>
                <input type="file" name="payment_logo" />
            </div>

            <div class="unit">
                <label>密钥a：</label>
                <input type="text" name="keya" value="" />
            </div>

            <div class="unit">
                <label>密钥b：</label>
                <input type="text" name="keyb" />
            </div>

            <div class="unit">
                <label>是否开启：</label>
                <input type="radio" name="is_valid" value="0" checked />否
                <input type="radio" name="is_valid" value="1" />是
            </div>

            <div class="unit">
                <label>是否是支付平台：</label>
                <input type="radio" name="is_plat" value="0" checked />否
                <input type="radio" name="is_plat" value="1" />是
            </div>

            <div class="unit">
                <label>排序字段：</label>
                <input type="text" name="sort" value="0"/>
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
