<div class="pageContent">
	<form method="post" action="demo/common/ajaxDone.html" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="56">
			<div class="tabs" currentIndex="0" eventType="click">
				<div class="tabsHeader">
					<div class="tabsHeaderContent">
						<ul>
							<li><a href="javascript:;"><span>商品基本信息</span></a></li>
							<li><a href="javascript:;"><span>商品库存信息</span></a></li>
							<li><a href="javascript:;"><span>商品图片信息</span></a></li>
							<!-- <li><a href="demo_page2.html" class="j-ajax"><span>标题3</span></a></li> -->
						</ul>
					</div>
				</div>
				<div class="tabsContent" style="height:150px;">
					<!-- 商品基本信息 start -->
					<div>
						<dl>
							<dt>必填：</dt>
							<dd>
								<input type="text" name="name" maxlength="20" class="required" />
								<span class="info">class="required"</span>
							</dd>
						</dl>
						<dl>
							<dt>必填：</dt>
							<dd>
								<input type="text" name="name" maxlength="20" class="required" />
								<span class="info">class="required"</span>
							</dd>
						</dl>
					</div>
					<!-- 商品基本信息 end -->


					<!-- 商品库存信息 start -->
					<div>
						<p>
							<label>客 户 号：</label>
							<input name="sn" type="text" size="30" value="100001" readonly="readonly"/>
						</p>
					</div>
					<!-- 商品库存信息 end -->
					

					<!-- 商品图片信息 start -->
					<div>
						<dl>
							<dt>必填：</dt>
							<dd>
								<input type="text" name="name" maxlength="20" class="required" />
								<span class="info">class="required"</span>
							</dd>
						</dl>
					</div>
					<!-- 商品图片信息 end -->
				</div>
				<div class="tabsFooter">
					<div class="tabsFooterContent"></div>
				</div>
			</div>

		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>

