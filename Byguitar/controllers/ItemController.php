<?php

class ItemController extends ShopBaseController 
{

	public function actionIndex(){
        $product_id = intval($_REQUEST['id']);
        $pInfo = Product::model()->getProductInfoById($product_id);
        if(empty($pInfo)){
            $this->redirect('/');//跳转到首页
        }


        $brandInfo = '';
        if($pInfo['brand_id']){
            $brandInfo = Brand::model()->findByPk($pInfo['brand_id']);
        }
        $stock = Product::model()->getProductStock($product_id,$pInfo['is_multiple']);
        $attrList = ProductAttributes::model()->getProductAttrNameList();

        $extendAttrList = $this->getProductExtendAttrs($product_id);
        $is_like    = $this->getLikeStatus($product_id);
        $cake       = $this->getCakeLine($pInfo['cat_id']); //获取商品的面包屑
        // $sameColors = $this->getSameColorProducts($pInfo['same_color_products']);//同款不同色商品详情

//        echo "<pre>";
//        print_r($pInfo);exit;
//        exit;

        $viewData = array();
        $viewData['pInfo']      = $pInfo;
        $viewData['brandInfo']  = $brandInfo;
        $viewData['is_like']    = $is_like;
        $viewData['cake']       = $cake;
        $viewData['stock']      = $stock;
        $viewData['attrList']      = $attrList;
        $viewData['extendAttrList']  = $extendAttrList;
		$this->render('item/index',$viewData);
	}

    //面包屑
    protected function getCakeLine($catId=0){
        if(empty($catId)){return false;}

        $catList = Category::model()->getCategoryList();

        $lineArr = array();
        $catTwoInfo = $catList[$catId];
        $lineArr['cattwo'] = array('id'=>$catId,'cat_name'=>$catTwoInfo['cat_name']);

        $catOneInfo = $catList[$catTwoInfo['parent_id']];
        $lineArr['catone'] = array('id'=>$catOneInfo['id'],'cat_name'=>$catOneInfo['cat_name']);
        return $lineArr;
    }


    //获取同款商品的列表信息
    protected function getSameColorProducts($ids){
        if(empty($ids)){return false;}
        $idArr = explode(',', $ids);

        $list = array();
        foreach ($idArr as $id) {
            $info = Product::model()->getProductInfo($id);
            if(empty($info)){ continue;}
            $list[$id]['id'] = $info['id'];
            $list[$id]['img'] = $info['img'][0];
        }
        return $list;
    }

    /**
     * 获取商品的扩展属性
     * @param $product_id
     * @return array|bool
     */
    protected function getProductExtendAttrs($product_id){
        if(empty($product_id)){return false;}

        $extendInfo = Product::model()->getProductExtendInfo($product_id);
        $productAttrNameList = Product::model()->getProductExtendAttrList();

        $attrArr = array();
        if(!empty($extendInfo)){
            foreach($productAttrNameList as $k => $v){
                if(empty($extendInfo[$k])){ continue; }
                $temp = array();
                $temp['attr']           = $k;
                $temp['attr_name']      = $productAttrNameList[$k];
                $temp['attr_content']   = $extendInfo[$k];
                array_push($attrArr, $temp);
            }
        }
        return $attrArr;
    }

    //获取商品的喜欢状态
    protected function getLikeStatus($product_id)
    {
        if(empty($product_id)){return false;}
        $user_id = $this->user_id;
        if(empty($user_id)){
            return false;
        }

        $likeInfo = Like::model()->findByAttributes(array('product_id'=>$product_id));
        if(empty($likeInfo)){
            return false;
        }
        return true;
    }

    /**
     * 我喜欢的商品添加数据
     */
    public function addLike(){
        $request = $_REQUEST;
        $request['id'] = intval($request['id']);
        $res = array();
        $userId = $this->userid;
        if (empty($userId)) {
            $res['status']  = 2;
            $res['msg']     = '未登录！';
        }elseif(empty($request['id'])){
            $res['status']  = 0;
            $res['msg']     = '商品id不能为空！';
        }
        if(!empty($res['msg']) && isset($res['msg'])){
            exit(json_encode($res));
        }

        $m = M('Like');
        if($request['action'] == 'droplike'){
            $map = array();
            $map['product_id']  = $request['id'];
            $map['user_id']     = $userId;
            $m->where($map)->delete();
            $res['msg']     = '取消喜欢成功！';
        }else{
            $likeInfo = $m->where('product_id= '.$request['id'])->find();
            if(empty($likeInfo)){
                $m->product_id  = $request['id'];
                $m->user_id     = $userId;
                $m->add_time    = time();
                $m->add();

                //此处商品表的喜欢个数添加1
                $this->product->setInc('like_num', "id = ".$request['id'] , 1);
            }
            $res['msg']     = '喜欢成功！';
        }

        $res['status']  = 1;
        exit(json_encode($res));
    }


    /**
     +
     * 我喜欢的商品添加数据
     +
     */
    public function delLike(){
        $request = $_REQUEST;
        $request['id'] = intval($request['id']);
        $res = array();
        $userId = $this->userid;
        if (empty($userId)) {
            $res['status']  = 2;
            $res['msg']     = '未登录！';
        }elseif(empty($request['id'])){
            $res['status']  = 0;
            $res['msg']     = '商品id不能为空！';
        }
        if(!empty($res['msg']) && isset($res['msg'])){
            exit(json_encode($res));
        }

        $m = M('Like');

        $map = array();
        $map['product_id']  = $request['id'];
        $map['user_id']     = $userId;
        $m->where($map)->delete();
        
        $res['msg']     = '取消喜欢成功！';
        $res['status']  = 1;
        exit(json_encode($res));
    }



