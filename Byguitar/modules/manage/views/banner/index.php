<form id="pagerForm" method="post" action="manage/banner/index">
    <input type="hidden" name="brand_name" value="<?php isset($request['brand_name']) ? $request['brand_name'] : ''; ?>" />
    <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="manage/banner/add" target="navTab" title="banner添加"><span>添加</span></a></li>
            <li class="line">line</li>
            <li><a class="delete" href="manage/banner/del?id={sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
            <li class="line">line</li>
            <li><a class="edit" href="manage/banner/edit?id={sid_user}" target="navTab" title="banner修改"><span>修改</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="75">
        <thead>
        <tr>
            <th width="30"></th>
            <th width="120">标题</th>
            <th width="120">位置</th>
            <th width="80">链接</th>
            <th width="80">开始时间</th>
            <th width="80">结束时间</th>
            <th width="30" align="center">是否展示</th>
            <th width="80">排序</th>
            <th width="80">添加时间</th>
        </tr>
        </thead>
        <tbody>

        <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->title; ?></td>
                    <td><?php echo $row->station; ?></td>
                    <td><?php echo $row->link; ?></td>
                    <td><?php echo $row->add_time > 0 ? date('Y-m-d H:i:s',$row->start_time) : ''; ?></td>
                    <td><?php echo $row->add_time > 0 ? date('Y-m-d H:i:s',$row->end_time) : ''; ?></td>
                    <td><a class="delete" href="manage/banner/change?id=<?php echo $row->id; ?>&is_show=<?php echo $row->is_show == 0 ?1 : 0; ?>" target="ajaxTodo" title="确定要修改状态吗?">
                            <?php if($row->is_show == 1): ?>
                                <image  src="/css/dwz/images/accept.png" alt="显示"/>
                            <?php else: ?>
                                <image  src="/css/dwz/images/error.png" alt="不显示"/>
                            <?php endif;?>
                        </a></td>
                    <td><?php echo $row->sort; ?></td>
                    <td><?php echo $row->add_time > 0 ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
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

