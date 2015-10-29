<?php

class Cart extends CActiveRecord
{

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
     * 获取购物车里面的商品
     */
    public function getCartList($userId){
        if(!$userId){
            return '';
        }

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
            $productList = Product::model()->getProductInfoByIds($productIds);
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
                $val['product_name'] .=  '-'.$productAttrs[$val['size_id']]['attr_name'];
            }

            $val['pInfo']            = $product;
            $val['sell_price']      = $product['sell_price'];
            $val['product_sn'] 	  = $product['product_sn'];
            $val['brand_id'] 	      = $product['brandid'];
            $val['img'] 		      = $product['img'];
            $val['weight'] 		  = $product['weight'];
            $val['size'] 		      = $product['size'];
            //$val['shipping'] 	= $product['shipping'];
            //$val['cost'] 		= $product['currentcost'];//当前成本
            //$val['storage'] 	= $product['quantity'];
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
    public function getShippingFee($productAmount){
        if (empty($productAmount)) {
            return 0;
        }
        $config = $this->getShopConfig();
        $freeAmount = isset($config['FREE_SHIPPING_AMOUNT']) ? $config['FREE_SHIPPING_AMOUNT']: 69;
        $shippingFee = isset($config['SHIPPING_FEE']) ? $config['SHIPPING_FEE']: 6;

        $finalShippingFee = 0;	//最终计算后的运费
        if($productAmount < $freeAmount){ //免运费金额和购物车中商品金额比较
            $finalShippingFee = $shippingFee;
        }
        return $finalShippingFee;
    }

    /**
     * 获取商店配置（免运费金额等配置）
     * @return array|bool
     */
    public function getShopConfig(){
        $list = Yii::app()->shop->createCommand()
            ->select('*')
            ->from('bg_shop_config')
            ->queryAll();
        if(empty($list)){return false;}
        $newList = array();
        foreach($list as $row){
            $newList['attribute'] = $row['value'];
        }
        return $newList;
    }




}

