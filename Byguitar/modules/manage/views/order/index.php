<form id="pagerForm" method="post" action="/manage/order/index">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" name="numPerPage" value="{$numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
</form>


<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="/manage/order/index" method="post">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>订单编号：<input type="text" name="order_sn" /></td>
                    <td>收货人：<input type="text" name="consignee" /></td>
                </tr>
            </table>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                    <li><a class="button" href="/manage/order/index" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="icon" href="/manage/order/info?id={sid_user}" target="navTab" title="查看订单"><span>查看订单</span></a></li>
            <!-- <li class="line">line</li>
            <li><a class="add" href="manage/order/info?id={sid_user}" target="navTab" title="查看订单"><span>查看订单</span></a></li> -->
        </ul>
    </div>
    <table class="table" width="100%" layoutH="138">
        <thead>
        <tr>
            <th width="30"></th>
            <th width="50">订单编号</th>
            <th width="100">订单状态</th>
            <th width="60">客户名称</th>
            <th width="60">客户电话</th>
            <th width="160">客户地址</th>
            <th width="60">商品总金额</th>
            <th width="50">订单运费</th>
            <th width="60">优惠券金额</th>
            <th width="50">订单金额</th>
            <th width="100">下单时间</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->order_sn; ?></td>
                    <td><?php echo Order::model()->getOrderStatus($row->order_status).'-'.Order::model()->getPayStatus($row->pay_status).'-'.Order::model()->getShippingStatus($row->shipping_status); ?></td>
                    <td><?php echo $row->consignee; ?></td>
                    <td><?php echo $row->mobile; ?></td>
                    <td><?php echo $row->address; ?></td>
                    <td><?php echo $row->order_amount; ?></td>
                    <td><?php echo $row->product_amount; ?></td>
                    <td><?php echo $row->shipping_fee; ?></td>
                    <td><?php echo $row->order_amount; ?></td>
                    <td><?php echo $row->add_time > 0 ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
                    <td>
                        <a href="/manage/order/info?id=<?php echo $row->id; ?>" target="navTab" class="edit" title="查看订单性情"><img src="/images/dwz/view.gif" alt="查看订单性情" /></a>

                        <?php if(in_array($row['order_status'],array(1,2))): ?>
                            <a title="审核通过" target="ajaxTodo" href="/manage/order/checkOrder?id=<?php echo $row->id; ?>&status=2" fresh="true" >审</a>
                        <?php endif; ?>

                        <?php if(in_array($row['order_status'],array(0,1))): ?>
                            <a title="取消订单" target="ajaxTodo" href="/manage/order/cancelOrder?id=<?php echo $row->id; ?>" fresh="true" ><img src="/images/dwz/del.gif" alt="取消订单"  /></a>
                        <?php endif; ?>

                        <?php if($row['order_status'] == 5): ?>
                            <a title="确认收货" target="ajaxTodo" href="/manage/order/receiveOrder?id=<?php echo $row->id; ?>" fresh="true" >收</a>
                        <?php endif; ?>

                        <?php if(in_array($row['order_status'],array(1,2,3))): ?>
                            <a title="待发货" target="ajaxTodo" href="/manage/order/prepareOrder?id=<?php echo $row->id; ?>" fresh="true" >备</a>
                        <?php endif; ?>

                        <?php if(in_array($row['order_status'],array(4))): ?>
                            <a title="发货" target="ajaxTodo" href="/manage/order/shippingAndNotifyAlipay?id=<?php echo $row->id; ?>" fresh="true" >发</a>
                        <?php endif; ?>

                        <?php if($row['order_status'] == 6): ?>
                            <a title="关闭订单" target="ajaxTodo" href="/manage/order/closeOrder?id=<?php echo $row->id; ?>" fresh="true" >关</a>
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
