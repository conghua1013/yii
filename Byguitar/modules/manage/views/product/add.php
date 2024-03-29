<div style="display:block;">
	<form method="post" action="/manage/product/add" class="pageForm required-validate" onsubmit="return iframeCallback(this)">
	<div class="tabs" eventType="click" currentIndex="1">

		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li><a href="javascript:;"><span>商品基本信息</span></a></li>
					<li class="selected"><a href="javascript:;"><span>商品详情</span></a></li>
					<li><a href="javascript:;"><span>商品价格及库存</span></a></li>
				</ul>
			</div>
		</div>

		<div class="tabsContent" layoutH="70">

			<!-- 商品基本信息 start -->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品名称：</label>
					<input type="text" class="required"  name="product_name" />
				</div>
				<div class="unit">
					<label>商品副标题：</label>
					<input type="text" class="required"  name="subhead" />
				</div>
				<div class="unit">
					<label>商品品牌：</label>
					<select name="brand_id">
						<option value="0"> 请选择 </option>
						<?php if($brands): ?>
						<?php foreach($brands as $row): ?>
							<option value="<?php echo $row['id']; ?>"> <?php echo $row['brand_name']; ?> </option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="unit">
					<label>商品分类：</label>
					<select name="cat_id">
						<option value="0">请选择</option>
						<?php if($categorys): ?>
						<?php foreach($categorys as $list): ?>
							<option value="<?php echo $list['id']; ?>"> <?php echo $list['cat_name']; ?> </option>
							<?php if(isset($list['child']) && !empty($list['child'])): ?>
							<?php foreach($list['child'] as $row): ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $list['cat_name']."->".$row['cat_name']; ?></option>
							<?php endforeach; ?>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="unit">
					<label>商品关键字：</label>
					<input type="text"  name="keywords" />
				</div>
				<div class="unit">
					<label>商品描述：</label>
					<input type="text"  name="describtion" />
				</div>

				<div class="unit">
					<label>商品物料：</label>
					<input type="text"  name="product_material" />
				</div>
				<div class="unit">
					<label>质保：</label>
					<input type="text"  name="warranty" />
				</div>
				<div class="unit">
					<label>服务：</label>
					<input type="text"  name="product_service" />
				</div>
				<div class="unit">
					<label>尺寸：</label>
					<input type="text"  name="product_size" />
				</div>
				<div class="unit">
					<label>重量：</label>
					<input type="text"  name="weight" />
				</div>
				<div class="unit">
					<label>生产日期：</label>
					<input type="text"  name="make_date" class="date" />
				</div>
				<div class="unit">
					<label>保质期：</label>
					<input type="text"  name="use_life" />
				</div>
				<div class="unit">
					<label>退换货政策：</label>
					<input type="text"  name="product_return" />
				</div>
				<div class="unit">
					<label>保养说明：</label>
					<input type="text"  name="product_maintain" />
				</div>
				<div class="unit">
					<label>使用说明：</label>
					<input type="text"  name="use_notice" />
				</div>
				<div class="unit">
					<label>温馨提示：</label>
					<input type="text"  name="product_notice" />
				</div>
			</div>
			<!-- 商品基本信息 end -->

			<!-- 商品详情 start   目前该模块不能移位否则导致显示高度不够   -->
			<div>
				<textarea class="editor" name="detail" rows="29" cols="130"
					upLinkUrl="upload.php" upLinkExt="zip,rar,txt" 
					upImgUrl="upload.php" upImgExt="jpg,jpeg,gif,png" 
					upFlashUrl="upload.php" upFlashExt="swf"
					upMediaUrl="upload.php" upMediaExt:"avi">
				</textarea>	
				<div class="divider"></div>
				<div class="unit">
					<label>视频链接：</label>
					<input type="text" name="vedio_url" />
				</div>
			</div>
			<!-- 商品详情 end -->

			<!-- 商品价格及库存 start -->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品市场价：</label>
					<input type="text" name="market_price" />
				</div>
				<div class="unit">
					<label>商品售价：</label>
					<input type="text" name="sell_price" />
				</div>
				<div class="unit">
					<label>成本价：</label>
					<input type="text" name="cost_price" />
				</div>
				<div class="unit">
					<label>库存是否有不同尺寸：</label>
					<input type="radio" name="is_multiple" value="0" checked />否
					<input type="radio" name="is_multiple" value="1" />是
				</div>
				<div class="unit">
					<label>商品库存：</label>
					<input type="text" name="quantity" value="1">
					<span>如果商品是有多个款式，请选择上面库存方式选择有多款，在下面的款式中写入款式个数</span>
				</div>
				<div class="divider"></div>

				<div style="/*border:1px solid #ccc;*/display:none;">
					<div>
					<label>多库存sku可选列表：</label>
					<select name="attr_id" id="attr_id">
						<option value="0">请选择</option>
						<?php if(!empty($productAttributes)): ?>
						<?php foreach($productAttributes as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['attr_name']; ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
					</div>
					<div style="clear:both;"></div>
					<div id="attr_content"></div>
					<div style="clear: both;"></div>
					<div style="margin-top:5px;">此处的属性只能改变选择其中的一项,当你切换的时候就会清除下面显示的所有的属性信息，替换为你选中的属性项中的列表，<br>
						然后你不需要的选项你可以点击删除删除掉，或者不填也可以。只要不点提交按钮就不会保存到数据库中</div>
				</div>

				<div class="divider"></div>
				<div class="unit">
					<label>同款不同色id：</label>
					<input type="text" name="same_color_products" value="" />
					<span>商品id都是以,分割</span>
				</div>
			</div>
			<!-- 商品价格及库存 end -->

		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>


		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>
	</form>
</div>

<script>
	window.productAttrList = <?php echo json_encode($productAttributes); ?>
</script>

<script>
$(document).ready(function(){

	//属性列表切换选项操作
	$('#attr_id').change(function(){
		if(window.productAttrList){
			var htmlStr = '';
			$.each(window.productAttrList[$('#attr_id').val()].child,function(i,info){
				htmlStr += '<div id="att_id_'+info.id+'" class="attr_div"><span>'+info.attr_name+'</span>'
					+'<input type="hidden" name="attr_list['+info.id+']" value="'+info.id+'" />'
					+'<input type="text" name="attr_stock['+info.id+']" size="10"/>'
					+'<span class="del_attr">删除</span>'
					+'</div>';
			});
			$('#attr_content').html(htmlStr);
		}
	})

	//商品属性列表删除操作绑定时间
	$('.del_attr').live('click',function(){
		$(this).parent().remove();
	})

	$('input[name="is_multiple"]').click(function(){
		if($('input[name="is_multiple"]:checked ').val() == 0){
			$('#attr_id').val(0); //设置select的值为初始值
			$('#attr_content').parent().hide();
			$('#attr_content').html('');
		}else{
			$('#attr_content').parent().show();
		}
	})

})

</script>

<style>
.attr_div {
	/*border:1px solid green;*/
	float:left;
	margin:0px 5px;
}
#attr_content {
	/*border:1px solid blue;*/
	width:700px;
</style>

