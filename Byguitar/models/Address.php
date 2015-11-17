<?php

/**
 * 用户登录相关的hr.
 * @author mwq2020 <mwq2020@163.com>
 */
class Address extends CActiveRecord
{

    //选择数据库
    public function getDbConnection() {
        return Yii::app()->shop;
    }

    //单例模式
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    //表名、全名
    public function tableName()
    {
        return 'bg_address';
    }

    /**
     * 根据用户id获取用户的地址信息列表数组.
     * @param $userId
     * @return array|bool
     */
    public function getUserAddressList($userId)
    {
        $map = array();
        $map['user_id'] = $userId;
        $list = Address::model()->findAllByAttributes($map);
        if(empty($list)){return false;}
        $newList = array();
        $is_default = false;
        $first_key = 0;
        foreach ($list as $val) {
            $temp = $val->getAttributes();
            if($temp['is_default'] && $is_default == false){
                $is_default = true;
            }else{
                $temp['is_default'] = 0;
            }

            if(!$first_key){
                $first_key = $temp['id'];
            }

            $ids = array();
            $ids[] = intval($val['province']);
            $ids[] = intval($val['city']);
            $ids[] = intval($val['district']);

            $map = array();
            $map['id'] = $ids;
            $addList = Region::model()->findAllByAttributes($map);

            if(empty($addList)){ continue;}
            $regionList = array();
            foreach($addList as $row){
                $regionList[$row['id']] = $row->getAttributes();
            }

            $temp['province_name'] = isset($regionList[$val['province']]) ? $regionList[$val['province']]['region_name'] : '';
            $temp['city_name'] = isset($regionList[$val['city']]) ? $regionList[$val['city']]['region_name'] : '';
            $temp['district_name'] = isset($regionList[$val['district']]) ? $regionList[$val['district']]['region_name'] : '';
            $newList[$val->id] = $temp;
        }
        if($is_default == false && !$first_key){
            $newList[$first_key]['is_default'] = 1;
        }
        return $newList;
    }

    /**
     * 删除收货地址.
     * @param $userId
     * @param $address_id
     * @return bool
     * @throws CDbException
     * @throws exception
     */
    public function delAddress($userId,$address_id)
    {
        if(empty($address_id)){
            throw new exception('传入数据异常！');
        }elseif(empty($userId)){
            throw new exception('数据异常！',2);
        }
        $info = Address::model()->findByPk($address_id);
        if(empty($info)){
            throw new exception('地址不存在！');
        }elseif($info['user_id'] != $userId){
            throw new exception('数据不匹配！');
        }
        $flag = $info->delete();
        if(!$flag){
            throw new exception('删除失败！');
        }
        return true;
    }

    /**
     * 设置默认收货地址
     * @param $userId
     * @param $address_id
     * @return bool
     * @throws exception
     */
    public function setDefaultAddress($userId,$address_id)
    {
        if(empty($address_id)){
            throw new exception('传入数据异常！');
        }elseif(empty($userId)){
            throw new exception('数据异常！',2);
        }
        $info = Address::model()->findByPk($address_id);
        if(empty($info)){
            throw new exception('地址不存在！');
        }elseif($info['user_id'] != $userId){
            throw new exception('数据不匹配！');
        }
        $info->is_default = 1;
        $flag = $info->save();
        if(!$flag){
            throw new exception('设置失败！');
        }

        $sql = 'update bg_address set is_default= 0 where user_id = '.$userId.' and id != '.$address_id;
        Yii::app()->shop->createCommand($sql)->query();
        return true;
    }

    public function saveAddressInfo($userId,$request)
    {
        $id = $request['id'];
        $m = new Address();
        if(!empty($id)){
            $m = Address::model()->findByPk($id);
            if(empty($m)){
                throw new exception('编辑的收货地址不存在！',500);
            }
        }else{
            $m->user_id 	= $userId;
        }
        $m->consignee 	= $request['usname'];
        $m->province 	= $request['usprovince'];
        $m->city 		= $request['uscity'];
        $m->district 	= $request['usdistrict'];
        $m->address 	= $request['usaddr'];
        $m->mobile 		= $request['usmob'];
        $m->is_default 	= 0;

        if(empty($id)){
            $m->add_time 	= time();
            $flag = $m->save();
            if(empty($flag)){
                throw new exception('新增收货地址失败！',500);
            }
            //$this->saveUserLastAddressDefault($addid);
        }else{
            $m->update_time = $_REQUEST['update_time'];
            $flag = $m->save();
            if(empty($flag)){
                throw new exception('修改收货地址失败！',500);
            }
        }
        $addid = $m->id;
        return $addid;
    }

    /**
     * 保存用户的最后地址信息为默认信息
     * @param $userId
     * @param $add_id
     * @return bool
     */
    public function saveUserLastAddressDefault($userId,$add_id)
    {
        if(empty($add_id) || empty($userId)){return false;}

        $info = Address::model()->findByPk($add_id);
        if($info && $info->is_default != 1){
            $info->is_default = 1;
            $info->save();
        }
        $sql = 'update bg_address set is_default= 0 where user_id = '.$userId.' and id != '.$add_id;
        Yii::app()->shop->createCommand($sql)->query();
        return true;
    }
}
