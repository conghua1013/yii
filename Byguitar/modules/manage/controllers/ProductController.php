<?php

class ProductController extends ManageController {

    public function actionIndex(){
        $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
        $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
		$list = Product::model()->getProductList();

        $viewData = array();
		$viewData['list']         = $list['list'];
		$viewData['count']        = $list['count'];
		$viewData['pageNum']      = $list['pageNum'];
        $viewData['categorys']    = $categorys;
        $viewData['brands']       = $brands;
		$this->render('index', $viewData);
    }
    
    //商品添加页面 
    public function actionAdd(){
        if(empty($_POST)){
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $viewData = array();
            $viewData['categorys'] = $categorys;
            $viewData['brands'] = $brands;
            $this->render('add',$viewData);
        }

        try{
            $status = 200;
            $message = '添加成功!';

            $productId = $this->saveProduct(); //保存商品的基本信息
            $this->saveProductCategory($productId); //保存商品的分类信息
            $this->saveProductExtend($productId); //保存商品的扩展信息
            // $this->saveProductAttr($productId); //保存商品的属性信息
            // $this->saveProductStock($productId); //保存商品的库存信息
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }

    //商品编辑页面
    public function actionEdit(){
        if(empty($_POST)){
            $pInfo = Product::model()->findByPk($_REQUEST['id']);
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $viewData = array();
            $viewData['categorys'] = $categorys;
            $viewData['brands'] = $brands;
            $viewData['pInfo'] = $pInfo;
            $this->render('edit',$viewData);
        }

        try{
            $status = 200;
            $message = '添加成功!';
            $productId = $this->saveProduct(); //保存商品的基本信息
            $this->saveProductCategory($productId); //保存商品的分类信息
            $this->saveProductExtend($productId); //保存商品的扩展信息
            // $this->saveProductAttr($productId); //保存商品的属性信息
            // $this->saveProductStock($productId); //保存商品的库存信息
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }


    //保存商品的图片信息
    public function actionProductImage(){

        try{
            $status = 200;
            $message = '添加成功!';
            $productId = intval($_REQUEST['id']);
            if(empty($productId)){
                throw new exception('商品id不能为空！');
            }
            $this->saveProductImage($productId);
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }




    /**
    +
    * 保存商品的基本数据
    +
    */
    protected function saveProduct(){
        if($_REQUEST['id']){
            $model = Product::model()->finfByPk($_REQUEST['id']);
        }else{
            $model = new Product();
        }
        $model->product_name    = $_REQUEST['product_name'];    //商品名称
        $model->subhead         = $_REQUEST['subhead'];         //商品副标题
        $model->brand_id        = $_REQUEST['brand_id'];        //商品品牌id
        $model->cat_id          = $_REQUEST['cat_id'];          //分类id
        $model->keywords        = $_REQUEST['keywords'];        //页面关键字
        $model->describtion     = $_REQUEST['describtion'];     //页面描述
        $model->detail          = $_REQUEST['detail'];          //页面详情
        $model->vedio_url       = $_REQUEST['vedio_url'];       //视频链接
        $model->market_price    = $_REQUEST['market_price'];    //市场价
        $model->sell_price      = $_REQUEST['sell_price'];      //售价
        $model->cost_price      = $_REQUEST['cost_price'];      //成本价
        $model->is_multiple     = $_REQUEST['is_multiple'];     //多sku库存
        $model->quantity        = $_REQUEST['quantity'];        //数量
        $model->same_color_products    = $_REQUEST['same_color_products'];//同款不同色
        $model->add_time        = time();        //添加时间
        $flag = $model->save();
        if(empty($flag)){
            $error = $_REQUEST['id'] ? '修改商品基本失败！' : '添加商品基本失败！';
            throw new exception($error)
        }
        return $model->id;
    }

    //保存商品的分类信息
    protected function saveProductCategory($productId);{
        if(empty($_REQUEST['cat_id']) || empty($productId)){ return false;}
        
        $info = Category::model()->findByPk($_REQUEST['cat_id']);
        if(empty($info)){
            throw new exception('改商品分类不存在！');
        }   

        if($_REQUEST['id']){
            $model = ProductCategory::model()->findByAttributes(array('product_id'=>$_REQUEST['id']));
        } else{
            $model = new ProductCategory();
        }

        if($info['level'] == 1){
            $one_id = $info['id'];
            $two_id = 0;
        }else{
            $one_id = $info['parent_id'];
            $two_id = $info['id'];
        }
        
        $model->product_id = $productId;
        $model->one_id = $one_id;
        $model->two_id = $two_id;
        $model->add_time = time();
        $flag = $model->save();
        if(empty($flag)){
            throw new exception('商品分类信息添加失败！')
        }
        return true;        
    }

    //保存商品的属性信息
    protected function saveProductAttr($productId){

    }

    //保存商品的库存信息
    protected function saveProductStock($productId){
        
    }

    //保存商品的扩展信息
    protected function saveProductExtend($productId){
        if($_REQUEST['id']){
            $model = ProductExtend::model()->findByAttributes(array('product_id'=>$_REQUEST['id']));
        }else{
            $model = new ProductExtend();
        }

        $message = array();
        $message['product_material']   = $_REQUEST['product_material'];     //商品物料
        $message['warranty']           = $_REQUEST['warranty'];             //质保
        $message['product_service']    = $_REQUEST['product_service'];      //服务
        $message['product_size']       = $_REQUEST['product_size'];         //尺寸
        $message['weight']             = $_REQUEST['weight'];               //重量
        $message['make_date']          = $_REQUEST['make_date'];            //生产日期
        $message['use_life']           = $_REQUEST['use_life'];             //保质期
        $message['product_return']     = $_REQUEST['product_return'];       //退换货政策
        $message['product_maintain']   = $_REQUEST['product_maintain'];     //保养说明
        $message['use_notice']         = $_REQUEST['use_notice'];           //使用说明
        $message['product_notice']     = $_REQUEST['product_notice'];       //温馨提示

        $model->product_id          = $productId;
        $model->other_info = serialize($message);
        $flag = $model->save();
        if(empty($flag)){
            $error = $_REQUEST['id'] ? '修改商品扩展信息失败！' : '添加商品扩展信息失败！';
            throw new exception($error)
        }
        return true;
    }

    /**
    +
    * 保存商品的图片信息
    +
    */
    protected function saveProductImage($productId){
        //图片处理here



        $model = new ProductImage();
        $model->product_id  = $productId;
        $model->img         = '';
        $model->add_time    = time();
        $flag = $model->save();
        if(empty($flag)){
            throw new exception('添加商品图片失败！')
        }
        return true;
    }







    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 start <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
    
    //商品属性树状图
    /**
     +
     * 商品的属性分类树
     +
     */
    public function actionProductAttrTree(){
        $tree = ProductAttributes::model()->getProductAttrTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('/productAttr/tree',$viewData);
    }

    //商品属性添加
    public function actionProductAttrAdd(){
        if(empty($_POST)){
            $select = ProductAttributes::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/add',$viewData);
            exit;
        }

        $model = new ProductAttributes();
        $model->parent_id = $_REQUEST['parent_id'];
        $model->attr_name = $_REQUEST['attr_name'];
        $model->add_time = time();
        $flag = $model->save();

        if($flag){
            $status = 200;
            $message = '添加成功!';
        } else {
            $status = 200;
            $message = '添加失败!';
        }

        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }

    /**
     +
     * 商品的属性分类修改
     +
     */
    public function actionProductAttrEdit(){
        if(empty($_POST)){
            $select = ProductAttributes::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/edit',$viewData);
        }

        $model =  ProductAttributes::model()->findByPk($_REQUEST['id']);
        $model->parent_id = $_REQUEST['parent_id'];
        $model->attr_name = $_REQUEST['attr_name'];
        $model->add_time = time();
        $flag = $model->save();

        if($flag){
            $status = 200;
            $message = '修改成功!';
        } else {
            $status = 200;
            $message = '修改失败!';
        }

        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);        
    }
    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 end <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
}
