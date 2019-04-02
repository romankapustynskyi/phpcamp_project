<?php

namespace application\Components;

class Request
{
    public $postData;
    private $_method;

    public function __construct()
    {
        $this->_setMethod();
        $this->_setPostData();
    }

    private function _trimData($data)
    {
        foreach ($data as $key => $item) {
            $data[$key] = trim($item);
        }
        return $data;
    }

    public function checkMethod($method)
    {
        return $this->_method == $method;
    }

    private function _setMethod()
    {
        $this->_method = $_SERVER['REQUEST_METHOD'];
    }

    private function _setPostData()
    {
        $this->postData = $this->_trimData($_POST);
    }

    public function isIssetPost($value)
    {
        return isset($_POST[$value]);
    }
}

