<?php

class TabController extends ManageController
{

    //列表页面
    public function actionIndex()
    {
        $list = Tab::model()->getTabListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $this->render('index', $viewData);
    }

    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Tab::model()->findByPk($_REQUEST['id']);
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
            //$m->sid 		    = $_REQUEST['sid'];    //歌名id
            $m->tabname 		= $_REQUEST['tabname']; //谱子名称
            $m->songname 	    = $_REQUEST['songname']; //歌曲名称
            //$m->gid 		    = $_REQUEST['gid'];     //歌手id
            $m->singer 		    = $_REQUEST['singer'];
            //$m->aid 			= $_REQUEST['aid']; //专辑id
            $m->album 			= $_REQUEST['album'];
            $m->type 			= $_REQUEST['type'];
            $m->tabfile 		= $_REQUEST['tabfile'];
            $m->author 		    = $_REQUEST['author'];
            //$m->oid 	        = $_REQUEST['oid'];
            $m->owner 			= $_REQUEST['owner'];
            $m->ownerclass 		= $_REQUEST['ownerclass']; //自建分类
            $m->nandu 		    = $_REQUEST['nandu'];
            $m->class 		    = $_REQUEST['class'];
            //$m->date 		    = $_REQUEST['date'];
            //$m->downs 		    = $_REQUEST['downs'];
            //$m->views 		    = $_REQUEST['views'];
            $m->ispass 		    = $_REQUEST['ispass'];
            $m->isbest 		    = $_REQUEST['isbest'];
            //$m->shares 		    = $_REQUEST['shares'];
            //$m->sharedate 		= $_REQUEST['sharedate'];
            $m->paisu 		    = $_REQUEST['paisu'];
            $m->paizi 		    = $_REQUEST['paizi'];
            $m->diaoshi 		= $_REQUEST['diaoshi'];
            $m->biandiaojia 	= $_REQUEST['biandiaojia'];
            $m->is_double 		= $_REQUEST['is_double'];
            $m->video_url 		= $_REQUEST['video_url'];
            $m->audio_url 		= $_REQUEST['audio_url'];
            $m->play_notice 	= $_REQUEST['play_notice'];
            //$m->praise 		    = $_REQUEST['praise'];
            $m->market_price 	= $_REQUEST['market_price'];
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
        $res['navTabId'] = 'bannerList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/tab/index';
        $this->ajaxDwzReturn($res);
    }


    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        $info = Tab::model()->findByPk($_REQUEST['id']);
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
        $res['forwardUrl'] = '/manage/tab/index';
        $this->ajaxDwzReturn($res);
    }

}