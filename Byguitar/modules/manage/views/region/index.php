<form id="pagerForm" method="post" action="/manage/region/index">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" name="numPerPage" value="{$numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a mask="true" target="dialog" href="manage/region/add" class="add"  width="660" height="430" title="地区添加"><span>添加</span></a></li>
            <li class="line">line</li>
            <li><a class="delete" href="manage/region/del?id={sid_user}" target="ajaxTodo" title="确定要删除支付方式吗?"><span>删除</span></a></li>
            <li class="line">line</li>
            <li><a mask="true" target="dialog" href="manage/region/edit?id={sid_user}" class="add"  width="660" height="430" title="地区修改"><span>修改</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="75">
        <thead>
        <tr>
            <th width="30">ID</th>
            <th width="80">地区名称</th>
            <th width="40">地区编码</th>
            <th width="100">是否可用</th>
            <th width="150">地区级别</th>
            <th width="150">父级id</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->region_name; ?></td>
                    <td><?php echo $row->area_code; ?></td>
                    <td><?php echo $row->is_show; ?></td>
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
