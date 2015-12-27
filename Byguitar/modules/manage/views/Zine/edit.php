<div class="pageContent">

    <form method="post" action="/manage/zine/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>杂志名称：</label>
                <input type="text" class="required" name="name" value="<?php echo $info->name;?>"/>
            </div>

            <div class="unit">
                <label>杂志类别：</label>
                <input type="text" class="required" name="class" value="<?php echo $info->class;?>"/>
            </div>

            <div class="unit">
                <label>主编：</label>
                <input type="text" name="editor" value="<?php echo $info->editor;?>" />
            </div>

            <div class="unit">
                <label>美编：</label>
                <input type="text" name="veditor" value="<?php echo $info->veditor;?>" />
            </div>

            <div class="unit">
                <label>排版：</label>
                <input type="text" name="peditor" value="<?php echo $info->peditor;?>" />
            </div>

            <div class="unit">
                <label>编委：</label>
                <input type="text" name="team" value="<?php echo $info->team;?>" />
            </div>

            <div class="unit">
                <label>封面小图：</label>
                <input type="text" name="scover" value="<?php echo $info->scover;?>" />
            </div>

            <div class="unit">
                <label>封面中图：</label>
                <input type="text" name="mcover" value="<?php echo $info->mcover;?>" />
            </div>

            <div class="unit">
                <label>封面大图：</label>
                <input type="text" name="bcover" value="<?php echo $info->bcover;?>" />
            </div>

            <div class="unit">
                <label>文字部分：</label>
                <input type="text" name="content" value="<?php echo $info->content;?>" />
            </div>

            <div class="unit">
                <label>弹唱曲目：</label>
                <input type="text" name="poptab" value="<?php echo $info->poptab;?>" />
            </div>

            <div class="unit">
                <label>独奏曲目：</label>
                <input type="text" name="solotab" value="<?php echo $info->solotab;?>" />
            </div>

            <div class="unit">
                <label>下载地址1：</label>
                <input type="text" name="link1" value="<?php echo $info->link1;?>" />
            </div>

            <div class="unit">
                <label>下载地址2：</label>
                <input type="text" name="link2" value="<?php echo $info->link2;?>" />
            </div>

            <div class="unit">
                <label>下载地址3：</label>
                <input type="text" name="link3" value="<?php echo $info->link3;?>" />
            </div>

            <div class="unit">
                <label>下载地址4：</label>
                <input type="text" name="link4" value="<?php echo $info->link4;?>" />
            </div>

            <div class="unit">
                <label>下载次数：</label>
                <input type="text" name="downs" value="<?php echo $info->downs;?>" />
            </div>

            <div class="unit">
                <label>浏览次数：</label>
                <input type="text" name="views" value="<?php echo $info->views;?>" />
            </div>

            <div class="unit">
                <label>是否已经可在线阅读：</label>
                <input type="text" name="canread" value="<?php //echo $info->canread;?>" />
            </div>

            <div class="unit">
                <label>谱子的市场价：</label>
                <input type="text" name="market_price" value="<?php echo $info->market_price;?>" />
            </div>

            <div class="unit">
                <label>谱子的成本价：</label>
                <input type="text" name="cost_price" value="<?php echo $info->cost_price;?>" />
            </div>

            <div class="unit">
                <label>谱子的售价：</label>
                <input type="text" name="sell_price" value="<?php echo $info->sell_price;?>" />
            </div>

            <div class="unit">
                <label>谱子的库存：</label>
                <input type="text" name="quantity" value="<?php echo $info->quantity;?>" />
            </div>

            <div class="unit">
                <label>谱子的电子版售价：</label>
                <input type="text" name="virtual_price" value="<?php echo $info->virtual_price;?>" />
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
