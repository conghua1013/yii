<div class="pageContent">

	<form method="post" action="manage/indexModule/add" enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this,navTabAjaxDone);">

		<div class="pageFormContent" layoutH="58">

			<div class="unit">
				<label>标题：</label>
				<input type="text" class="required"  name="title" />
			</div>

			<div class="unit">
				<label>图片：</label>
				<input type="file" class="required"  name="img" />
			</div>

			<div class="unit">
				<label>链接：</label>
				<input type="text" class="required"  name="link" />
			</div>

			<div class="unit">
				<label>banner位描述：</label>
				<textarea name="describtion"  rows="5" cols="57"></textarea>
			</div>

			<div class="unit">
				<label>手工配置5个货品id：</label>
				<input type="text"  name="product_ids" />
			</div>

			<div class="unit">
				<label>推荐商品策略：</label>
				<select name="type">
					<option value="0">请选择</option>
					<?php if($types): ?>
					<?php foreach($types as $key => $row): ?>
						<option value="<?php echo $key; ?>"> <?php echo $row; ?> </option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>

			<div class="unit">
				<label>开始时间：</label>
				<input type="text" name="start_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss"  />
			</div>

			<div class="unit">
				<label>结束时间：</label>
				<input type="text" name="end_time" class="required date textInput valid" datefmt="yyyy-MM-dd HH:mm:ss" />
			</div>
			
			<div class="unit">
				<label>是否显示：</label>
				<select   name="is_show">
					<option value="1">显示</option>
					<option value="0">不显示</option>
				</select>
			</div>
			
			<div class="unit">
				<label>排序：</label>
				<input type="text" name="sort"  value="0"/>
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
