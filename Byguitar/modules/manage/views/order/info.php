<div class="pageContent" style="height:100%;" layoutH="0">
		
	<!-- 订单详细信息 -->
	<div class="ordercontent">
		<table>
			<tr>
				<th colspan="8">订单信息</th>
			</tr>
			<tr>
				<td>订单编号</td>
				<td><?php echo $oInfo->order_sn; ?></td>
				<td>下单时间</td>
				<td><?php echo $oInfo->add_time ? date('Y-m-d H:i:s',$oInfo->add_time) : ''; ?></td>
				<td>商品数量</td>
				<td><?php echo $oInfo->quantity; ?></td>
				<td>订单金额</td>
				<td><?php echo $oInfo->order_amount; ?></td>
			</tr>
			<tr>
				<td>支付方式</td>
				<td><?php echo $oInfo->pay_id; ?></td>
				<td>支付时间</td>
				<td><?php echo $oInfo->pay_time ? date('Y-m-d H:i:s',$oInfo->pay_time) : ''; ?></td>
				<td>支付状态</td>
				<td><?php echo $oInfo->pay_status; ?></td>
				<td>支付金额</td>
				<td><?php echo $oInfo->pay_amount; ?></td>
			</tr>
			<tr>
				<td>支付宝交易号</td>
				<td><?php echo $oInfo->trade_no; ?></td>
				<td>发货时间</td>
				<td><?php echo $oInfo->shipping_time ? date('Y-m-d H:i:s',$oInfo->shipping_time) : ''; ?></td>
				<td>发货单号</td>
				<td><?php echo $oInfo->shipping_sn; ?></td>
				<td>发货状态</td>
				<td><?php echo $oInfo->shipping_status; ?></td>
			</tr>
			<tr>
				<td>订单最后更新时间</td>
				<td><?php echo $oInfo->update_time ? date('Y-m-d H:i:s',$oInfo->update_time) : ''; ?></td>
				<td>收货时间</td>
				<td><?php echo $oInfo->receive_time ? date('Y-m-d H:i:s',$oInfo->receive_time) : ''; ?></td>
				<td>打包时间</td>
				<td><?php echo $oInfo->prepare_time ? date('Y-m-d H:i:s',$oInfo->prepare_time) : ''; ?></td>
				<td>订单状态</td>
				<td><?php echo $oInfo->order_status; ?></td>
			</tr>
			<tr>
				<td>订单备注</td>
				<td colspan="7"><?php echo $oInfo->remark; ?></td>
			</tr>
		</table>
	</div>


	<!-- 发货信息 -->
	<div class="ordercontent">
		<table>
			<tr>
				<th colspan="6">发货信息</th>
			</tr>
			<tr>
				<td colspan="6">
					<a href="/manage/order/sendOrder?id=<?php echo $oInfo->id; ?>" target="dialog" width="600" height="370" title="添加物流信息,普通发货">
						<img src="/css/dwz/images/pencil.png" alt="添加物流信息"/>
					</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="/manage/order/shippingAndNotifyAlipay?id=<?php echo $oInfo->id; ?>" target="dialog" width="600" height="370" title="通知淘宝发货接口">
						发货并通知
					</a>
				</td>
			</tr>
			<tr>
				<td>快递公司</td>
				<td>快递单号</td>
				<td>运费</td>
				<td>重量</td>
				<td>快递备注</td>
				<td>添加时间</td>
			</tr>
			<?php if($oShipping): ?>
			<?php foreach($oShipping as $row): ?>
			<tr>
				<td><?php echo isset($shippingList[$row['shipping_id']]) ? $shippingList[$row['shipping_id']]['shipping_name'] : '未知快递'; ?></td>
				<td><?php echo $row->shipping_sn; ?></td>
				<td><?php echo $row->shipping_fee; ?></td>
				<td><?php echo $row->weight; ?></td>
				<td><?php echo $row->remark; ?></td>
				<td><?php echo $row->add_time ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>

	
	<!-- 客户信息 -->
	<div class=" ordercontent">
		<table>
			<tr>
				<th colspan="3">客户信息</th>
			</tr>
			<tr>
				<td>客户姓名</td>
				<td>客户电话</td>
				<td>客户地址</td>
			</tr>
			<tr>
				<td><?php echo $oInfo->consignee; ?></td>
				<td><?php echo $oInfo->mobile; ?></td>
				<td><?php echo $oInfo->address; ?></td>
			</tr>
		</table>
	</div>

	
	<!-- 订单商品 -->
	<div class=" ordercontent">
		<table>
			<tr>
				<th colspan="9">订单商品信息</th>
			</tr>
			<tr>
				<td>商品编号</td>
				<td>商品名称</td>
				<td>商品类型</td>
				<td>商品品牌</td>
				<td>商品售价</td>
				<td>商品个数</td>
				<td>商品金额小计</td>
				<td>快递公司</td>
				<td>快递单号</td>
			</tr>

			<?php if($opList): ?>
			<?php foreach($opList as $row): ?>
			<tr>
				<td><?php echo $row->product_sn; ?></td>
				<td><?php echo $row->product_name; ?></td>
				<td><?php if($row->type == 1){ echo '谱子'; } elseif ($row->type == 2) { echo '杂志';} else { echo '商品';} ?></td>
				<td><?php echo $row->brand_id; ?></td>
				<td><?php echo $row->sell_price; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->sell_price*$row->quantity; ?></td>
				<td>无</td>
				<td>无</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			
			<tr>
				<th colspan="9">
					商品金额（<?php echo $oInfo->product_amount; ?>）
					+ 运费（<?php echo $oInfo->shipping_fee; ?>）
					- 优惠券金额（<?php echo $oInfo->coupon_amount; ?>）
					= 订单金额（<?php echo $oInfo->order_amount; ?>）
				</th>
			</tr>
		</table>
	</div>

	<!-- 日志信息 -->
	<div class=" ordercontent">
		<table>
			<tr>
				<th colspan="5">订单日志信息</th>
			</tr>
			<tr>
				<td>管理员id</td>
				<td>管理员名称</td>
				<td>手机</td>
				<td>日志信息</td>
				<td>添加时间</td>
			</tr>

			<?php if($oLog): ?>
			<?php foreach($oLog as $row): ?>
			<tr>
				<td><?php echo $row->admin_id ;?></td>
				<td><?php echo $row->admin_name ;?></td>
				<td><?php echo $row->phone ;?></td>
				<td><?php echo $row->msg ;?></td>
				<td><?php echo $row->add_time ? date('Y-m-d H:i:s',$row->add_time) : ''; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>

</div>




<style>
.ordercontent table{
	border-collapse:collapse;
	border-spacing:0;
	border-left:1px solid #888;
	border-top:1px solid #888;
	background:#efefef;
	margin-bottom:10px;
}
.ordercontent th, .ordercontent td{
	border-right:1px solid #888;
	border-bottom:1px solid #888;
	padding:5px 15px;
}
.ordercontent th{
	font-weight:bold;background:#ccc;
}
</style>
