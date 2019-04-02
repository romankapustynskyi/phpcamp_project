<?php

namespace application\Controller;

use application\Core\Controller;

class Controller_Customers extends Controller
{
    public function __construct()
    {
        parent::__construct("\application\Model\Model_Customers");
    }

    public function action_index()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }
        
        $this->data['customers'] = $this->model->selectCustomersData();

        $this->view->generate("customers_view.php", "template_view.php", $this->data);
    }

    public function action_Add()
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $inputData = null;
        $errors = [
            'login' => "",
            'password' => "",
            'confirm_password' => "",
            'email' => "",
            'firstname' => "",
            'lastname' => "",
            'phone' => "",
            'age' => "",
            'sex' => ""
        ];

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            $errors = $this->model->checkValidAddData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                $inputData['password'] = sha1($inputData['password']);
                $this->model->insertCustomerData($inputData);
                $this->response->redirect("/mvc_project/customers");
            }
        }

        $this->data['errors'] = $errors;
        $this->data['inputData'] = $inputData;
        $this->view->generate("addCustomer_view.php", "template_view.php", $this->data);
    }

    public function action_Edit($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $errors = [
            'general' => "",
            'login' => "",
            'password' => "",
            'confirm_password' => "",
            'email' => "",
            'firstname' => "",
            'lastname' => "",
            'phone' => "",
            'age' => "",
            'sex' => ""
        ];

        $this->data['edited'] = $this->model->selectCustomerDataById($id);

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            
            if (!$this->model->isSomethingChanged($inputData, $this->data['edited'], "user")) {
                $this->response->redirect("/mvc_project/customers");
            }

            $errors = $this->model->checkValidEditData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                $this->model->updateCustomerData($inputData, $id);
                $this->response->redirect("/mvc_project/customers");
            }
        }

        $this->data['errors'] = $errors;
        $this->view->generate("editCustomer_view.php", "template_view.php", $this->data);
    }

    public function action_Delete($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/customers");
        }

        $this->data['deleted'] = $this->model->selectCustomerDataById($id);
        
        if ($this->request->isIssetPost("yes")) {
            if($this->model->deleteCustomerData($id)) {
                if ($this->data['deleted']['login'] == "admin") {
                    $this->userAuthentification->logout();
                    $this->response->redirect("/mvc_project/users");
                }
                $this->response->redirect("/mvc_project/customers");
            }
            
        }
        if ($this->request->isIssetPost("no")) {
            $this->response->redirect("/mvc_project/customers");
        }
        
        $this->view->generate("deleteCustomer_view.php", "template_view.php", $this->data);
    }

    public function action_Address($id)
    {
        if (!$this->userAuthentification->isIssetLoggedUser() | !$this->userAuthentification->isLoggedUserAdmin()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $errors = [
            'country' => "",
            'city' => "",
            'address' => "",
        ];

        $this->data['customer'] = $this->model->selectCustomerDataById($id);
        $this->data['address'] = $this->model->selectAddressDataById($id);

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            $errors = $this->model->checkValidAddressData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                if (!empty($this->data['address'])) {
                    if ($this->model->isSomethingChanged($inputData, $this->data['address'], "address")) {
                        $this->model->updateAddressData($inputData, $id);
                    }
                } else {
                    $this->model->insertAddressData($inputData, $id);
                }

                $this->response->redirect("/mvc_project/customers");
            }
        }

        $this->data['errors'] = $errors;
        if (empty($this->data['address'])) {
            $this->data['address'] = null;
        }
        $this->view->generate("addressCustomer_view.php", "template_view.php", $this->data);
    }
}