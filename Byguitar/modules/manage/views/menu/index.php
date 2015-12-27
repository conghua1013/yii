<form id="pagerForm" method="post" action="manage/menu/index">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="keywords" value="${param.keywords}" />
	<input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
	<input type="hidden" name="numPerPage" value="${model.numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField}" />
</form>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/manage/menu/add" target="navTab" title="菜单添加"><span>添加</span></a></li>
			<li><a class="delete" href="/manage/menu/del?id={sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="/manage/menu/edit?id={sid_user}" target="navTab" title="菜单修改"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="add" href="/manage/menu/tree" target="navTab"><span>菜单树状图</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="75">
		<thead>
			<tr>
				<th width="80"></th>
				<th width="120">链接名称</th>
				<th width="120">短链接</th>
				<th width="100">序号</th>
				<th width="150">页面标示</th>
				<th width="80" align="center">状态</th>
				<th width="80">级别</th>
				<th width="80">父级名称</th>
				<th width="80">操作</th>
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
				<td><?php echo $row->status == 0 ? '不显示' : '显示'; ?></td>
				<td><?php echo $row->level; ?></td>
				<td><?php echo isset($names[$row->parent_id]) ? $names[$row->parent_id]['title'] : '无'; ?></td>
				<td><a class="delete" href="/manage/menu/change?id=<?php echo $row->id; ?>&status=<?php echo $row->status == 0 ?1 : 0; ?>" target="ajaxTodo" title="确定要修改状态吗?">
					<?php if($row->status == 1): ?>
						<image  src="/css/dwz/images/accept.png" alt="显示"/>
					<?php else: ?>
						<image  src="/css/dwz/images/error.png" alt="不显示"/>
					<?php endif;?>
				</a></td>
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

