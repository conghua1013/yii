<div style="display:block;">
<!-- <div style="display:block; overflow:hidden; padding:0 3px; line-height:21px;"> -->
	
	<form method="post" action="manage/product/add" class="pageForm required-validate" onsubmit="return iframeCallback(this)">
	<div class="tabs" eventType="click" currentIndex="1">
		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li><a href="javascript:;"><span>商品基本信息</span></a></li>
					<li class="selected"><a href="javascript:;"><span>商品详情</span></a></li>
					<li><a href="javascript:;"><span>商品图片</span></a></li>
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
			</div>
			<!-- 商品详情 end -->

			

			<!-- 商品图片 start -->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品市场价：</label>
					<input type="text" name="market_price">
				</div>
				<div class="unit">
					<label>商品售价：</label>
					<input type="text" name="sell_price">
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
				<div class="unit quantity">
					<label>商品库存：</label>
					<input type="text" name="quantity" value="1">
					<span>如果商品是有多个款式，请选择上面库存方式选择有多款，在下面的款式中写入款式个数</span>
				</div>
				
				
				<volist  name="attrList" id="v">

					<eq name="v.id" value="2">
					<div class="unit"><!-- 原产地 -->
						<label> {$v.attr_name} ：</label>
						<select name="attr[{$v.id}]">
							<option value="0"> 请选择 </option>
							<volist  name="v.child" id="row">
							<option value="{$row.id}"> {$row.attr_name} </option>
							</volist >
						</select>
					</div>
					</eq>

					<eq name="v.id" value="1"> 
					<div class="unit" style="display:none;" id="multiple_storage">  <!-- 尺寸规格 -->
						<label> {$v.attr_name} ：</label>
						<volist  name="v.child" id="row">
						<input type="checkbox" name="attr[{$v.id}][]" value="{$row.id}"  id="attr_{$row.id}"/>
						<span for="attr_{$row.id}">{$row.attr_name} </span>
						<input type="input" name="stock[{$row.id}]" id="stock_{$row.id}" size="1"/>个&nbsp;&nbsp;&nbsp;
						</volist >
					</div>
					</eq>

					<eq name="v.id" value="3">
					<div class="unit"> <!-- 颜色 -->
						<label> {$v.attr_name} ：</label>
						<volist  name="v.child" id="row">
						<input type="radio" name="attr[{$v.id}][]" value="{$row.id}"  id="attr_{$row.id}"/><span for="attr_{$row.id}">{$row.attr_name} </span>
						</volist >
					</div>
					</eq>

				</volist >

				<div class="unit">
					<label>同款不同色id：</label>
					<input type="text" name="same_color_products" value="" />
					<span>商品id都是以,分割</span>
				</div>
			</div>
			<!-- 商品图片 end -->
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