    /**
     +
     * 商品评论
     +
     */
    public function addComment(){
        $request = $_REQUEST;
        $request['id'] = intval($request['id']);
        $res = array();
        
        //添加商品评论
        $m = M('Comment');
        try{
            $userId = $this->userid;
            if (empty($userId)) {
                throw new Exception("请登录后再提交", 1);
            }elseif(empty($request['id'])){
                throw new Exception("数据异常，商品id不能为空！", 1);
            }

            $op_id = 0;//第一步查询购买的可以评论的订单商品id
            $map = array();
            $map['a.user_id']       = $userId;
            $map['a.order_status']  = 5;
            $map['b.comment_id']    = 0;
            $map['b.product_id']    = $request['id'];
            
            $opInfo = M('Order a')
                      ->join('bg_order_Product b on a.order_id = b.order_id')
                      ->where($map)
                      ->field('b.*')
                      ->find();

            if(empty($opInfo)){
                throw new Exception("暂时没有可以评价的商品！", 1);
            }

            $m->product_id      = $request['id'];
            $m->op_id           = $opInfo['id'];
            $m->user_id         = $userId;
            $m->content         = $request['comment'];
            $m->comment_score   = 4;
            $m->comment_type    = 1;
            $m->useful_num      = 0;
            $m->add_time        = time();
            $m->is_show         = 1;
            $m->is_del          = 0;
            $comment_id = $m->add();

            $m = M('OrderProduct');
            $data = array('id'=>$opInfo['id'],'comment_id'=>$comment_id);
            $m->save($data);
        }catch(exception $e){
            $res['status']  = 0;
            $res['msg']     = '评论失败【'.$e->getMessage().'】！';
            exit(json_encode($res));
        }

        $res['status']  = 1;
        $res['msg']     = '评论成功！';
        exit(json_encode($res));
     }


     /**
     +
     * 添加商品咨询
     +
     */
    public function addConsultation(){
        $request = $_REQUEST;
        $request['id'] = intval($request['id']);
        $res = array();
        $userId = $this->userid;

        $m = M('Consultation');
        try{
            if (empty($userId)) {
                throw new Exception("请登录后再提交", 1);
            }elseif(empty($request['id'])){
                throw new Exception("数据异常，商品id不能为空！", 1);
            }

            $m->product_id      = $request['id'];
            $m->user_id         = $userId;
            $m->content         = $request['comment'];
            $m->type            = 1;
            $m->useful_num      = 0;
            $m->add_time        = time();
            $m->is_show         = 1;
            $m->is_del          = 0;
            $newid = $m->add();
        }catch(exception $e){
            $res['status']  = 0;
            $res['msg']     = '评论失败【'.$e->getMessage().'】！';
            exit(json_encode($res));
        }

        $res['status']  = 1;
        $res['msg']     = '咨询提交成功！';
        exit(json_encode($res));
     }


    //获取评论分页
    public function getCommentByPage(){
        $request = $_REQUEST;
        $p = isset($request['p']) ? intval($request['p']) : 1;
        $p = max($_REQUEST['p'],1);
        $pageSize = 6;
        $order = 'id desc';
        $limit = ($p-1)*$pageSize.",".$pageSize;

        $map = array();
        $map['is_show'] = 1;
        $map['is_del'] = 0;

        $m = M('Comment');
        $list = $m->where($map)->order($order)->limit($limit)->select();
        $count = $m->where($map)->count();
        return array('list'=>$list,'count'=>$count,'pageSize'=>$pageSize,'p'=>$p);
    }


    //获取资讯分页
    public function getConsultationByPage(){
        $request = $_REQUEST;
        $p = isset($request['p']) ? intval($request['p']) : 1;
        $p = max($_REQUEST['p'],1);
        $pageSize = 6;
        $order = 'id desc';
        $limit = ($p-1)*$pageSize.",".$pageSize;

        $map = array();
        $map['is_show'] = 1;
        $map['is_del'] = 0;

        $m = M('Consultation');
        $list = $m->where($map)->order($order)->limit($limit)->select();
        $count = $m->where($map)->count();
        return array('list'=>$list,'count'=>$count,'pageSize'=>$pageSize,'p'=>$p);
    }


    //手机端接口说明
    public function mobile() {
        $id = intval($_GET['id']);
        if($id <= 0) {
            $error = "商品不存在！";
            $this->ajaxReturn('',$error,1);
        }

        $productKey = 'product_'.$id;
        $productData = $this->MemcacheSmartGet($productKey,300,array($this,'getProductInfo'),array($id));
        unset($productData['pInfo']['detail']);
        if(empty($productData['pInfo'])){
            $error = "商品不存在！";
            $this->ajaxReturn('',$error,1);
        }

        $this->ajaxReturn($productData,'',1);


        // $is_like    = $this->getLikeStatus($id);
        // $this->assign('pInfo',$productData['pInfo']);
        // $this->assign('brandInfo',$productData['brandInfo']);
        // $this->assign('cake',$productData['cake']);
        // $this->assign('sameColors',$productData['sameColors']);
        // $this->assign('attrList',$productData['attrList']);
        // $this->assign('is_like',$is_like);
        // $this->display();
    }

    public function mobile_detail(){
        $id = intval($_REQUEST['id']);
        $info = $this->product->getMobileDetail($id);
        echo $info;
    }


    public function tab(){
        $this->display();
    }


    public function tabImage(){
        if($_REQUEST['flag'] == 1){
            $image = 'Public/Images/public/ad1.jpg';
        }else{
            $image = 'Public/Images/public/554e9c196ff063e12b6cf94520aeb7e3.gif';
        }

        $path_array = pathinfo($image);
        header('Content-Type:image/'.$path_array['extension']);
        echo file_get_contents($image);
    }
}