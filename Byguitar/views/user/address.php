<script type="text/javascript" src="/js/web/region.js"></script>

<div class="tip">
    <div class="arrow"></div>
</div>
<div class="main">
    <dl class="regbox setsbox">
        <dt>
        <ul class="regbar_box">
            <li class="fl regbar regbar_on">个人信息设置</li>
        </ul>
        </dt>
        <dd id="reg_box" class="">
            <?php $this->beginContent('/user/sidebar'); ?> <?php $this->endContent(); ?>
            <script type="text/javascript" src="/Js/region.js"></script>
            <div class="fl setbox">
                <div class="regform addrbox">
                    <ul class="addr_list" id="addr_list">

                        <?php if(!empty($list)): ?>
                        <?php foreach($list as $row): ?>
                            <li <?php if($row['is_default']): ?>class="addr_on"<?php endif; ?> id="<?php echo $row['id']; ?>">
                            <div>
                                <input checked="checked" type="radio" name="addr" id="addr_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
                                <p><span><b><?php echo $row['consignee']; ?></b></span><span><?php echo $row['mobile']; ?></span></p>
                                <p><span id="<?php echo $row['province']; ?>-<?php echo $row['city']; ?>-<?php echo $row['district']; ?>"><?php echo $row['province_name']; ?>-<?php echo $row['city_name']; ?>-<?php echo $row['district_name']; ?></span> <span><?php echo $row['address']; ?></span></p>
                                <p class="addr_operate">
                                    <b class="qing addr_set">设为默认</b>
                                    <b class="qing addr_edit">编辑</b>
                                    <b class="brown  addr_del">删除</b></p>
                            </div>
                            </li>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="clear"></div>
                    </ul>
                    <div class="uernewaddr" id="addr_modify"> <span>添加新地址</span> </div>
                    <div class="addr_item" id="addnewaddrs">
                        <input name="usid" type="hidden"id="usaddrid" value="" />
                        <input name="usid" type="hidden"id="isdefaultaddr" value="0" />
                        <div class="item">
                            <label>收货人姓名:</label>
                            <input name="usname" type="text" class="fl input sinput" id="usname" size="20" />
                            <span></span>
                            <div class="clear"></div>
                        </div>
                        <div class="item">
                            <label>收货人姓名:</label>
                            <select name="usprovince" class="fl mgr15" onchange="chgprovince(this.value);" id="usprovince">
                                <option value="0">请选择省</option>
                            </select>
                            <select name="uscity" class="fl mgr15" onchange="chgcity(this.value);" id="uscity">
                                <option value="0">请选择市</option>
                            </select>
                            <select name="usdistrict" class="fl mgr15"  id="usdistrict">
                                <option value="0">请选择区</option>
                            </select>
                            <span></span>
                            <div class="clear"></div>
                        </div>
                        <div class="item">
                            <label>详细地址:</label>
                            <input name="usaddr" type="text" class="fl input binput" id="usaddr" size="78" />
                            <span></span>
                            <div class="clear"></div>
                        </div>
                        <div class="item">
                            <label>手机号码:</label>
                            <input name="sumob" type="text" class="fl input sinput" id="usmob" size="20" />
                            <span></span>
                            <div class="clear"></div>
                        </div>
                        <div class="item">
                            <label>&nbsp;</label>
                            <div class="fl btn btn-large btn-primary" id="new_addr_btn">添加新地址</div>
                            <span id="modaddr_alert"></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </dd>
    </dl>
</div>