<h2 class="contentTitle">编辑器</h2>
<div style="display:block; overflow:hidden; padding:0 10px; line-height:21px;">
	
	<div class="tabs">
		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li class="selected"><a href="javascript:;"><span>商品基本信息</span></a></li>
					<li><a href="javascript:;"><span>商品详情</span></a></li>
					<li><a href="javascript:;"><span>图片上传</span></a></li>
				</ul>
			</div>
		</div>
		<div class="tabsContent" layoutH="100">
			<div>
				<form method="post" action="demo/common/ajaxTimeout.html" class="pageForm required-validate" onsubmit="return iframeCallback(this)">
					<div class="pageFormContent" layoutH="158">
						<div class="unit">
							<textarea class="editor" name="description" rows="40" cols="150"
								upLinkUrl="upload.php" upLinkExt="zip,rar,txt" 
								upImgUrl="upload.php" upImgExt="jpg,jpeg,gif,png" 
								upFlashUrl="upload.php" upFlashExt="swf"
								upMediaUrl="upload.php" upMediaExt:"avi">
							</textarea>
						</div>
					</div>
					<div class="formBar">
						<ul>
							<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
							<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
						</ul>
					</div>
				</form>
			</div>
			
			<div>  </div>

			<div>  </div>
			
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>

</div>