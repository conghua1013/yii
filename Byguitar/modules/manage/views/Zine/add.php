<div class="pageContent">

    <form method="post" action="/manage/zine/add" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>杂志名称：</label>
                <input type="text" class="required" name="name" />
            </div>

            <div class="unit">
                <label>杂志类别：</label>
                <input type="text" class="required" name="class" />
            </div>

            <div class="unit">
                <label>主编：</label>
                <input type="text" name="editor" />
            </div>

            <div class="unit">
                <label>美编：</label>
                <input type="text" name="veditor" />
            </div>

            <div class="unit">
                <label>排版：</label>
                <input type="text" name="peditor" />
            </div>

            <div class="unit">
                <label>编委：</label>
                <input type="text" name="team" />
            </div>

            <div class="unit">
                <label>封面小图：</label>
                <input type="text" name="scover" />
            </div>

            <div class="unit">
                <label>封面中图：</label>
                <input type="text" name="mcover" />
            </div>

            <div class="unit">
                <label>封面大图：</label>
                <input type="text" name="bcover" />
            </div>

            <div class="unit">
                <label>文字部分：</label>
                <input type="text" name="content" />
            </div>

            <div class="unit">
                <label>弹唱曲目：</label>
                <input type="text" name="poptab" />
            </div>

            <div class="unit">
                <label>独奏曲目：</label>
                <input type="text" name="solotab" />
            </div>

            <div class="unit">
                <label>下载地址1：</label>
                <input type="text" name="link1" />
            </div>

            <div class="unit">
                <label>下载地址2：</label>
                <input type="text" name="link2" />
            </div>

            <div class="unit">
                <label>下载地址3：</label>
                <input type="text" name="link3" />
            </div>

            <div class="unit">
                <label>下载地址4：</label>
                <input type="text" name="link4" />
            </div>

            <div class="unit">
                <label>下载次数：</label>
                <input type="text" name="downs" />
            </div>

            <div class="unit">
                <label>浏览次数：</label>
                <input type="text" name="views" />
            </div>

            <div class="unit">
                <label>是否已经可在线阅读：</label>
                <input type="text" name="canread" />
            </div>

            <div class="unit">
                <label>谱子的市场价：</label>
                <input type="text" name="market_price" />
            </div>

            <div class="unit">
                <label>谱子的成本价：</label>
                <input type="text" name="cost_price" />
            </div>

            <div class="unit">
                <label>谱子的售价：</label>
                <input type="text" name="sell_price" />
            </div>

            <div class="unit">
                <label>谱子的库存：</label>
                <input type="text" name="quantity" />
            </div>

            <div class="unit">
                <label>谱子的电子版售价：</label>
                <input type="text" name="virtual_price" />
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
