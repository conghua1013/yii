<script src="/css/dwz/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>
<link href="/css/dwz/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen" />
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

<div style="display:block;">
<form method="post" action="/manage/product/edit" class="pageForm required-validate" onsubmit="return iframeCallback(this,navTabAjaxDone);">
	<div class="tabs" eventType="click" currentIndex="1">

		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li class="selected"><a href="javascript:;"><span>基本信息</span></a></li>
					<li><a href="javascript:;"><span>商品描述</span></a></li>
					<li><a href="javascript:;"><span>价格信息</span></a></li>
					<li><a href="javascript:;"><span>商品图片</span></a></li>
				</ul>
			</div>
		</div>

		<div class="tabsContent" layoutH="70">

			<!--基本信息 start-->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品id：</label>
					<span><?php echo $pInfo['id'];?></span>
				</div>
				<div class="unit">
					<label>商品名称：</label>
					<input type="text" class="required"  name="product_name" value="<?php echo $pInfo['product_name'];?>"/>
				</div>
				<div class="unit">
					<label>商品副标题：</label>
					<input type="text" class="required"  name="subhead" value="<?php echo $pInfo['subhead'];?>"/>
				</div>
				<div class="unit">
					<label>商品品牌：</label>
					<select name="brand_id">
						<option value="0"> 请选择 </option>
						<?php if($brands): ?>
							<?php foreach($brands as $row): ?>
								<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $pInfo['brand_id']){echo 'selected';}?> > <?php echo $row['brand_name']; ?> </option>
							<?php endforeach; ?>
						<?php endif; ?>
						</volist>
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
										<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $pInfo['cat_id']){echo 'selected';}?> ><?php echo $list['cat_name']."->".$row['cat_name']; ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="unit">
					<label>商品关键字：</label>
					<input type="text"  name="keywords" value="<?php echo $pInfo['keywords'];?>" />
				</div>
				<div class="unit">
					<label>商品描述：</label>
					<input type="text"  name="describtion" value="<?php echo $pInfo['describtion'];?>" />
				</div>

				<div class="unit">
					<label>商品物料：</label>
					<input type="text"  name="product_material" value="<?php //echo $pInfo['product_material'];?>" />
				</div>
				<div class="unit">
					<label>质保：</label>
					<input type="text"  name="warranty" value="<?php //echo $pInfo['warranty'];?>" />
				</div>
				<div class="unit">
					<label>服务：</label>
					<input type="text"  name="product_service" value="<?php //echo $pInfo['product_service'];?>" />
				</div>
				<div class="unit">
					<label>尺寸：</label>
					<input type="text"  name="product_size" value="<?php //echo $pInfo['product_size'];?>" />
				</div>
				<div class="unit">
					<label>重量：</label>
					<input type="text"  name="weight" value="<?php //echo $pInfo['weight'];?>" />
				</div>
				<div class="unit">
					<label>生产日期：</label>
					<input type="text"  name="make_date" value="<?php //echo $pInfo['make_date'];?>" class="date" />
				</div>
				<div class="unit">
					<label>保质期：</label>
					<input type="text"  name="use_life" value="<?php //echo $pInfo['use_life'];?>" />
				</div>
				<div class="unit">
					<label>退换货政策：</label>
					<input type="text"  name="product_return" value="<?php //echo $pInfo['product_return'];?>" />
				</div>
				<div class="unit">
					<label>保养说明：</label>
					<input type="text"  name="product_maintain" value="<?php //echo $pInfo['product_maintain'];?>" />
				</div>
				<div class="unit">
					<label>使用说明：</label>
					<input type="text"  name="use_notice" value="<?php //echo $pInfo['use_notice'];?>" />
				</div>
				<div class="unit">
					<label>温馨提示：</label>
					<input type="text"  name="product_notice" value="<?php //echo $pInfo['product_notice'];?>" />
				</div>
			</div>
			<!--基本信息 end-->

			<!--商品描述 start-->
			<div>
				<textarea class="editor" name="detail" rows="27" cols="150"
								upLinkUrl="/manage/index/xheditorUpload" upLinkExt="zip,rar,txt"
								upImgUrl="/manage/index/xheditorUpload" upImgExt="jpg,jpeg,gif,png"
								upFlashUrl="/manage/index/xheditorUpload" upFlashExt="swf"
								upMediaUrl="/manage/index/xheditorUpload" upMediaExt:"avi">
				<?php echo $pInfo['detail'];?></textarea>

				<div class="unit">
					<label>视频链接：</label>
					<input type="text"  name="vedio_url" value="<?php echo $pInfo['vedio_url'];?>"/>
				</div>
			</div>
			<!--商品描述 end-->

			<!--价格信息 start-->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品市场价：</label>
					<input type="text" name="market_price" value="<?php echo $pInfo['market_price'];?>" />
				</div>
				<div class="unit">
					<label>商品售价：</label>
					<input type="text" name="sell_price" value="<?php echo $pInfo['sell_price'];?>" />
				</div>
				<div class="unit">
					<label>成本价：</label>
					<input type="text" name="cost_price" value="<?php echo $pInfo['cost_price'];?>" />
				</div>
				<div class="unit">
					<label>库存是否有不同尺寸：</label>
					<input type="radio" name="is_multiple" value="0" <?php if($pInfo['is_multiple'] == 0){ echo 'checked'; } ?> />否
					<input type="radio" name="is_multiple" value="1" <?php if($pInfo['is_multiple'] == 1){ echo 'checked'; } ?> />是
				</div>
				<div class="unit quantity" <?php if($pInfo['is_multiple'] == 1){echo 'style="display:none;"';}?> >
					<label>商品库存：</label>
					<input type="text" name="quantity" value="1" value="<?php echo $pInfo['quantity'];?>" />
					<span>如果商品是有多个款式，请选择上面库存方式选择有多款，在下面的款式中写入款式个数</span>
				</div>
				<div class="divider"></div>

				<div <?php if(empty($pInfo['is_multiple'])): ?>style="display:none;"<?php endif; ?> >
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
					<div style="clear: both;"></div>
					<div id="attr_content">
						<?php if(!empty($stocks) && $pInfo['is_multiple'] == 1): ?>
							<?php foreach($stocks as $row): ?>
								<div id="att_id_10" class="attr_div">
									<span><?php echo $attrList[$row['attr_id']]['attr_name'];?></span>
									<input type="hidden" name="attr_list[<?php echo $row['attr_id'];?>]" value="<?php echo $row['attr_id'];?>">
									<input type="text" name="attr_stock[<?php echo $row['attr_id'];?>]" value="<?php echo $row['quantity'];?>" size="10" class="valid">
									<span class="del_attr">删除</span>
								</div>
							<?php endforeach;?>
						<?php endif; ?>
					</div>
					<div style="clear: both;"></div>
					<div style="margin-top:5px;">此处的属性只能改变选择其中的一项,当你切换的时候就会清除下面显示的所有的属性信息，替换为你选中的属性项中的列表，<br>
						然后你不需要的选项你可以点击删除删除掉，或者不填也可以。只要不点提交按钮就不会保存到数据库中</div>
				</div>
				<div class="divider"></div>

				<div class="unit">
					<label>同款不同色id：</label>
					<input type="text" name="same_color_products" value="<?php echo $pInfo['same_color_products'];?>" />
					<span>商品id都是以,分割</span>
				</div>

			</div>
			<!-- 价格信息 end -->


			<!--商品图片start-->
			<div class="pageFormContent">
				<div class="unit">
					<label>商品图片：</label>
					<div id="product_Imgs">
						<?php if(!empty($pImages)): ?>
						<?php foreach($pImages as $row): ?>
							<div imgid="<?php echo $row['id']; ?>" id="imgid_<?php echo $row['id']; ?>">
								<img src="<?php echo $row['img']; ?>" alt="<?php echo $row['img']; ?>" width="50"/><br/>
								<input type="button" value="删除" class="delImg"/>
							</div>
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="unit" style="margin-top:30px;">
					<input type="file" name="file_upload" id="file_upload" />
				</div>
			</div>
			<!-- 商品价格及库存 end -->

			<input type="hidden" name="id" value="<?php echo $pInfo['id'];?>" id="product_id" />
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
$(function() {  

	//上传图片
    $('#file_upload').uploadify({  
        'swf'      : '/js/dwz/uploadify/scripts/uploadify.swf',
        'uploader' : '/manage/product/UploadImage',
        'formData' : {'id':$('#product_id').val(),'sessionId':'<?php echo session_id(); ?>' },
        'auto' : true,  
        'fileSizeLimit' : '700KB',  
        'fileTypeDesc' : 'Image Files',  
        'fileTypeExts' : '*.gif; *.jpg; *.png',  
        'buttonText':'上传',
        'onUploadSuccess' : function(file, data, response) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == 200) {
             	var image = '<div imgid="'+obj.imgid+'" id="imgid_'+obj.imgid+'">'+'<img width="50" alt="'+obj.imgid+'" src="' + obj.img.image_100 + '" /><br/>'+
             		'<input type="button" value="删除" class="delImg"/></div>';
            	$("#product_Imgs").append(image); 
            }else{
            	alert('图片上传失败！原因：'+obj.errorMsg);
            }	   
          },  
        'onQueueComplete' : function(queueData) {
			//alert('上传成功');
		}
    });

	//删除图片
	$('.delImg').live('click',function(){
		var id = $(this).parent().attr('imgid');
		$.ajax({
			type: "POST",
			url: "/manage/product/deleteImage",
			data: {id:id},
			async : true,
			dataType: "json",
			success: function(data){
				if(data.status == 200){
					$('#imgid_' + data.id).remove();
				}else{
					alert(data.message);
				}
			}
		});
	});


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

	//绑定多库存时的显示与隐藏事件
	$('input[name="is_multiple"]').click(function(){
		if($('input[name="is_multiple"]:checked ').val() == 0){
			$('#attr_id').val(0); //设置select的值为初始值
			$('#attr_content').parent().hide();
			$('#attr_content').html('');
			$('.quantity').show();
		}else{
			$('#attr_content').parent().show();
			$('.quantity').hide();
		}
	})

	//修正火狐刷新时的js不对应
//	if($('input[name=is_multiple]:checked').val() == 1){
//		$('#attr_content').parent().show();
//		$('.quantity').hide();
//	}else{
//		$('#attr_content').parent().show();
//		$('.quantity').show();
//	}

	//商品属性列表删除操作绑定时间
	$('.del_attr').live('click',function(){
		$(this).parent().remove();
	})



}); 
</script>


<style type="text/css" media="screen">
.my-uploadify-button {
	background:none;
	border: none;
	text-shadow: none;
	border-radius:0;
}

.uploadify:hover .my-uploadify-button {
	background:none;
	border: none;
}

.fileQueue {
	width: 400px;
	height: 150px;
	overflow: auto;
	border: 1px solid #E5E5E5;
	margin-bottom: 10px;
}

#product_Imgs div {
	border:1px solid #cccccc;
	padding:2px;
	margin-left:10px;
	float:left;
}
</style>
