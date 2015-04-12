<script src="/css/dwz/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>
<link href="/css/dwz/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>


<div class="pageContent">
<div class="tabs pageForm" currentIndex="1" eventType="click">

<form method="post" action="/Manage/product/update" class="pageForm required-validate" onsubmit="return iframeCallback(this,navTabAjaxDone);">
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
<div class="tabsContent pageFormContent" style="padding:0px 0px 5px 0px ;" layoutH="73">

	<!--基本信息start-->
	<div>
		<div class="unit">
			<label>商品id：</label>
			<span>{$info.id}</span>
		</div>
		<div class="unit">
			<label>商品名称：</label>
			<input type="text" class="required"  name="product_name" value="{$info.product_name}"/>
		</div>
		<div class="unit">
			<label>商品副标题：</label>
			<input type="text" class="required"  name="subhead" value="{$info.subhead}"/>
		</div>
		<div class="unit">
			<label>商品品牌：</label>
			<select name="brand_id">
				<option value="0"> 请选择 </option>
				<volist name="brandList" id="row">
				<option value="{$row.id}" <eq name="info.brand_id" value="$row.id">selected</eq> > {$row.brand_name} </option>
				</volist>
			</select>
		</div>
		<div class="unit">
			<label>商品分类：</label>
			<select name="cat_id">
				<option value="0">请选择</option>
				<volist name="cateTree" id="vo">
					<volist name="vo.child" id="row">
						<option value="{$row.id}" <eq name="info.cat_id" value="$row.id">selected</eq> >{$vo.cat_name}---{$row.cat_name}</option>
					</volist>
				</volist>
			</select>
		</div>
		<div class="unit">
			<label>商品关键字：</label>
			<input type="text"  name="keywords" value="{$info.keywords}" />
		</div>
		<div class="unit">
			<label>商品描述：</label>
			<input type="text"  name="describtion" value="{$info.describtion}" />
		</div>

		<div class="unit">
			<label>商品物料：</label>
			<input type="text"  name="product_material" value="{$info.product_material}" />
		</div>
		<div class="unit">
			<label>质保：</label>
			<input type="text"  name="warranty" value="{$info.warranty}" />
		</div>
		<div class="unit">
			<label>服务：</label>
			<input type="text"  name="product_service" value="{$info.product_service}" />
		</div>
		<div class="unit">
			<label>尺寸：</label>
			<input type="text"  name="product_size" value="{$info.product_size}" />
		</div>
		<div class="unit">
			<label>重量：</label>
			<input type="text"  name="weight" value="{$info.weight}" />
		</div>
		<div class="unit">
			<label>生产日期：</label>
			<input type="text"  name="make_date" value="{$info.make_date}" class="date" />
		</div>
		<div class="unit">
			<label>保质期：</label>
			<input type="text"  name="use_life" value="{$info.use_life}" />
		</div>
		<div class="unit">
			<label>退换货政策：</label>
			<input type="text"  name="product_return" value="{$info.product_return}" />
		</div>
		<div class="unit">
			<label>保养说明：</label>
			<input type="text"  name="product_maintain" value="{$info.product_maintain}" />
		</div>
		<div class="unit">
			<label>使用说明：</label>
			<input type="text"  name="use_notice" value="{$info.use_notice}" />
		</div>
		<div class="unit">
			<label>温馨提示：</label>
			<input type="text"  name="product_notice" value="{$info.product_notice}" />
		</div>
	</div>


	<!--商品描述start-->
	<div>
		<textarea class="editor" name="detail" rows="27" cols="150"
						upLinkUrl="/manage/index/xheditorUpload" upLinkExt="zip,rar,txt" 
						upImgUrl="/manage/index/xheditorUpload" upImgExt="jpg,jpeg,gif,png" 
						upFlashUrl="/manage/index/xheditorUpload" upFlashExt="swf"
						upMediaUrl="/manage/index/xheditorUpload" upMediaExt:"avi">
		{$info.detail}</textarea>

		<div class="unit">
			<label>视频链接：</label>
			<input type="text"  name="vedio_url" value="{$info.vedio_url}"/>
		</div>
	</div>


	<!--价格信息start-->
	<div>
		<div class="unit">
			<label>商品市场价：</label>
			<input type="text" name="market_price" value="{$info.market_price}" />
		</div>
		<div class="unit">
			<label>商品售价：</label>
			<input type="text" name="sell_price" value="{$info.sell_price}" />
		</div>
		<div class="unit">
			<label>成本价：</label>
			<input type="text" name="cost_price" value="{$info.cost_price}" />
		</div>
		<div class="unit">
			<label>库存是否有不同尺寸：</label>
			<input type="radio" name="is_multiple" value="0" <eq name="info.is_multiple" value="0">checked</eq> />否
			<input type="radio" name="is_multiple" value="1" <eq name="info.is_multiple" value="1">checked</eq> />是
		</div>
		<div class="unit quantity" <eq name="info.is_multiple" value="1">style="display:none;"</eq>>
			<label>商品库存：</label>
			<input type="text" name="quantity" value="1" value="{$info.quantity}" />
			<span>如果商品是有多个款式，请选择上面库存方式选择有多款，在下面的款式中写入款式个数</span>
		</div>

		
		
		<volist  name="attrList" id="v">

		<eq name="v.id" value="2">  <!-- 原产地 -->
		<div class="unit">
			<label> {$v.attr_name} ：</label>
			<select name="attr[{$v.id}]">
				<option value="0"> 请选择 </option>
				<volist  name="v.child" id="row">
				<option value="{$row.id}" <eq name="row.id" value="$info.origin_id"> selected</eq> > {$row.attr_name} </option>
				</volist >
			</select>
		</div>
		</eq>
	
		<eq name="v.id" value="1">
		<div class="unit" <eq name="info.is_multiple" value="0">style="display:none;"</eq> id="multiple_storage"><!-- 尺寸规格 -->
			<label> {$v.attr_name} ：</label>
			<volist  name="v.child" id="row">
			<input type="checkbox" name="attr[{$v.id}][]" value="{$row.id}" id="attr_{$row.id}" <eq name="row.check" value="1" >checked</eq> />
			<span for="attr_{$row.id}">{$row.attr_name}</span>
			<input type="input" name="stock[{$row.id}]" id="stock_{$row.id}" value="{$row.quantity}" size="1"/>个&nbsp;&nbsp;&nbsp;
			</volist >
			<span>没有可以不选</span>
		</div>
		</eq>
	
		<eq name="v.id" value="3">
		<div class="unit"><!-- 颜色 -->
			<label> {$v.attr_name} ：</label>
			<volist  name="v.child" id="row">
			<input type="checkbox" name="attr[{$v.id}][]" value="{$row.id}" id="attr_{$row.id}" 
				<in name="row.id" value="$info.colorids" >checked</in> /><span for="attr_{$row.id}">{$row.attr_name} </span>
			</volist >
			<span>没有可以不选</span>
		</div>
		</eq>

		</volist >

		<div class="unit">
			<label>同款不同色id：</label>
			<input type="text" name="same_color_products" value="{$info.same_color_products}" />
			<span>商品id都是以,分割</span>
		</div>

	</div>




	<!--商品图片start-->
	<div>
		<div class="unit">
			<label>商品图片：</label>
			<div id="product_Imgs">
			<volist name="info.img" id="vo">
				<div imgid="{$vo.id}" id="imgid_{$vo.id}">
				<img src="{$vo.img_50}" alt="{$vo.img_50}" />
				<br/>
				<input type="button" value="删除" class="delImg"/>
				</div>
			</volist>
			</div>
		</div>

		<div class="unit" style="margin-top:30px;">
			<input type="file" name="file_upload" id="file_upload" />
		</div>

	</div>
	<input type="hidden" name="id" value="{$info.id}" id="product_id" />
