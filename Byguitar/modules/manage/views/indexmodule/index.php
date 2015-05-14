<form id="pagerForm" method="post" action="/manage/indexModule">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="keywords" value="${param.keywords}" />
	<input type="hidden" name="pageNum" value="{$pageNum}" />
	<input type="hidden" name="numPerPage" value="{$numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField}" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="/manage/indexModule/index" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					标题：<input type="text" name="title" value="<?php echo isset($filter['title']) ? $filter['title'] : ''; ?>"/>
				</td>
				<td>
					推荐策略：
					<select name="type">
						<option value="0">请选择</option>
						<?php if($types): ?>
						<?php foreach($types as $key => $row): ?>
							<option value="<?php echo $key; ?>" 
							<?php if(isset($filter['type']) && $key == $filter['type']){echo "selected";} ?> 
							> <?php echo $row; ?> </option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</td>
				<td>
					开始时间：<input type="text" name="start_time" class="date" readonly="true" value="<?php echo isset($filter['start_time']) ? $filter['start_time'] : '' ?>" />
					结束时间：<input type="text" name="end_time" class="date" readonly="true" value="<?php echo isset($filter['end_time']) ? $filter['end_time'] : '' ?>"/>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				<li><a class="button" href="/manage/indexModule" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li class=""><a target="navTab" href="/manage/indexModule/add" class="add"><span>新增</span></a></li>
			<li class="line">line</li>
			<li><a class="delete" href="/manage/indexModule/delete/id/{sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li class="line">line</li>
			<li><a class="edit" href="/manage/indexModule/edit/id/{sid_user}" target="navTab"><span>修改</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30"></th>
				<th width="120">标题</th>
				<th width="60">模块banner图片</th>
				<th width="60">链接地址</th>
				<th width="60">商品ids</th>
				<th width="90">开始时间</th>
				<th width="90">结束时间</th>
				<th width="40">是否显示</th>
				<th width="30">排序</th>
				<th width="80">添加时间</th>
			</tr>
		</thead>
		<tbody>

			<?php if($list): ?>
			<?php foreach($list as $key => $row): ?>
			<tr target="sid_user" rel="<?php echo $row->id; ?>">
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><?php echo $row->img; ?></td>
				<td><a href="<?php echo $row->link; ?>">点击进入网址</a></td>
				<td><?php echo $row->product_ids; ?></td>
				<td><?php echo $row->start_time ? date('Y-m-d H:i:s',$row->start_time) : ''; ?></td>
				<td><?php echo $row->end_time ? date('Y-m-d H:i:s',$row->end_time) : ''; ?></td>
				<td><?php echo $row->is_show; ?></td>
				<td><?php echo $row->sort; ?></td>
				<td><?php echo $row->add_time ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
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
