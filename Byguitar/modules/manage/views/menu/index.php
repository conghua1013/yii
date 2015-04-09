<form id="pagerForm" method="post" action="manage/menu/index">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="keywords" value="${param.keywords}" />
	<input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
	<input type="hidden" name="numPerPage" value="${model.numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField}" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="manage/menu/index" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					我的客户：<input type="text" name="keyword" />
				</td>
				<td>
					<select class="combox" name="province">
						<option value="">所有省市</option>
						<option value="北京">北京</option>
						<option value="上海">上海</option>
						<option value="天津">天津</option>
						<option value="重庆">重庆</option>
						<option value="广东">广东</option>
					</select>
				</td>
				<td>
					建档日期：<input type="text" class="date" readonly="true" />
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
			<li><a class="add" href="manage/menu/add" target="navTab"><span>添加</span></a></li>
			<li><a class="delete" href="manage/menu/del?id={sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="manage/menu/edit?id={sid_user}" target="navTab"><span>修改</span></a></li>
			<!-- <li class="line">line</li> -->
			<!-- <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="80"></th>
				<th width="120">链接名称</th>
				<th>短链接</th>
				<th width="100">序号</th>
				<th width="150">页面标示</th>
				<th width="80" align="center">状态</th>
				<th width="80">级别</th>
				<th width="80">父级名称</th>
			</tr>
		</thead>
		<tbody>

			<?php if($list): ?>
			<?php foreach($list as $row): ?>
			<tr target="sid_user" rel="<?php echo $row->id; ?>">
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><?php echo $row->url; ?></td>
				<td><?php echo $row->sort; ?></td>
				<td><?php echo $row->page_sign; ?></td>
				<td><?php echo $row->status; ?></td>
				<td><?php echo $row->level; ?></td>
				<td><?php echo $row->parent_id; ?></td>
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