</div>

<div class="formBar">
	<ul>
		<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
		<li><div class="button"><div class="buttonContent"><button type="button" class="close">Cancel</button></div></div></li>
	</ul>
</div>
</form>



<div class="tabsFooter">
	<div class="tabsFooterContent"></div>
</div>

</div>

</div>



<script>
$(function() {  
           
    $('#file_upload').uploadify({  
        'swf'      : '/Public/dwz/uploadify/scripts/uploadify.swf',  
        'uploader' : '/manage/product/uploadImg', 
        'formData' : {'id':$('#product_id').val(),'sessionId':'<?php echo session_id(); ?>' },
        'auto' : true,  
        'fileSizeLimit' : '700KB',  
        'fileTypeDesc' : 'Image Files',  
        'fileTypeExts' : '*.gif; *.jpg; *.png',  
        'buttonText':'上传',
        'onUploadSuccess' : function(file, data, response) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == 200) {
             	var image = '<div imgid="'+obj.imgid+'" id="imgid_'+obj.imgid+'">'+'<img width="50" alt="'+obj.imgid+'" src="/Public/Images/product/'+obj.img+'" /><br/>'+
             		'<input type="button" value="删除" class="delImg"/></div>';
            	$("#product_Imgs").append(image); 
            }else{
            	alert('图片上传失败！原因：'+obj.errorMsg);
            }	   
          },  
        'onQueueComplete' : function(queueData) {alert('上传成功');}
    });

    //绑定多库存时的显示与隐藏事件
	$('input[name="is_multiple"]').click(function(){
		if($('input[name="is_multiple"]:checked').val() == 1){
			$('#multiple_storage').show();
			$('.quantity').hide();
		}else{
			$('#multiple_storage').hide();
			$('.quantity').show();
		}
	})

	//修正火狐刷新时的js不对应
	if($('input[name=is_multiple]:checked').val() == 1){
		$('#multiple_storage').show();
		$('.quantity').hide();
	}else{
		$('#multiple_storage').hide();
		$('.quantity').show();
	}

	$('.delImg').live('click',function(){
		var id = $(this).parent().attr('imgid');
		$.ajax({
            type: "POST",
            url: "/manage/product/delImg",
            data: {id:id},
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
