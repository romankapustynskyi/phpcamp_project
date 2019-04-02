<?php

namespace application\Controller;

use application\Core\Controller;

class Controller_Categories extends Controller
{
    public function __construct()
    {
        parent::__construct("\application\Model\Model_Categories");
    }

    public function action_index()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }
        
        $this->data['categories'] = $this->model->selectCategoriesData();
        $this->sessionManipulation->setArrayInSession("categories", $this->data['categories']);

        $this->view->generate("categories_view.php", "template_view.php", $this->data);
    }

    public function action_Add()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['categories'] = $this->sessionManipulation->getArrayFromSession("categories");
        $inputData = null;
        $errors = [
            'category_name' => "",
            'parent' => ""
        ];

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            
            $errors = $this->model->checkValidCategoryData($inputData, $errors, $this->data['categories']);

            if (strlen(implode("", $errors)) == 0) {
                $this->model->insertCategoryData($inputData);
                $this->response->redirect("/mvc_project/categories");
            }
        }

        $this->data['errors'] = $errors;
        $this->data['inputData'] = $inputData;
        $this->view->generate("addCategory_view.php", "template_view.php", $this->data);
    }

    public function action_Edit($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['categories'] = $this->sessionManipulation->getArrayFromSession("categories");
        $errors = [
            'category_name' => "",
            'parent' => ""
        ];

        $this->data['edited'] = $this->model->selectCategoryById($id);

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            
            if (!$this->model->isSomethingChanged($inputData, $this->data['edited'])) {
                $this->response->redirect("/mvc_project/categories");
            }

            $errors = $this->model->checkValidCategoryData($inputData, $errors, $this->data['categories'], $id);

            if (strlen(implode("", $errors)) == 0) {
                $this->model->updateCategoryData($inputData, $this->data['edited']['id']);
                $this->response->redirect("/mvc_project/categories");
            }
        }

        $this->data['errors'] = $errors;
        $this->view->generate("editCategory_view.php", "template_view.php", $this->data);
    }

    public function action_Delete($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $this->data['deleted'] = $this->model->selectCategoryById($id);

        if ($this->request->isIssetPost("yes")) {
            if($this->model->deleteCategoryData($this->data['deleted']['id'])) {
                $this->response->redirect("/mvc_project/categories");
            }
            
        }
        if ($this->request->isIssetPost("no")) {
            $this->response->redirect("/mvc_project/categories");
        }
        

        $this->view->generate("deleteCategory_view.php", "template_view.php", $this->data);
    }
}