<?php

// this file must be stored in: 
// protected/components/WebUser.php 

class WebUser extends CWebUser {

    // Store model to not repeat query.
    private $_model;

    // Return first name.
    function getFirst_Name(){
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->first_name;
    }

    // This is a function that checks the field 'role'
    function isAdmin(){
        $user = $this->loadUser(Yii::app()->user->id);
        return intval($user->role) == 1;
    }

    // Load user model.
    protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=User::model()->findByPk($id);
        }
        return $this->_model;
    }

}