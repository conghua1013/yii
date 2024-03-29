<form id="pagerForm" method="post" action="/manage/product/index">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="product_name" value="<?php echo isset($request['product_name']) ? $request['product_name'] : ''; ?>" />
	<input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage; ?>" />
	<input type="hidden" name="orderField" value="id" />
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="/manage/product/index" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					商品名称：<input type="text" name="product_name" value="<?php echo isset($request['product_name']) ? $request['product_name'] : ''; ?>"/>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				<li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/manage/product/add" target="navTab" title="商品添加"><span>添加</span></a></li>
			<li><a class="delete" href="/manage/product/del?id={sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="/manage/product/edit?id={sid_user}" target="navTab" title="商品修改"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="/manage/product/info?id={sid_user}" target="navTab" title="查看详情"><span>查看详情</span></a></li>
			<li class="line">line</li>
			<!-- <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="10"></th>
				<th width="120">商品名称</th>
				<th width="100">商品副标题</th>
				<th width="30">分类</th>
				<th width="30">品牌</th>
				<th width="30">售价</th>
				<th width="30">市场价</th>
				<th width="20" align="center">状态</th>
				<th width="80">添加时间</th>
				<th width="80">操作</th>
			</tr>
		</thead>
		<tbody>

			<?php if($list): ?>
			<?php foreach($list as $row): ?>
			<tr target="sid_user" rel="<?php echo $row->id; ?>">
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->product_name; ?></td>
				<td><?php echo $row->subhead; ?></td>
				<td><?php echo !empty($row->category) ? $row->category->cat_name : ''; ?></td>
				<td><?php echo !empty($row->brand) ?  $row->brand->brand_name : ''; ?></td>
				<td><?php echo $row->sell_price; ?></td>
				<td><?php echo $row->market_price; ?></td>
				<td><?php echo Product::model()->getProductStatus($row->status); ?></td>
				<td><?php echo $row->add_time ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
				<td>
					<?php if($row['status'] == 3): ?>
						<a title="上架" target="ajaxTodo" href="/manage/product/grounding?id=<?php echo $row['id']; ?>&status=2" ><img src="/images/dwz/up.gif" alt="上架" /></a>
					<?php else: ?>
						<a title="下架" target="ajaxTodo" href="/manage/product/grounding?id=<?php echo $row['id']; ?>&status=3" ><img src="/images/dwz/down.gif" alt="下架" /></a>
					<?php endif; ?>

					&nbsp;
					<?php if($row['is_show'] == 0): ?>
						<a title="显示" target="ajaxTodo" href="/manage/product/show?id=<?php echo $row['id']; ?>&show=1" fresh="true" ><img src="/images/dwz/ok.gif" aSt="显示"  /></a>
					<?php else: ?>
						<a title="不显示" target="ajaxTodo" href="/manage/product/show?id=<?php echo $row['id']; ?>&show=0" fresh="true" ><img src="/images/dwz/del.gif" alt="不显示" /></a>
					<?php endif; ?>

				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>

		</tbody>
	</table>

	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
				<option value="200">200</option>
			</select>
			<span>条，共<?php echo $count; ?>条</span>
		</div>
		<div class="pagination" targetType="navTab" totalCount="<?php echo $count; ?>" numPerPage="20" pageNumShown="10" currentPage="<?php echo $pageNum; ?>"></div>
	</div>
	
</div>

