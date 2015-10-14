<div class="pageContent">
	<form method="post" action="/manage/category/add" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<p>
				<label>上级菜单：</label>
				<select name="parent_id">
					<option value="0" >顶级分类</option>
					<?php if($select): ?>
					<?php foreach($select as $list): ?>
					<option value="<?php echo $list['id']; ?>" ><?php echo $list['cat_name']; ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>分类名称：</label>
				<input type="text" name="cat_name" size="30" />
			</p>
			<div class="divider"></div>
			<p>
				<label>url：</label>
				<input type="text" name="url" size="30" />
			</p>
			<div class="divider"></div>
			<p>
				<label>是否显示：</label>
				<input type="radio" name="is_show" value="1" checked />显示
				<input type="radio" name="is_show" value="0" />不显示
			</p>
			<div class="divider"></div>
			<p>
				<label>是否可选：</label>
				<input type="radio" name="select_able" value="1" checked />可选
				<input type="radio" name="select_able" value="0" />不可选
			</p>
			<div class="divider"></div>
			<p>
				<label>排序：</label>
				<input type="text" name="sort" size="30" value="0"/>
			</p>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面title：</dt>
				<dd><input type="text" name="title" size="30" /></dd>
			</dl>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面keywords：</dt>
				<dd><input type="text" name="keywords" size="30" /></dd>
			</dl>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>页面describtion：</dt>
				<dd><textarea cols="45" rows="5" name="describtion"></textarea></dd>
			</dl>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div>
