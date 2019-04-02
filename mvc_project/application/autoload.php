<?php

function load_class($className) {
    $filePath = $_SERVER['DOCUMENT_ROOT']. "/mvc_project/" . str_replace("\\", "/", $className) . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
        return true;
    }
    return false;
}

spl_autoload_register('load_class');