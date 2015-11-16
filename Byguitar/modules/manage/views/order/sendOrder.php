<!-- 实时到账，不用通知支付宝的发货界面 -->
<div class="pageContent">

    <form method="post" action="/manage/order/sendOrder" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>订单号：</label>
                <?php echo $oInfo['order_sn']; ?>
            </div>

            <div class="unit">
                <label>快递公司：</label>
                <select name="shipping_id">
                    <option value="0" selected >请选择</option>
                    <?php if($shippingList): ?>
                    <?php foreach($shippingList as $row): ?>
                        <option value="<?php echo $row['id']; ?>" ><?php echo $row['shipping_name']; ?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <input type="hidden" name="order_id" value="<?php echo $oInfo['id']; ?>" />
            </div>

            <div class="unit">
                <label>快递单号：</label>
                <input type="text" class="required"  name="shipping_sn" />
            </div>

            <div class="unit">
                <label>实际运费：</label>
                <input type="text" name="shipping_fee" value="" />
            </div>


            <div class="unit">
                <label>订单商品重量：</label>
                <input type="text" name="weight" value="" /> 克
            </div>

            <div class="unit">
                <label>发货备注：</label>
                <textarea name="remark"  rows="5" cols="57"></textarea>
            </div>

            <input type="hidden" name="id" value="<?php echo $oInfo['id']; ?>" />
        </div>

        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">Submit</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
            </ul>
        </div>

    </form>

</div>
