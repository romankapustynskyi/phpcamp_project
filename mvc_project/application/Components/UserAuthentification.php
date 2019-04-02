<?php

namespace application\Components;

use application\Core\SessionManipulation;
use application\Model\Model_Users;

class UserAuthentification
{
    public $idLoggedUser;
    private $_sessionManipulation;
    private $_usersModel;

    public function __construct()
    {
        $this->_sessionManipulation = new SessionManipulation();
        $this->_usersModel = new Model_Users();
    }

    public function logIn($inputData)
    {
        $userInfo = $this->_usersModel->selectLoginData($inputData['login'], $inputData['password']);

        if($userInfo) {
            unset($userInfo['password']);
            $this->_sessionManipulation->setArrayInSession("loggedUser", $userInfo);
            return "";
        }else {
            return "Wrong login or password";
        }
    }
    
    public function getLoggedUserData()
    {
        return $this->_sessionManipulation->getArrayFromSession("loggedUser");
    }
    
    public function logout()
    {
        if ($this->isLoggedUserAdmin()) {
            $this->_sessionManipulation->unsetArrayInSession("categories");
            $this->_sessionManipulation->unsetArrayInSession("products");
        }

        $this->_sessionManipulation->unsetArrayInSession("loggedUser");
    }
    
    public function isIssetLoggedUser()
    {
        return $this->_sessionManipulation->isArrayInSession("loggedUser");
    }

    public function isLoggedUserAdmin()
    {
        if($this->_sessionManipulation->returnValueFromSessionArrayByKey("loggedUser", "login") == ADMIN_NAME) {
            return true;
        }
        return false;
    }
    
    public function getLoggedUserDataLogin()
    {
        return $this->_sessionManipulation->getArrayFromSession("loggedUser")['login'];
    }

    public function updateLoggedUserData($inputData)
    {
        unset($inputData['send']);
        $this->_sessionManipulation->setArrayInSession("loggedUser", $inputData);
    }
}