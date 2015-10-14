<form id="pagerForm" method="post" action="/manage/coupon/typeindex">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="{$pageNum}" />
    <input type="hidden" name="numPerPage" value="{$numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>


<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="/manage/coupon/typeindex" method="post">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        优惠券名称：<input type="text" name="coupon_name" />
                    </td>
                </tr>
            </table>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                    <li><a class="button" href="/manage/coupon/typeindex" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li class=""><a mask="true" target="dialog" href="/manage/coupon/typeadd" class="add"  width="660" height="430"><span>优惠券添加</span></a></li>
            <li class="line">line</li>
            <li><a class="delete" href="/manage/coupon/typedel?id={sid_user}" target="ajaxTodo" title="确定要删除优惠券吗?"><span>删除</span></a></li>
            <li class="line">line</li>
            <li class=""><a mask="true" target="dialog" href="/manage/coupon/typeedit?id={sid_user}" class="add"  width="660" height="430"><span>优惠券修改</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="138">
        <thead>
        <tr>
            <th width="30"></th>
            <th width="80">优惠券名称</th>
            <th width="40">优惠券类型</th>
            <th width="100">优惠券编号</th>
            <th width="150">优惠券面值</th>
            <th width="150">满足金额</th>
            <th width="80">开始时间</th>
            <th width="80">结束时间</th>
            <th width="80">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->coupon_name; ?></td>
                    <td><?php echo $row->coupon_type; ?></td>
                    <td><?php echo $row->coupon_sn; ?></td>
                    <td><?php echo $row->coupon_amount; ?></td>
                    <td><?php echo $row->satisfied_amount; ?></td>
                    <td><?php echo $row->start_time > 0 ? date('Y-m-d H:i:s',$row->start_time) : ''; ?></td>
                    <td><?php echo $row->end_time > 0 ? date('Y-m-d H:i:s',$row->end_time) : ''; ?></td>
                    <td>
                        <?php if($row->coupon_type == 1): ?>
                            <a mask="true" target="dialog" href="/manage/coupon/makeCoupon?id=<?php echo $row->id;?>" class="add"  width="660" height="430"><span>生产</span></a>
                        <?php endif ; ?>
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

        <div class="pagination" targetType="navTab" totalCount="{$totalCount}" numPerPage="{$numPerPage}" pageNumShown="10" currentPage="{$pageNum}"></div>

    </div>
</div>
