<?php

class ZineController extends ManageController
{

    //列表页面
    public function actionIndex()
    {
        $list = Zine::model()->getZineListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $this->render('index', $viewData);
    }

    //编辑页面
    public function actionAdd()
    {
        if(empty($_POST)){
            $viewData = array();
            $this->render('edit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        try {

            $m =  new Tab();
            $m->name 		= $_REQUEST['name']; //谱子名称
            $m->class 	    = $_REQUEST['class']; //歌曲名称
            $m->scover 			= $_REQUEST['scover']; //专辑id
            $m->mcover 			= $_REQUEST['mcover'];
            $m->bcover 			= $_REQUEST['bcover'];
            $m->content 		= $_REQUEST['content'];
            $m->poptab 		    = $_REQUEST['poptab'];
            $m->solotab 		= $_REQUEST['solotab'];
            $m->views 		    = $_REQUEST['views']; //自建分类
            $m->downs 		    = $_REQUEST['downs'];
            $m->replys 		    = $_REQUEST['replys'];
            $m->date 		    = $_REQUEST['date'];
            $m->editor 		    = $_REQUEST['editor'];
            $m->intro 		    = $_REQUEST['intro'];
            $m->link1 		    = $_REQUEST['link1'];
            $m->link2 		    = $_REQUEST['link2'];
            $m->link3 		    = $_REQUEST['link3'];
            $m->link4 		    = $_REQUEST['link4'];
            $m->veditor 		= $_REQUEST['veditor'];
            $m->peditor 		= $_REQUEST['peditor'];
            $m->team 		    = $_REQUEST['team'];
            $m->taobaolink 	    = $_REQUEST['taobaolink'];
            $m->bbslink 		= $_REQUEST['bbslink'];
            $m->qita 		    = $_REQUEST['qita'];
            $m->market_price    = $_REQUEST['market_price'];
            $m->cost_price 		= $_REQUEST['cost_price'];
            $m->sell_price 		= $_REQUEST['sell_price'];
            $m->quantity 		= $_REQUEST['quantity'];
            $m->virtual_price 	= $_REQUEST['virtual_price'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'zineList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/zine/index';
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Zine::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try {

            $m =  Tab::model()->findByPk($_REQUEST['id']);
            if(empty($m)){
                throw new Exception('该谱子不存在');
            }
            $m->name 		= $_REQUEST['name']; //谱子名称
            $m->class 	    = $_REQUEST['class']; //歌曲名称
            $m->scover 			= $_REQUEST['scover']; //专辑id
            $m->mcover 			= $_REQUEST['mcover'];
            $m->bcover 			= $_REQUEST['bcover'];
            $m->content 		= $_REQUEST['content'];
            $m->poptab 		    = $_REQUEST['poptab'];
            $m->solotab 		= $_REQUEST['solotab'];
            $m->views 		    = $_REQUEST['views']; //自建分类
            $m->downs 		    = $_REQUEST['downs'];
            $m->replys 		    = $_REQUEST['replys'];
            $m->date 		    = $_REQUEST['date'];
            $m->editor 		    = $_REQUEST['editor'];
            $m->intro 		    = $_REQUEST['intro'];
            $m->link1 		    = $_REQUEST['link1'];
            $m->link2 		    = $_REQUEST['link2'];
            $m->link3 		    = $_REQUEST['link3'];
            $m->link4 		    = $_REQUEST['link4'];
            $m->veditor 		= $_REQUEST['veditor'];
            $m->peditor 		= $_REQUEST['peditor'];
            $m->team 		    = $_REQUEST['team'];
            $m->taobaolink 	    = $_REQUEST['taobaolink'];
            $m->bbslink 		= $_REQUEST['bbslink'];
            $m->qita 		    = $_REQUEST['qita'];
            $m->market_price    = $_REQUEST['market_price'];
            $m->cost_price 		= $_REQUEST['cost_price'];
            $m->sell_price 		= $_REQUEST['sell_price'];
            $m->quantity 		= $_REQUEST['quantity'];
            $m->virtual_price 	= $_REQUEST['virtual_price'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'zineList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/zine/index';
        $this->ajaxDwzReturn($res);
    }


    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        $info = Zine::model()->findByPk($_REQUEST['id']);
        try{
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->is_show = $_REQUEST['is_show'];
            $flag = $info->save();
            if(empty($flag)){
                throw new exception('修改状态失败！');
            }
        } catch (Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/zine/index';
        $this->ajaxDwzReturn($res);
    }

}