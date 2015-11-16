<!-- 实时到账，不用通知支付宝的发货界面 -->
<div class="pageContent">

    <form method="post" action="/Manage/order/shippingAndNotifyAlipay" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>支付宝交易号：</label>
                <input type="text" name="trade_no" />
            </div>

            <div class="unit">
                <label>物流公司名称：</label>
                <input type="text" name="shipping_name" />
            </div>

            <div class="unit">
                <label>物流发货单号：</label>
                <input type="text" name="shipping_number"  />
            </div>

            <div class="unit">
                <label>物流运输类型：</label>
                <input type="text" name="shipping_type" value="EXPRESS" />
            </div>

            <input type="hidden"  name="id" value="<?php echo $oInfo['id']; ?>"><!--修改记录的id必须-->
        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
