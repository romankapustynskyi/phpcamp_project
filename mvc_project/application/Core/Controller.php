<?php
namespace application\Core;

use application\Components\Request;
use application\Components\Response;
use application\Components\UserAuthentification;


class Controller
{
    protected $view;
    protected $model;
    protected $request;
    protected $response;
    protected $sessionManipulation;
    protected $data;
    protected $userAuthentification;

    public function __construct($modelName)
    {
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->sessionManipulation = new SessionManipulation();
        $this->model = new $modelName;
        $this->userAuthentification = new UserAuthentification();
    }

    public function action_index()
    {
        echo "Hello World";
    }
}