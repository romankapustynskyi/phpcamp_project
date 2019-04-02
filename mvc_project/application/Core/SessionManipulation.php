<?php

namespace application\Core;

class SessionManipulation
{
    public function isArrayInSession($arrayName)
    {
        if (isset($_SESSION[$arrayName])) {
            return true;
        }
        return false;
    }

    public function returnValueFromSessionArrayByKey($arrayName, $key) {
        if (isset($_SESSION[$arrayName][$key])) {
            return $_SESSION[$arrayName][$key];
        }
        return "";
    }

    public function getArrayFromSession($arrayName)
    {
        if($this->isArrayInSession($arrayName))
        {
            return $_SESSION[$arrayName];
        }
        return [];
    }

    public function setArrayInSession($arrayName, $array)
    {
        $_SESSION[$arrayName] = $array;
    }

    public function unsetArrayInSession($arrayName)
    {
        unset($_SESSION[$arrayName]);
    }
}

