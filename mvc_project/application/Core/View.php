<?php
namespace application\Core;

class View
{
    public function generate($contentView, $templateView, $data = null)
    {
        include ("application/view/" . $templateView);
    } 
}