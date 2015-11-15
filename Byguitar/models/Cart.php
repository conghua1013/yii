<?php

class Cart extends CActiveRecord
{
    public $product_type =  array('product' => 0,'tab' => 1, 'zine' => 2);

    public function getDbConnection() {
        return Yii::app()->shop;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'bg_cart';
    }

    /**
     * 添加商品到购物车
     * @param $request
     */
    public function addToCart($userId,$request)
    {
        if(empty($request) || empty($request)){
            throw new exception('传输数据错误，请重试');
        }
        if($request['type'] == 'product'){
            $pInfo = Product::model()->findByPk($request['id']);//商品详情
        } elseif($request['type'] == 'tab') {
            $pInfo = Tab::model()->findByPk($request['id']);
        } elseif($request['type'] == 'zine') {
            $pInfo = Zine::model()->findByPk($request['id']);
        }

        //校验数量和所选尺寸等信息
        //查找购物车里面的商品
        $map = array();
        $map['user_id'] 	= $userId;
        $map['product_id'] 	= $request['id'];
        $map['size_id'] 	= $request['size'];
        $map['type'] 		= $this->product_type[$request['type']];
        $cartInfo = Cart::model()->findByAttributes($map);

        $this->addToCartBeforeCheck($request,$pInfo,$cartInfo);

        $time = time();
        if(empty($cartInfo)){
            $cartInfo = new Cart();
            $cartInfo->user_id 		= $userId ;
            $cartInfo->product_id 		= $request['id'];
            $cartInfo->type 			= $this->product_type[$request['type']];
            $cartInfo->size_id 		= $request['size'];
            $cartInfo->shop_price 		= $pInfo['sell_price'];
            $cartInfo->sell_price 		= $pInfo['sell_price'];
            $cartInfo->quantity 		= $request['num'];
            $cartInfo->add_time 		= $time;
            $cartInfo->update_time 	= $time;
            $cartInfo->is_pay 			= isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
            $flag = $cartInfo->save();
        } else {
            //若立即购买的P在购物车中已经存在
            $cartInfo->shop_price 		= $pInfo['sell_price'];
            $cartInfo->sell_price 		= $pInfo['sell_price'];
            $cartInfo->quantity 	+= $request['num'];
            $cartInfo->is_pay       = isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
            $cartInfo->update_time  = $time;
            $flag = $cartInfo->save();
        }

        if(empty($flag)){
            throw new exception('添加购物车失败，请重试！');
        }
        return true;
    }

