<div class="pageContent">

    <form method="post" action="/manage/tab/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">

        <div class="pageFormContent" layoutH="58">

            <div class="unit">
                <label>谱子名称：</label>
                <input type="text" class="required" name="tabname" value="<?php echo $info->tabname;?>"/>
            </div>

            <div class="unit">
                <label>谱子类别：</label>
                <input type="text" class="required" name="class" value="<?php echo $info->class;?>"/>
            </div>

            <div class="unit">
                <label>谱子格式：</label>
                <input type="radio" name="type" value="0" <?php if($info->type == 0):?>checked<?php endif;?> />图片格式
                <input type="radio" name="type" value="1" <?php if($info->type == 1):?>checked<?php endif;?> />GTP格式
                <input type="radio" name="type" value="2" <?php if($info->type == 2):?>checked<?php endif;?> />TXT格式
            </div>

            <div class="unit">
                <label>谱子文件：</label>
                <input type="text" name="tabfile" value="<?php echo $info->tabfile;?>" />
            </div>

            <div class="unit">
                <label>歌曲名称：</label>
                <input type="text" name="songname" value="<?php echo $info->songname;?>" />
            </div>

            <div class="unit">
                <label>编配者：</label>
                <input type="text" name="author" value="<?php echo $info->author;?>" />
            </div>

            <div class="unit">
                <label>歌手名称：</label>
                <input type="text" name="singer" value="<?php echo $info->singer;?>" />
            </div>

            <div class="unit">
                <label>专辑名称：</label>
                <input type="text" name="album" value="<?php echo $info->album;?>" />
            </div>

            <div class="unit">
                <label>是否精华谱：</label>
                <input type="text" name="isbest" value="<?php echo $info->isbest;?>" />
            </div>

            <div class="unit">
                <label>拍子：</label>
                <input type="text" name="paizi" value="<?php echo $info->paizi;?>" />
            </div>

            <div class="unit">
                <label>拍速：</label>
                <input type="text" name="paisu" value="<?php echo $info->paisu;?>" />
            </div>

            <div class="unit">
                <label>调式：</label>
                <input type="text" name="diaoshi" value="<?php echo $info->diaoshi;?>" />
            </div>

            <div class="unit">
                <label>变调夹：</label>
                <input type="text" name="biandiaojia" value="<?php echo $info->biandiaojia;?>" />
            </div>

            <div class="unit">
                <label>单双吉他：</label>
                <input type="text" name="is_double" value="<?php echo $info->is_double;?>" />
            </div>

            <div class="unit">
                <label>视频地址：</label>
                <input type="text" name="video_url" value="<?php echo $info->video_url;?>" />
            </div>

            <div class="unit">
                <label>音频地址：</label>
                <input type="text" name="audio_url" value="<?php echo $info->audio_url;?>" />
            </div>

            <div class="unit">
                <label>表演及编配提示：</label>
                <input type="text" name="play_notice" value="<?php echo $info->play_notice;?>" />
            </div>

            <div class="unit">
                <label>难度：</label>
                <input type="text" name="nandu" value="<?php echo $info->nandu;?>" />
            </div>

            <div class="unit">
                <label>谱子状态：</label>
                <input type="text" name="ispass" value="<?php echo $info->ispass;?>" />
            </div>

            <div class="unit">
                <label>用于杂志的谱子：</label>
                <input type="text" name="forzine" value="<?php //echo $info->forzine;?>" />
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
