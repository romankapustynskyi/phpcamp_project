<?php

namespace application\Controller;

use application\Core\Controller;

class Controller_Products extends Controller
{
    public function __construct()
    {
        parent::__construct("\application\Model\Model_Products");
    }

    public function action_index()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }
        
        $this->data['products'] = $this->model->selectProductsData();
        $this->data['categories'] = $this->model->selectCategoriesData();
        $this->sessionManipulation->setArrayInSession("products", $this->data['products']);
        $this->sessionManipulation->setArrayInSession("categories", $this->data['categories']);

        $this->view->generate("products_view.php", "template_view.php", $this->data);
    }

    public function action_Add()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['products'] = $this->sessionManipulation->getArrayFromSession("products");
        $this->data['categories'] = $this->sessionManipulation->getArrayFromSession("categories");
        $inputData = null;
        $errors = [
            'product_name' => "",
            'sku' => "",
            'qty' => "",
            'price' => "",
            'category_id' => "",
            'image' => "",
            'description' => ""
        ];

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            $errors = $this->model->checkValidProductData($inputData, $errors, $this->data['products'], $this->data['categories']);

            if (strlen(implode("", $errors)) == 0) {
                $this->model->prepareInsertProductData($inputData);
                $this->response->redirect("/mvc_project/products");
            }
        }

        $this->data['errors'] = $errors;
        $this->data['inputData'] = $inputData;
        $this->view->generate("addProduct_view.php", "template_view.php", $this->data);
    }

    public function action_Edit($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['products'] = $this->sessionManipulation->getArrayFromSession("products");
        $this->data['categories'] = $this->sessionManipulation->getArrayFromSession("categories");
        $errors = [
            'product_name' => "",
            'sku' => "",
            'qty' => "",
            'price' => "",
            'category_id' => "",
            'image' => "",
            'description' => ""
        ];

        $this->data['edited'] = $this->model->selectProductDataById($id);

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            
            if (!$this->model->isSomethingChanged($inputData, $this->data['edited'])) {
                $this->response->redirect("/mvc_project/products");
            }

            $errors = $this->model->checkValidProductData($inputData, $errors, $this->data['products'], $this->data['categories'], $id);

            if (strlen(implode("", $errors)) == 0) {
                $filePath = "././" .IMAGES_PATH .$this->data['edited']['image'];
                $this->model->prepareUpdateProductData($inputData, $filePath, $id);
                $this->response->redirect("/mvc_project/products");
            }
        }

        $this->data['errors'] = $errors;
        $this->view->generate("editProduct_view.php", "template_view.php", $this->data);
    }

    public function action_Delete($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['deleted'] = $this->model->selectProductDataById($id);
        if ($this->request->isIssetPost("yes")) {
            $filePath = "././" .IMAGES_PATH .$this->data['deleted']['image'];
            if($this->model->prepareDeleteProductData($filePath, $id)) {
                $this->response->redirect("/mvc_project/products");
            }            
        }
        if ($this->request->isIssetPost("no")) {
            $this->response->redirect("/mvc_project/products");
        }
        

        $this->view->generate("deleteProduct_view.php", "template_view.php", $this->data);
    }
}