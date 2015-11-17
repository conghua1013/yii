<form id="pagerForm" method="post" action="/manage/shipping/index">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" name="numPerPage" value="{$numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a mask="true" target="dialog" href="/manage/shipping/add" class="add"  width="660" height="430" title="快递添加"><span>添加</span></a></li>
            <li class="line">line</li>
            <li><a class="delete" href="/manage/shipping/del?id={sid_user}" target="ajaxTodo" title="确定要删除此快递吗?"><span>删除</span></a></li>
            <li class="line">line</li>
            <li><a mask="true" target="dialog" href="/manage/shipping/edit?id={sid_user}" class="add"  width="660" height="430" title="快递修改"><span>修改</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="75">
        <thead>
        <tr>
            <th width="30">ID</th>
            <th width="80">快递名称</th>
            <th width="40">快递费用</th>
            <th width="100">快递编码</th>
            <th width="150">是否可用</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->shipping_name; ?></td>
                    <td><?php echo $row->shipping_fee; ?></td>
                    <td><?php echo $row->shipping_code; ?></td>
                    <td><?php echo $row->is_show; ?></td>
                    <td>
                        <?php if($row['is_show'] == 0): ?>
                            <a title="启用" target="ajaxTodo" href="/manage/payment/changeStatus?id=<?php echo $row['id']; ?>&is_show=1" fresh="true" ><img src="/images/dwz/ok.gif" aSt="显示"  /></a>
                        <?php else: ?>
                            <a title="不启用" target="ajaxTodo" href="/manage/payment/changeStatus?id=<?php echo $row['id']; ?>&is_show=0" fresh="true" ><img src="/images/dwz/del.gif" alt="不显示" /></a>
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