    /**
     * 添加购物车前，检查商品是否有误 todo 0元单的问题怎么处理
     * @param $request
     * @param $pInfo
     * @return bool
     * @throws exception
     */
    protected function addToCartBeforeCheck($request,$pInfo,$cartInfo)
    {
        if(empty($pInfo)){ throw new exception('商品出现错误！'); }
        $buyNum = $request['num'] + ($cartInfo ? $cartInfo->quantity : 0);

        if ($request['type'] == 'tab' || $request['type'] == 'zine') {

            if($request['type'] == 'tab'){
                $productName = '谱子【'.$pInfo['tabname'].'】';
            } else {
                $productName = '杂志【'.$pInfo['name'].'】';
            }
            if($pInfo['sell_price'] <= 0){
                throw new exception('该'.$productName.'不用付费',500);
            } elseif(empty($pInfo['quantity'])) {
                throw new exception('该'.$productName.'已经没有库存了',500);
            } else{
                if($buyNum > $pInfo['quantity']){
                    throw new exception('该'.$productName.'库存不足，添加失败！',500);
                }
            }
        }  else {
            if(empty($pInfo['is_multiple'])){
                $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>0));
                if(empty($stockInfo)){
                    throw new exception('库存错误，请重试！',500);
                } elseif($stockInfo->quantity < $buyNum){
                    throw new exception('库存不足，添加失败！',500);
                }
            } else {
                if(empty($request['size'])){
                    throw new exception('请选择尺寸后再提交！',500);
                }
                $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>$request['size']));
                if(empty($stockInfo)){
                    throw new exception('库存错误，请重试！',500);
                } elseif($stockInfo->quantity < $buyNum) {
                    throw new exception('库存不足，添加失败！',500);
                }
            }
        }
        return true;
    }

    /**
     * 更新购物车商品的数量
     * @param $userId
     * @param $request
     * @param $cartInfo
     */
    public function updateCartNum($userId,$request)
    {
        $cartInfo = Cart::model()->findByPk($request['id']);
        if(empty($cartInfo) || $userId != $cartInfo['user_id']) {
            throw new exception('数据错误！',500);
        }elseif ($request['action'] == 'edit' && empty($request['num'])) {
            throw new exception('商品个数不能为0！');
        } elseif($request['action'] == 'reduse' && $cartInfo['quantity'] <= 1) {
            throw new exception('已经不能再少了！',500);
        }

        if($request['action'] == 'edit'){
            $cartInfo->quantity = $request['num'];
        }elseif($request['action'] == 'reduse'){
            $cartInfo->quantity -= 1;
        }else{
            $cartInfo->quantity += 1;
        }

        if($cartInfo['type'] == '0'){
            $pInfo = Product::model()->findByPk($cartInfo['product_id']);//商品详情
        } elseif($cartInfo['type'] == '1') {
            $pInfo = Tab::model()->findByPk($cartInfo['product_id']);
        } elseif($cartInfo['type'] == '2') {
            $pInfo = Zine::model()->findByPk($cartInfo['product_id']);
        }
        $this->updateCartBeforeCheck($pInfo,$cartInfo);

        $cartInfo->shop_price 		= $pInfo['sell_price'];
        $cartInfo->sell_price 		= $pInfo['sell_price'];
        $flag = $cartInfo->save();
        if(empty($flag)){
            throw new exception('修改失败！');
        }
        return true;
    }

    /**
     * 更新购物车时检查库存等。
     * @param $pInfo
     * @param $cartInfo
     * @return bool
     * @throws exception
     */
    protected function updateCartBeforeCheck($pInfo,$cartInfo)
    {
        if(empty($pInfo)){ throw new exception('商品出现错误！'); }

        if ($cartInfo['type'] == '1' || $cartInfo['type'] == '2') {
            if($cartInfo['type'] == '1'){
                $productName = '谱子【'.$pInfo['tabname'].'】';
            } else {
                $productName = '杂志【'.$pInfo['name'].'】';
            }
            if($pInfo['sell_price'] <= 0){
                throw new exception('该'.$productName.'不用付费',500);
            } elseif(empty($pInfo['quantity'])) {
                throw new exception('该'.$productName.'已经没有库存了',500);
            } else{
                if($cartInfo->quantity > $pInfo['quantity']){
                    throw new exception('该'.$productName.'库存不足，添加失败！',500);
                }
            }
        }  else {
            if(empty($pInfo['is_multiple'])){
                $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>0));
                if(empty($stockInfo)){
                    throw new exception('库存错误，请重试！',500);
                } elseif($stockInfo->quantity < $cartInfo->quantity){
                    throw new exception('库存不足，修改失败！',500);
                }
            } else {
                $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>$cartInfo['size_id']));
                if(empty($stockInfo)){
                    throw new exception('库存错误，请重试！',500);
                } elseif($stockInfo->quantity < $cartInfo->quantity) {
                    throw new exception('库存不足，修改失败！',500);
                }
            }
        }
        return true;
    }

    /**
     * 删除购物车中的商品.
     * @param $userId
     * @param $request
     */
    public function deleteProductFromCart($userId,$request)
    {
        if (empty($request['cid'])) {
            throw new exception('数据错误',500);
        }
        $info = Cart::model()->findByPk($request['cid']);
        if(empty($info)){
            return true;
        }
        if($info->user_id !== $userId){
            throw new exception('数据错误刷新页面重试',500);
        }

        $flag = Cart::model()->deleteByPk($request['cid']);
        if(empty($flag)){
            throw new exception('数据错误刷新页面重试',500);
        }
        return true;
    }


    /**
     * 获取购物车里面的商品
     */
    public function getCartList($userId)
    {
        if(!$userId){ return ''; }

        $map = array();
        $map['user_id'] = $userId ;
        $map['is_pay']  = !empty($ispay) ? $ispay : array(0, 1, 2);		//未结算
        $list = Yii::app()->shop->createCommand()
            ->select('*')
            ->from('bg_cart')
            ->where('user_id = '.$userId)
            ->queryAll();
        if(empty($list)){return false;}

        $productAttrs = ProductAttributes::model()->getProductAttrNameList();
        $tabIds = array();
        $zineIds = array();
        $productIds = array();
        foreach($list as $row){
            if($row['type'] == 1){
                array_push($tabIds, $row['product_id']);
            } elseif($row['type'] == 2){
                array_push($zineIds, $row['product_id']);
            } else {
                array_push($productIds, $row['product_id']);
            }
        }

        //谱子列表
        if($tabIds){
            $tabList = Tab::model()->getTabsInfoByIds($tabIds);
        }
        //杂志列表
        if($zineIds){
            $zineList = Zine::model()->getZineInfoByIds($zineIds);
        }
        //商品列表
        if($productIds){
            $productList = Product::model()->getProductInfoByIds($productIds,'all');
        }

        $total = array();
        foreach($list as &$val){
            //查询商品信息
            if($val['type'] == 1){
                $product = isset($tabList[$val['product_id']]) ? $tabList[$val['product_id']] : '' ;
            } elseif($val['type'] ==2) {
                $product = isset($zineList[$val['product_id']]) ? $zineList[$val['product_id']] : '' ;
            } else {
                $product = isset($productList[$val['product_id']]) ? $productList[$val['product_id']] : '' ;
            }
            if(empty($product)){ continue; }
            $val['product_name'] = $product['product_name'];
            if(!empty($val['size_id']) && !empty($productAttrs[$val['size_id']]) ){
                $val['product_name'] .=  '-'.$productAttrs[$val['size_id']];
            }

            $val['pInfo']       = $product;
            $val['sell_price']  = $product['sell_price'];
            $val['product_sn'] 	= $product['product_sn'];
            $val['brand_id'] 	= $product['brandid'];
            $val['weight'] 		= $product['weight'];
            $val['size'] 	    = $product['size'];
            $val['images']      = $product['images'];
            $val['storage'] 	= $product['quantity']; //总库存
            //$val['shipping'] 	= $product['shipping'];
            //$val['cost'] 		= $product['currentcost'];//当前成本
            //$val['status'] 		= $product['status'];
            //$val['iscoupon'] 	= $product['iscoupon'];
            //$val['isfree'] 		= $product['isfree'];
            $val['total_price']   = $val['quantity'] * $val['sell_price'];  //小计
            $val['total_cost'] 	= $val['quantity'] * $val['cost_price'];  //小计
            $val['quantity'] 	    = $val['quantity'];   //商品个数

            $total['quantity'] 			+= $val['quantity'];//总件数
            $total['product_amount'] 	+= $val['total_price'];//总计
            //$total['total_cost'] 		+= $val['total_cost'];//成本总计
        }

        $total['shipping_fee'] 	= $this->getShippingFee($total['product_amount']);
        $total['coupon_id']		= 0;
        $total['coupon_amount']	= 0;
        $total['reduce_amount']	= 0;
        $total['final_amount'] 	= $total['product_amount']+$total['shipping_fee'];
        return array('list'=> $list, 'total' => $total);
    }

    /**
     * 获取商品的运费
     * @param $product_amount
     */
    public function getShippingFee($productAmount)
    {
        if (empty($productAmount)) {
            return 0;
        }
        $config = ShopConfig::model()->getShopConfig();
        $freeAmount = isset($config['FREE_SHIPPING_AMOUNT']) ? $config['FREE_SHIPPING_AMOUNT']: 69;
        $shippingFee = isset($config['SHIPPING_FEE']) ? $config['SHIPPING_FEE']: 6;

        $finalShippingFee = 0;	//最终计算后的运费
        if($productAmount < $freeAmount){ //免运费金额和购物车中商品金额比较
            $finalShippingFee = $shippingFee;
        }
        return $finalShippingFee;
    }

    /**
     * 整理购物车商品的详情（）
     * @param $product_id
     * @param $type
     */
    public function getCartProductInfoByProductId($product_id,$type)
    {
        if($type == 1){
            $info = Tab::model()->findByPk($product_id)->getAttributes();
        }elseif($type == 2) {
            $info = Zine::model()->findByPk($product_id)->getAttributes();
        } else {
            $info = Product::model()->findByPk($product_id)->getAttributes();
            $stocks = Product::model()->getProductStock($product_id,$info['is_multiple']);

            if($info['is_multiple'] == 1){
                $info['sizeids'] = array();
                $attrList = ProductAttributes::model()->getProductAttrNameList();
                if($stocks){
                    foreach($stocks as $row){
                        $temp = array();
                        $temp['id']         = $row['attr_id'];
                        $temp['quantity']   = $row['quantity'];
                        $temp['attr_name']  = isset($attrList[$row['attr_id']]) ? $attrList[$row['attr_id']] :'';
                        $info['sizes'][$row['attr_id']] = $temp;
                    }
                }
            }else{
                $info['stock'] = $stocks;
            }
        }
        return $info;
    }

    /**
     * 生成订单
     */
    public function createOrder($userId,$request)
    {
        $data = array();
        $cartinfo 	= $this->getCartList($userId); //购物车物品的详细情况
        if(empty($cartinfo) || empty($cartinfo['list'])){
            throw new exception('购物车商品为空，请刷新页面后提交！');
        }
        $cartList = $cartinfo['list'];//购物有车的商品列表

        $couponInfo = Coupon::model()->getAndCheckCouponInfo($userId,$request['couponsn']);	//没有使用优惠券为空 否则为券的详情
        $cartinfo 	= $this->countOrderAmount($cartinfo,$couponInfo);	//计算优惠券和免运费

        $oInfo = $this->saveOrderInfo($userId,$request,$cartinfo);			//保存订单数据
        $this->saveOrderProduct($userId, $oInfo['order_id'], $cartinfo);	//保存订单商品数据
        $this->saveOrderCoupon($oInfo['id'],$couponInfo);	//保存优惠券信息

        $this->deleteBoughtProductData($cartList);	//删除已经生成订单的商品

        $data['orderid'] = $oInfo['order_id'];
        $data['ordersn'] = $oInfo['order_sn'];//返回动态显示订单成功页面信息
        return $data;
    }

    /**
     * 删除购物车剩余的数据 （已经生成订单的数据）
     * @param $cartProductList
     * @return bool
     * @throws exception
     */
    protected function deleteBoughtProductData($cartProductList)
    {
        if(empty($cartProductList)){ throw new exception('购物车商品不能为空！'); }
        $cardIds = array();
        foreach ($cartProductList as $row){
            array_push($cardIds, $row['id']);
        }

        //一次删除所有的商品
        $flag = Cart::model()->deleteByPk($cardIds);
        if(empty($flag)){
            throw new exception('删除已购商品失败！',500);
        }
        return true;
    }

    /**
     * 保存订单信息.
     * @param $cartInfo
     * @return array
     * @throws exception
     */
    protected function saveOrderInfo($userId,$request,$cartInfo)
    {
        $addid = $request['addrid'];
        $addInfo = Address::model()->findByPk($addid);
        if(empty($userId)){
            throw new exception('请登录后再提交订单！');
        }if(empty($addInfo)){
            throw new exception('地址不存在，请添加后再提交订单！');
        }elseif($addInfo['user_id'] != $userId){
            throw new exception('地址异常修改地址后再提交订单！');
        }elseif($addInfo['is_default'] != 1){
            $this->saveUserLastAddressDefault($addInfo['id']);
        }

        $m = new Order();
        $m->order_sn 		= Order::model()->getOrderSn();
        $m->user_id			= $userId;
        $m->order_status	= 0;
        $m->pay_id 			= $request['payid'];
        $m->shipping_fee 	= $cartInfo['total']['shipping_fee'];
        $m->order_amount 	= $cartInfo['total']['final_amount'];
        $m->product_amount 	= $cartInfo['total']['product_amount'];
        $m->quantity 		= $cartInfo['total']['quantity'];
        $m->coupon_id 		= $cartInfo['total']['coupon_id'];
        //$m->coupon_type 	= $cartInfo['total']['coupon_type'];
        $m->coupon_amount   = $cartInfo['total']['coupon_amount'];
        $m->consignee 		= $addInfo['consignee'];
        $m->mobile 		    = $addInfo['mobile'];
        $m->province 		= $addInfo['province'];
        $m->city 			= $addInfo['city'];
        $m->district 		= $addInfo['district'];
        $m->address 		= $addInfo['address'];
        $m->email 			= '';
        $m->remark 		    = $request['remark'];//备注
        $m->cps_msg 		= '';
        $m->source 			= 1;
        $m->add_time 		= time();
        $id = $m->save();

        if(empty($id)){
            throw new exception('订单生成失败！');
        }
        $oInfo = array();
        $oInfo['order_id'] 		= $m->id;
        $oInfo['order_sn'] 	= $m->order_sn;
        return $oInfo;
    }

    /**
     * 保存订单商品信息
     * @param $oid
     * @param $cartinfo
     * @return bool
     * @throws Exception
     */
    protected function saveOrderProduct($userId, $order_id, $cartInfo)
    {
        $list = $cartInfo['list'];

        foreach ($list as  $row) {
            if($row['type'] == 1){
                $pInfo = Tab::model()->findByPk($row['product_id']);
                if(empty($pInfo)){ throw new Exception("谱子不存在！", 500);}
            }elseif($row['type'] == 2){
                $pInfo = Zine::model()->findByPk($row['product_id']);
                if(empty($pInfo)){ throw new Exception("杂志商品不存在！", 500);}
            }else{
                $pInfo = Product::model()->findByPk($row['product_id']);
                if(empty($pInfo)){ throw new Exception("订单商品不存在！", 500);}
            }

            if($row['sell_price'] != $pInfo['sell_price']){
                throw new exception('价格错误，请重试');
            }

            $m = new OrderProduct();
            $m->order_id 	    = $order_id;
            $m->user_id 	    = $userId;
            $m->product_id 	    = $row['product_id'];
            $m->type 	        = $row['type'];
            $m->product_sn 	    = empty($row['type']) ? $pInfo['product_sn'] : '';
            $m->product_name    = empty($row['type']) ? $pInfo['product_name'] : ($row['type'] == 1 ? $pInfo['tabname'] : $pInfo['name']);
            $m->size_id 	    = $row['size_id'];
            $m->brand_id 	    = $row['type'] == 0 ? $pInfo['brand_id'] : 0;
            $m->sell_price 	    = $row['sell_price'];
            $m->quantity 	    = $row['quantity'];
            //$m->shipping_id 	= 0;
            //$m->shipping_code 	= '';
            //$m->shipping_time 	= 0;
            $opid = $m->save();
            if(empty($opid)){
                throw new Exception("订单商品生成失败！", 1);
            }

            $this->updateProductStock($pInfo,$row);//更新商品的库存
        }
        return true;
    }

    protected function updateProductStock($pInfo,$cartInfo)
    {
        if(empty($pInfo)){ throw new Exception("商品信息不能为空！", 1); }
        //谱子的库存检查及操作
        if($cartInfo['type'] == 1){
            if($pInfo['quantity'] < $cartInfo['quantity']){
                throw new Exception("谱子【{$pInfo['tabname']}】库存不足！", 1);
            }
            $pInfo->quantity -= $cartInfo['quantity'];
            $flag = $pInfo->save();
            if(empty($flag)){
                throw new exception('谱子库存更新失败！');
            }
            return true;
        } elseif($cartInfo['type'] == 2){
            if($pInfo < $cartInfo['quantity']){
                throw new Exception("杂志【{$pInfo['name']}】库存不足！", 1);
            }
            $pInfo->quantity -= $cartInfo['quantity'];
            $flag = $pInfo->save();
            if(empty($flag)){
                throw new exception('杂志库存更新失败！');
            }
            return true;
        }

        //商品库存检查
        if(empty($pInfo['is_multiple'])){
            $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>0));
            if(empty($stockInfo)){
                throw new exception('库存异常');
            }
            if($stockInfo['quantity'] < $cartInfo['quantity']){
                throw new Exception("商品【{$pInfo['product_name']}】库存不足！", 1);
            }
            $stockInfo->quantity -= $cartInfo['quantity'];
            $flag = $stockInfo->save();
            if(empty($flag)){
                throw new exception('商品库存更新失败！');
            }
        }else{
            $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$pInfo['id'],'attr_id'=>$cartInfo['size_id']));
            if(empty($stockInfo)){
                throw new Exception("商品【{$pInfo['product_name']}】库存错误！", 1);
            }elseif($stockInfo['quantity'] < $cartInfo['quantity']){
                throw new Exception("商品【{$pInfo['product_name']}】库存不足！", 1);
            }

            $stockInfo->quantity -= $cartInfo['quantity'];
            $flag = $stockInfo->save();
            if(empty($flag)){
                throw new exception('商品库存更新失败！');
            }
        }

        //更新商品总的库存
        $pInfo->quantity -= $cartInfo['quantity'];
        $flag = $pInfo->save();
        if(empty($flag)){
            throw new exception('商品库存更新失败！');
        }

        return true;
    }

    /**
     * 保存优惠券信息
     */
    protected function saveOrderCoupon($order_id,$couponInfo)
    {
        if(empty($couponInfo)){return false;}
        if($couponInfo['type'] == 'B'){return false;} //A（固定券码 暂不保存数据）

        $couponInfo = Coupon::model()->findByAttributes(array('coupon_sn'=>$couponInfo['coupon_sn']));
        if(empty($couponInfo)){
            throw new Exception("优惠券不存在！", 1);
        }
        $couponInfo->order_id 	= $order_id;
        $couponInfo->use_time 	= time();
        $flag = $couponInfo->save();
        if(empty($flag)){
            throw new Exception("优惠券保存失败！", 1);
        }
        return true;
    }

    /**
     * 处理购物车的优惠券和减免等信息
     * @param $cartinfo
     * @param $couponInfo
     * @return mixed
     */
    public function countOrderAmount($cartinfo,$couponInfo)
    {
        $freeAmount = $this->getFreeShippingAmount();//免运费的限额

        //如果有优惠券信息
        if(!empty($couponInfo)){
            if($cartinfo['total']['product_amount'] > $couponInfo['satisfied_amount']){ //如果满足使用条件
                //优惠券的金额大于商品金额 取商品金额、反之取优惠券金额
                if($cartinfo['total']['product_amount']>$couponInfo['coupon_amount']){
                    $cartinfo['total']['coupon_amount'] = $couponInfo['coupon_amount'];
                }else{
                    $cartinfo['total']['coupon_amount'] = $couponInfo['product_amount'];
                }
                $cartinfo['total']['coupon_id'] = isset($couponInfo['coupon_id']) ? $couponInfo['coupon_id'] :$couponInfo['id'];
                $cartinfo['total']['coupon_type'] = isset($couponInfo['coupon_type']) ? $couponInfo['coupon_type'] : 1 ;
            }
        }

        //运费的计算
        if($cartinfo['total']['final_amount'] > $freeAmount ){
            if($cartinfo['total']['final_amount'] < $cartinfo['shipping_fee']){
                $cartinfo['total']['final_amount'] = 0;
            }else{
                $cartinfo['total']['final_amount'] -= $cartinfo['total']['shipping_fee'];
            }
            $cartinfo['total']['shipping_fee'] = 0;
        }

        return $cartinfo;
    }

    /**
     * 获取免运费金额
     */
    public function getFreeShippingAmount()
    {
        $map = array();
        $map['attribute'] = 'FREE_SHIP_AMOUNT';
        $info = ShopConfig::model()->findByAttributes($map);
        if(empty($info)){
            return 200;
        }
        return $info->value;
    }


}

