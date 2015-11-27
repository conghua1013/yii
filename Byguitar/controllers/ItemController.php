<?php

class ItemController extends ShopBaseController 
{

	public function actionIndex()
    {
        $product_id = intval($_REQUEST['id']);
        $pInfo = Product::model()->getProductInfoById($product_id);
        if(empty($pInfo)){
            $this->redirect('/?from=no_goods');//跳转到首页
        }

        $brandInfo = '';
        if($pInfo['brand_id']){
            $brandInfo = Brand::model()->findByPk($pInfo['brand_id']);
        }
        $stock = Product::model()->getProductStock($product_id,$pInfo['is_multiple']);
        $attrList = ProductAttributes::model()->getProductAttrNameList();
        $extendAttrList = ProductExtend::model()->getProductExtendAttrs($product_id);
        $is_like    = Like::model()->getLikeStatus($this->user_id,$product_id);
        $cake       = Category::model()->getCakeLine($pInfo['cat_id']); //获取商品的面包屑

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

    /**
     * 获取同款商品的列表信息
     * @param $ids
     * @return array|bool
     */
    protected function getSameColorProducts($ids)
    {
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
     * 商品评论
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

}