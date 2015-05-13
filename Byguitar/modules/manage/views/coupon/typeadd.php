<div class="pageContent">

    <form method="post" action="manage/coupon/typeadd" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>优惠券名称：</label>
                <input type="text" class="required" name="coupon_name">
            </div>

            <div class="unit">
                <label>优惠券类型：</label>
                <input type="radio" name="coupon_type" value="1" checked/>A类券
                <input type="radio" name="coupon_type" value="2" />B类券
                <span>A类券为系统生成的，一张之可以使用一次，B类券是自己输入的，可以无限制的使用</span>
            </div>

            <div class="unit">
                <label>优惠券编号：</label>
                <input type="text" name="coupon_sn" value="" />
            </div>

            <div class="unit">
                <label>优惠券面值：</label>
                <input type="text" name="coupon_amount" class="required"  />
            </div>

            <div class="unit">
                <label>满足金额：</label>
                <input type="text" name="satisfied_amount" />
            </div>

            <div class="unit">
                <label>开始时间：</label>
                <input type="text" name="start_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss"  />
            </div>

            <div class="unit">
                <label>结束时间：</label>
                <input type="text" name="end_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss"  />
            </div>

            <div class="unit">
                <label>备注描述：</label>
                <textarea name="detail"  rows="5" cols="57"></textarea>
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
