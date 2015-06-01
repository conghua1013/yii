<form id="pagerForm" method="post" action="manage/brand/index">
	<input type="hidden" name="brand_name" value="<?php isset($request['brand_name']) ? $request['brand_name'] : ''; ?>" />
	<input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
	<input type="hidden" name="numPerPage" value="${model.numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField }" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection }" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="manage/brand/index" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					品牌名称：<input type="text" name="brand_name" value="<?php isset($request['brand_name']) ? $request['brand_name'] : ''; ?>" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				<li><a class="button" href="manage/brand/index" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="manage/brand/add" target="navTab" title="品牌添加"><span>添加</span></a></li>
			<li class="line">line</li>
			<li><a class="delete" href="manage/brand/del?id={sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li class="line">line</li>
			<li><a class="edit" href="manage/brand/edit?id={sid_user}" target="navTab" title="品牌修改"><span>修改</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30" orderField="id">ID</th>
				<th width="120">品牌名称</th>
				<th width="120">品牌英文名</th>
				<th width="80">联系地址</th>
				<th width="100">手机</th>
				<th width="150">电话</th>
				<th width="80" align="center">是否展示</th>
				<th width="80">排序</th>
				<th width="100">添加时间</th>
			</tr>
		</thead>
		<tbody>

			<?php if($list): ?>
			<?php foreach($list as $row): ?>
			<tr target="sid_user" rel="<?php echo $row->id; ?>">
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->brand_name; ?></td>
				<td><?php echo $row->english_name; ?></td>
				<td><?php echo $row->address; ?></td>
				<td><?php echo $row->mobile; ?></td>
				<td><?php echo $row->tel; ?></td>
				<td><a class="delete" href="manage/brand/change?id=<?php echo $row->id; ?>&is_show=<?php echo $row->is_show == 0 ?1 : 0; ?>" target="ajaxTodo" title="确定要修改状态吗?">
					<?php if($row->is_show == 1): ?>
						<image  src="/css/dwz/images/accept.png" alt="显示"/>
					<?php else: ?>
						<image  src="/css/dwz/images/error.png" alt="不显示"/>
					<?php endif;?>
				</a></td>
				<td><?php echo $row->sort; ?></td>
				<td><?php echo $row->add_time > 0 ? date('Y-m-d H:i:s') : ''; ?></td>
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

