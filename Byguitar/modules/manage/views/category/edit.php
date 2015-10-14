<div class="pageContent">
	<form method="post" action="/manage/category/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<p>
				<label>上级菜单：</label>
				<select name="parent_id">
					<option value="0" >顶级分类</option>
					<?php if($select): ?>
					<?php foreach($select as $list): ?>
					<option value="<?php echo $list['id']; ?>" <?php if($info->parent_id == $list['id']){echo 'selected';} ?>  ><?php echo $list['cat_name']; ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>分类名称：</label>
				<input type="text" name="cat_name" size="30" value="<?php echo $info->cat_name; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>url：</label>
				<input type="text" name="url" size="30" value="<?php echo $info->url; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>是否显示：</label>
				<input type="radio" name="is_show" value="1" <?php if($info->is_show == 1){echo 'checked';} ?> />显示
				<input type="radio" name="is_show" value="0" <?php if($info->is_show == 0){echo 'checked';} ?>/>不显示
			</p>
			<div class="divider"></div>
			<p>
				<label>是否可选：</label>
				<input type="radio" name="select_able" value="1" <?php if($info->select_able == 1){echo 'checked';} ?> />可选
				<input type="radio" name="select_able" value="0" <?php if($info->select_able == 0){echo 'checked';} ?> />不可选
			</p>
			<div class="divider"></div>
			<p>
				<label>排序：</label>
				<input type="text" name="sort" size="30" value="<?php echo $info->sort; ?>"/>
			</p>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面title：</dt>
				<dd><input type="text" name="title" size="30" value="<?php echo $info->title; ?>"/></dd>
			</dl>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面keywords：</dt>
				<dd><input type="text" name="keywords" size="30" value="<?php echo $info->keywords; ?>"/></dd>
			</dl>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面describtion：</dt>
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
