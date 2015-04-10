<div class="pageContent">
	<form method="post" action="manage/menu/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<p>
				<label>上级菜单：</label>
				<select name="parent_id">
					<option value="0" >顶级分类</option>
					<?php if($select): ?>
					<?php foreach($select as $list): ?>
					<option value="<?php echo $list['id']; ?>" <?php if($info->parent_id == $list['id']){ echo 'selected';}?> ><?php echo $list['title']; ?></option>
						<?php if(isset($list['child']) && !empty($list['child'])): ?>
						<?php foreach($list['child'] as $row): ?>
							<option value="<?php echo $row['id']; ?>" <?php if($info->parent_id == $row['id']){ echo 'selected';}?>><?php echo $list['title']."->".$row['title']; ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>标题：</label>
				<input type="text" name="title" size="30" value="<?php echo $info->title; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>页面标志：</label>
				<input type="text" name="page_sign" size="30" value="<?php echo $info->page_sign; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>url：</label>
				<input type="text" name="url" size="30" value="<?php echo $info->url; ?>"/>
			</p>
			<div class="divider"></div>
			<p>
				<label>状态：</label>
				<input type="radio" name="status" value="1" <?php if($info->status == 1){ echo 'checked';}?> />显示
				<input type="radio" name="status" value="0" <?php if($info->status == 0){ echo 'checked';}?> />不显示
			</p>
			<div class="divider"></div>
			<p>
				<label>排序：</label>
				<input type="text" name="sort" size="30" value="<?php echo $info->sort; ?>"/>
			</p>
			<div class="divider"></div>
			<dl class="nowrap">
				<dt>备注：</dt>
				<dd><textarea cols="45" rows="5" name="remark"><?php echo $info->remark; ?></textarea></dd>
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
