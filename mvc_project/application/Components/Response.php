<?php

namespace application\Components;

class Response
{
    public function redirect($url)
    {
        header("location: " . $url);
        exit;
    }
}

