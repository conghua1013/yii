<div class="pageContent">
	<form method="post" action="manage/brand/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);" enctype="multipart/form-data">
		<div class="pageFormContent" layoutH="57">
			<p>
				<label>品牌名称：</label>
				<input type="text" name="brand_name" size="30" value="<?php echo $info->brand_name; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌英文名：</label>
				<input type="text" name="english_name" size="30" value="<?php echo $info->english_name; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌logo：</label>
				<input type="file" name="brand_logo" id="brand_logo"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌所在地：</label>
				<input type="text" name="from_city" size="30" value="<?php echo $info->from_city; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌联系手机：</label>
				<input type="text" name="mobile" size="30" value="<?php echo $info->mobile; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌联系电话：</label>
				<input type="text" name="tel" size="30" value="<?php echo $info->tel; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌联系地址：</label>
				<input type="text" name="address" size="30" value="<?php echo $info->address; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>品牌网址：</label>
				<input type="text" name="site_url" size="30" value="<?php echo $info->site_url; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>状态：</label>
				<input type="radio" name="is_show" value="1" <?php if($info->is_show == 1){echo 'checked';} ?> />显示
				<input type="radio" name="is_show" value="0" <?php if($info->is_show == 0){echo 'checked';} ?> />不显示
			</p>
			<div class="divider"></div>
			<p>
				<label>排序：</label>
				<input type="text" name="sort" size="30" value="<?php echo $info->sort; ?>" />
			</p>
			<div class="divider"></div>
			<p>
				<label>关键字（页面title）：</label>
				<input type="text" name="keywords" size="30" value="<?php echo $info->keywords; ?>"/>
			</p>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>描述（页面title）：</dt>
				<dd><textarea cols="45" rows="5" name="describtion"><?php echo $info->describtion; ?></textarea></dd>
			</dl>
			<input type="hidden" name="id" value="<?php echo $info->id; ?>" />
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div>
