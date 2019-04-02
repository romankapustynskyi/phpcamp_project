<?php

namespace application\Controller;

use application\Core\Controller;


class Controller_Users extends Controller
{
    public function __construct()
    {
        parent::__construct("\application\Model\Model_Users");
    }

    public function action_index()
    {
        $this->view->generate("homepage_view.php", "template_view.php");
    }

    public function action_Login()
    {
        if ($this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/account");
        }

        $errors = [
            'login' => "",
            'password' => "",
            'general' => ""
        ];

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;

            $errors = $this->model->checkValidLoginData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                $inputData['password'] = sha1($inputData['password']);
                $result = $this->userAuthentification->logIn($inputData);
                if (!$result) {
                    $this->response->redirect("/mvc_project/users/account");
                } else {
                    $errors['general'] = $result;
                }
            }
        }

        $this->data['errors'] = $errors;
        $this->view->generate("login_view.php", "template_view.php", $this->data);
    }

    public function action_Signup()
    {
        if ($this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/account");
        }

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
        $inputData = null;

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;

            $errors = $this->model->checkValidSignUpData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                $inputData['password'] = sha1($inputData['password']);

                if ($this->model->insertSignupData($inputData)) {
                    if (!$this->userAuthentification->logIn($inputData)) {
                        $this->response->redirect("/mvc_project/users/account");
                    } else {
                        $this->response->redirect("/mvc_project/users/login");
                    }
                }
            }
        }

        $this->data['errors'] = $errors;
        $this->data['inputData'] = $inputData;
        $this->view->generate("signup_view.php", "template_view.php", $this->data);
    }

    public function action_Account()
    {
        if (!$this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/login");
        }

        $this->data['loggedUser'] = $this->userAuthentification->getLoggedUserData();
        $addressData = $this->model->selectAddressData($this->data['loggedUser']['id']);
        if($addressData != []) {
            $this->data['userAddressData'] = $addressData;
        } else {
            $this->data['userAddressData'] = null;
        }

        if ($this->userAuthentification->isLoggedUserAdmin()) {
            $this->view->generate("adminAccount_view.php", "template_view.php", $this->data);
        } else {
            $this->view->generate("userAccount_view.php", "template_view.php", $this->data);
        }
    }

    public function action_Logout()
    {
        if (!$this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/login");
        }

        if ($this->request->isIssetPost("yes")) {
            $this->userAuthentification->logout();
            $this->response->redirect("/mvc_project/users/login");
        }
        if ($this->request->isIssetPost("no")) {
            $this->response->redirect("/mvc_project/users/account");
        }
        

        $this->view->generate("logout_view.php", "template_view.php");
    }

    public function action_EditUser()
    {
        if (!$this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/login");
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

        $userData = $this->userAuthentification->getLoggedUserData();


        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            $errors = $this->model->checkValidEditUserData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                if($this->model->isSomethingChanged($inputData, $userData, "user")) {
                    if($this->model->updateUserData($inputData, $userData['login'])) {
                        $inputData['login'] = $userData['login'];
                        $inputData['id'] = $userData['id'];
                        $this->userAuthentification->updateLoggedUserData($inputData);
                    }
                }

                $this->response->redirect("/mvc_project/users/account");
            }
        }

        $this->data['errors'] = $errors;
        $this->data['userData'] = $userData;
        $this->view->generate("editUser_view.php", "template_view.php", $this->data);
    }

    public function action_EditAddress()
    {
        if (!$this->userAuthentification->isIssetLoggedUser()) {
            $this->response->redirect("/mvc_project/users/login");
        }

        $errors = [
            'country' => "",
            'city' => "",
            'address' => "",
        ];

        $userData = $this->userAuthentification->getLoggedUserData();
        
        $addressData = $this->model->selectAddressData($userData['id']);

        if($addressData != []) {
            $this->data['userAddressData'] = $addressData;
        } else {
            $this->data['userAddressData'] = null;
        }

        if ($this->request->checkMethod("POST")) {
            $inputData = $this->request->postData;
            $errors = $this->model->checkValidEditAddressData($inputData, $errors);

            if (strlen(implode("", $errors)) == 0) {
                if(!empty($addressData)) {
                    if($this->model->isSomethingChanged($inputData, $addressData, "address")) {
                        $this->model->updateAddressData($inputData, $userData['id']);
                    }
                } else {
                    $this->model->insertAddressData($inputData, $userData['id']);
                }

                $this->response->redirect("/mvc_project/users/account");
            }
        }

        $this->data['errors'] = $errors;
        $this->data['userData'] = $userData;
        $this->view->generate("editAddress_view.php", "template_view.php", $this->data);
    }
}