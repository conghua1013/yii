<form id="pagerForm" method="post" action="/manage/shopconfig/index">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" name="numPerPage" value="{$numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a mask="true" target="dialog" href="manage/shopconfig/add" class="add"  width="660" height="430" title="配置添加"><span>添加</span></a></li>
            <li class="line">line</li>
            <li><a class="delete" href="manage/shopconfig/del?id={sid_user}" target="ajaxTodo" title="确定要配置吗?"><span>删除</span></a></li>
            <li class="line">line</li>
            <li><a mask="true" target="dialog" href="manage/shopconfig/edit?id={sid_user}" class="add"  width="660" height="430" title="配置修改"><span>修改</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="75">
        <thead>
        <tr>
            <th width="30">ID</th>
            <th width="80">配置名称</th>
            <th width="40">配置属性名称</th>
            <th width="100">配置值</th>
            <th width="150">添加时间</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->attribute_name; ?></td>
                    <td><?php echo $row->attribute; ?></td>
                    <td><?php echo $row->value; ?></td>
                    <td><?php echo $row->add_time; ?></td>
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
