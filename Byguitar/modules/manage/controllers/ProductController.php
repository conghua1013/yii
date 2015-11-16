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
        $viewData['numPerPage']   = $list['numPerPage'];
        $viewData['categorys']    = $categorys;
        $viewData['brands']       = $brands;
        $viewData['request']      = $_REQUEST;
		$this->render('index', $viewData);
    }
    
    //商品添加页面 
    public function actionAdd(){
        if(empty($_POST)){
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $productAttributes = ProductAttributes::model()->getProductAttrTree();
            $viewData = array();
            $viewData['categorys'] = $categorys;
            $viewData['brands'] = $brands;
            $viewData['productAttributes'] = $productAttributes;
            $this->render('add',$viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        $transaction = Yii::app()->shop->beginTransaction();
        try{
            $productId = $this->saveProduct(); //保存商品的基本信息
            $this->saveProductCategory($productId); //保存商品的分类信息
            $this->saveProductExtend($productId); //保存商品的扩展信息
            $this->saveProductStock($productId); //保存商品的库存信息
            // $this->saveProductAttr($productId); //保存商品的属性信息

            $transaction->commit();
        } catch(exception $e){
            $transaction->rollback();
            $res['statusCode'] = 500;
            $res['message'] = '添加失败!【'.$e->getMessage().'】';
        }

        $res['navTabId'] = 'productList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/product/index';
        $this->ajaxDwzReturn($res);
    }

    //商品编辑页面
    public function actionEdit(){
        if(empty($_POST)){
            $pInfo = Product::model()->findByPk($_REQUEST['id']);
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $productAttributes = ProductAttributes::model()->getProductAttrTree();
            $pImages = ProductImage::model()->findAllByAttributes(array('product_id'=>$_REQUEST['id']));
            $stocks = ProductStock::model()->findAllByAttributes(array('product_id'=>$_REQUEST['id']));

            $attrList = array();
            foreach($productAttributes as $row){
                if($row['child']){
                    $attrList += $row['child'];
                }
            }

            $viewData = array();
            $viewData['categorys']          = $categorys;
            $viewData['brands']             = $brands;
            $viewData['pInfo']              = $pInfo;
            $viewData['pImages']            = $pImages;
            $viewData['stocks']             = $stocks;
            $viewData['attrList']          = $attrList;
            $viewData['productAttributes']  = $productAttributes;
            $this->render('edit',$viewData);exit;
        }
        $res = array('statusCode' => 200,'message' => '添加成功！');
        $transaction = Yii::app()->shop->beginTransaction();
        try{
            $productId = $this->saveProduct(); //保存商品的基本信息
            $this->saveProductCategory($productId); //保存商品的分类信息
            $this->saveProductExtend($productId); //保存商品的扩展信息
            $this->saveProductStock($productId); //保存商品的库存信息
            // $this->saveProductAttr($productId); //保存商品的属性信息

            $transaction->commit();
        } catch(exception $e){
            $transaction->rollback();
            $res['statusCode'] = 500;
            $res['message'] = '修改失败!【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'productList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/product/index';
        $this->ajaxDwzReturn($res);
    }

    /**
    +
    * 保存商品的基本数据
    +
    */
    protected function saveProduct(){
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $model = Product::model()->findByPk($_REQUEST['id']);
        }else{
            $model = new Product();
            $model->product_sn      = 'BG'.date('Y-m-d').rand(10,99);    //商品名称
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
            throw new exception($error);
        }
        return $model->id;
    }

    //保存商品的分类信息
    protected function saveProductCategory($productId){
        if(empty($_REQUEST['cat_id']) || empty($productId)){ return false;}
        
        $info = Category::model()->findByPk($_REQUEST['cat_id']);
        if(empty($info)){
            throw new exception('该商品分类不存在！');
        }   

        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $model = ProductCategory::model()->findByAttributes(array('product_id'=>$_REQUEST['id']));
            if(empty($info)){
                $model = new ProductCategory();
            }
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
            throw new exception('商品分类信息添加失败！');
        }
        return true;        
    }

    //保存商品的属性信息
    protected function saveProductAttr($productId){
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $res = ProductAttr::model()->deleteByAttributes(array('product_id'=>$_REQUEST['id']));
            if(empty($res)){ 
                throw new exception('商品属性信息删除失败！');
            }
        }

//        foreach($attr_list as $key => $row){
//            $model = new ProductAttr();
//            $message = array();
//            $message['product_id']      = $productId;           //商品id
//            $message['attr_group_id']   = $_REQUEST['attr_id']; //属性的组id
//            $message['attr_id']         = $key;                 //属性id
//            $message['num']             = $attr_stock[$key];    //个数
//            $message['add_time']        = time();               //添加时间
//            $flag = $model->save();
//            if(empty($flag)){
//                $error = '商品属性信息修改失败！';
//                throw new exception($error);
//            }
//        }
        return true;
    }

    //保存商品的库存信息
    protected function saveProductStock($productId){

        //多属性库存保存
        if($_REQUEST['is_multiple'] == 1){
            if($_REQUEST['attr_stock']){

                $temp_ids = array();
                foreach($_REQUEST['attr_stock'] as $attr_id => $row){
                    if(empty($row)){ continue; }
                    $model = ProductStock::model()->findByAttributes(array('product_id' => $productId,'attr_id' => $attr_id));
                    if(empty($model)){
                        $model = new ProductStock();
                    }
                    $model->product_id  = $productId;
                    $model->attr_id     = $attr_id;
                    $model->quantity    = $row;
                    $model->add_time    = time();
                    $model->update_time = time();
                    $flag = $model->save();
                    array_push($temp_ids,$attr_id);
                }

                //todo 删除出了这次保存外的其他数据，防止错误数据存在
                $criteria = new CDbCriteria;
                $criteria->addCondition('product_id='.$productId);
                $criteria->addNotInCondition('attr_id', $temp_ids);
                ProductStock::model()->deleteAll($criteria);
            }
        }else{
            $model = ProductStock::model()->findByAttributes(array('product_id' => $productId));
            if(empty($model)){
                $model = new ProductStock();
            }
            $model->product_id  = $productId;
            $model->attr_id     = 0;
            $model->quantity    = $_REQUEST['quantity'];
            $model->add_time    = time();
            $model->update_time = time();
            $flag = $model->save();

            //todo 删除出了这次保存外的其他数据，防止错误数据存在；
            $criteria = new CDbCriteria;
            $criteria->addCondition('id != '.$model->id);
            $criteria->addCondition('product_id ='.$productId);
            ProductStock::model()->deleteAll($criteria);
        }
        
        return true;
    }

    //保存商品的扩展信息
    protected function saveProductExtend($productId){
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $model = ProductExtend::model()->findByAttributes(array('product_id'=>$_REQUEST['id']));
        }
        if(empty($model)){
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
            throw new exception($error);
        }
        return true;
    }



    //保存商品的图片信息
    public function actionUploadImage(){

        try{
            $status = 200;
            $message = '图片上传成功!';
            $productId = intval($_REQUEST['id']);
            if(empty($productId)){
                throw new exception('商品id不能为空！');
            }
            $data = $imageId = $this->saveProductImage($productId);
        } catch(exception $e){
            $status = 500;
            $message = $e->getMessage();
        }

        $data['status'] = $status;
        $data['errorMsg'] = $message;
        $this->displayJson($data);
    }

    /**
    * 保存商品的图片信息
    */
    protected function saveProductImage($productId){

        $imageConfig = Yii::app()->params['image']['product'];
        if(empty($imageConfig)){
            throw new exception('缺少商品图片配置');
        }

        $image = CUploadedFile::getInstanceByName('Filedata');
        $image_extension = $image->getExtensionName();
        $path = $imageConfig['path'] . date('Ym') . '/';
        $this->createPath($path);
        $imageName = date('YmdHis') . rand(1, 1000);
        $imageNamePath = $path . $imageName . '.' .$image_extension;
        $flag = $image->saveAs($imageNamePath, true);
        if(!$flag){
            throw new exception('原图保存失败！');
        }

        $images_arr = array();
        $image = Yii::app()->image->load($imageNamePath);
        foreach ($imageConfig['sizes'] as $row) {
            $newImagePath = $path . $imageName . '-' . $row . '.' . $image_extension;
            $flag = $image->resize($row, $row)->save($newImagePath);
            if(!$flag){
                throw new exception('图片尺寸'.$row.'生成失败！');
            }
            $images_arr['image_' . $row] = str_replace(ROOT_PATH, '', $newImagePath);
        }

        //图片处理here
        $model = new ProductImage();
        $model->product_id = $productId;
        $model->img = str_replace(ROOT_PATH, '', $imageNamePath);
        $model->add_time = time();
        $flag = $model->save();
        if(!$flag){
            throw new exception('保存记录失败！');
        }

        return array('imgid' => $model->id,'img' => $images_arr);
    }


    public function createPath($dir, $mode = 0755){
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!$this->createPath(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }

    /**
     * 删除商品图库中的图片
     */
    public function actionDeleteImage(){
        try{
            $status = 200;
            $message = '删除成功!';
            $imageId = intval($_REQUEST['id']);
            if(empty($imageId)){
                throw new exception('图片id为空，刷新后重试！');
            }
            $info = ProductImage::model()->findByPk($imageId);
            if(empty($info)){
                throw new exception('图片记录不存在，请刷新后再重试！');
            }
            $imageConfig = Yii::app()->params['image']['product'];
            foreach($imageConfig['sizes'] as $row){
                $path = pathinfo($info->img);
                $temp = explode('.',$path['basename']);
                $tempPath = $path['dirname'].'/'.$temp[0].'-'.$row.'.'.$temp[1];
                @unlink(ROOT_PATH.$tempPath);
            }
            @unlink(ROOT_PATH.$info->img);
            $flag = ProductImage::model()->deleteByPk($imageId);
            if(empty($flag)){
                throw new exception('删除失败，刷新后重试！');
            }
        } catch(exception $e){
            $status = 500;
            $message = '删除失败!【'.$e->getMessage().'】';
        }
        $result['status'] = $status;
        $result['message'] = $message;
        $result['id'] = $imageId;
        $this->displayJson($result);
    }

    /**
     * 线上商品详情页面
     */
    public function actionInfo()
    {
        $info = Product::model()->findByPk($_REQUEST['id']);
        $viewData = array();
        $viewData['info']         = $info;
        $this->render('info', $viewData);
    }

    /**
     * 修改商品的上架状态.
     */
    public function actionGrounding()
    {
        $id = intval($_REQUEST['id']);
        $result = array('statusCode' => 200 ,'message' => '修改成功！');
        try{
            if(empty($id) || !in_array($_REQUEST['status'],array(2,3))){
                throw new exception('参数错误');
            }
            $pInfo = Product::model()->findByPk($id);
            if(empty($pInfo)){
                throw new exception('商品不存在');
            }
            if($pInfo->status != $_REQUEST['status']){
                $pInfo->status = intval($_REQUEST['status']);
                $flag = $pInfo->save();
                if(empty($flag)){
                    throw new exception('修改状态失败！');
                }
            }
        } catch(exception $e){
            $result['statusCode'] = 500;
            $result['message'] = '删除失败!【'.$e->getMessage().'】';
        }
        $result['callbackType'] = 'reloadTab';
        $result['forwardUrl'] = '/manage/product/index';
        $this->displayJson($result);
    }

    /**
     * 修改商品的显示状态
     */
    public function actionShow()
    {
        $id = intval($_REQUEST['id']);
        $result = array('statusCode' => 200 ,'message' => '修改成功！');
        try{
            if(empty($id)){
                throw new exception('参数错误');
            }
            $pInfo = Product::model()->findByPk($id);
            if(empty($pInfo)){
                throw new exception('商品不存在');
            }
            if($pInfo->is_show != $_REQUEST['show']){
                $pInfo->is_show = intval($_REQUEST['show']);
                $flag = $pInfo->save();
                if(empty($flag)){
                    throw new exception('修改状态失败！');
                }
            }
        } catch(exception $e){
            $result['statusCode'] = 500;
            $result['message'] = '删除失败!【'.$e->getMessage().'】';
        }
        $result['callbackType'] = 'reloadTab';
        $result['forwardUrl'] = '/manage/product/index';
        $this->displayJson($result);
    }

    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 start <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
    
    //商品属性树状图
    /**
     +
     * 商品的属性分类树
     +
     */
    public function actionAttrlist(){
        $list = ProductAttributes::model()->getAttrListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $this->render('/productAttr/index', $viewData);
    }

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
            $info = ProductAttributes::model()->findByPk($_REQUEST['id']);
            $select = ProductAttributes::model()->getSelectAttributes();
            
            $viewData = array();
            $viewData['info'] = $info;
            $viewData['select'] = $select;
            $this->render('/productAttr/edit',$viewData);exit;
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

    //商品添加或者修改页面
    public function actionGetProductAttrs(){
        $attr_group_id = intval($_REQUEST['attr_id']);
        $list = ProductAttributes::model()->getProductAttrTree();
        $info = isset($list[$attr_group_id]) ? $list[$attr_group_id]['child'] : '';
        exit(json_encode($info));
    }

    public function actionProductAttrDel(){
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = ProductAttributes::model()->deleteByPk($_REQUEST['id']);
            if($flag){
                $message = '删除成功!';
                $status = 200;
            }else{
                $message = '删除失败!';
                $status = 300;
            }
        }catch(Exception $e){
            $message = $e->getMessage();
            $status = 300;
        }

        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }
    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 end <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
}
