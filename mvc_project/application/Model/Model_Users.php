<?php

namespace application\Model;

use application\Core\Model;


class Model_Users extends Model
{
    public function selectLoginData($login, $password)
    {
        $sql = "SELECT * FROM users WHERE login = \"{$login}\" AND password = \"{$password}\"";
        $result = mysqli_query($this->connection, $sql);
        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }

    public function insertSignupData($inputData)
    {
        $sql = "INSERT INTO users (login, password, email, firstname, lastname, phone, age, sex) VALUES (
            \"{$inputData['login']}\", \"{$inputData['password']}\", \"{$inputData['email']}\", 
            \"{$inputData['firstname']}\", \"{$inputData['lastname']}\", \"{$inputData['phone']}\", 
            {$inputData['age']}, {$inputData['sex']})";
        return mysqli_query($this->connection, $sql);
    }

    public function isLoginValid($login)
    {
        $sql = 'SELECT * FROM users WHERE login = ' . "\"$login\"";
        $result = mysqli_query($this->connection, $sql);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            return 'Login is busy';
        }
        return '';
    }

    public function updateUserData($inputData, $login)
    {
        $sql = "UPDATE users SET email = \"{$inputData['email']}\", firstname = \"{$inputData['firstname']}\", 
                lastname = \"{$inputData['lastname']}\", phone = \"{$inputData['phone']}\", age = \"{$inputData['age']}\", 
                sex = \"{$inputData['sex']}\" WHERE login = \"{$login}\"";
        return mysqli_query($this->connection, $sql);
    }

    public function getUserByLogin($login)
    {
        $sql = "SELECT * FROM users WHERE login = \"{$login}\"";
        $result = mysqli_query($this->connection, $sql);
        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }

    public function selectAddressData($id)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = \"{$id}\"";
        $result = mysqli_query($this->connection, $sql);
        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }

    public function insertAddressData($inputData, $id)
    {
        $inputData['address'] = $this->validator->trimAddress($inputData['address']);
        $sql = "INSERT INTO addresses (user_id, country, city, address) VALUES (
            $id, \"{$inputData['country']}\", \"{$inputData['city']}\", \"{$inputData['address']}\")";
        return mysqli_query($this->connection, $sql);
    }

    public function updateAddressData($inputData, $id)
    {
        $inputData['address'] = $this->validator->trimAddress($inputData['address']);
        $sql = "UPDATE addresses SET country = \"{$inputData['country']}\", city = \"{$inputData['city']}\", 
            address = \"{$inputData['address']}\" WHERE user_id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function checkValidEditAddressData($inputData, $errors)
    {
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['address'])) {
            $errors['address'] = $this->validator->isAddressValid($inputData['address']);
        }

        return $errors;
    }

    public function checkValidEditUserData($inputData, $errors)
    {
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['email'])) {
            $errors['email'] = $this->validator->isEmailValid($inputData['email']);
        }
        if (empty($errors['phone'])) {
            $errors['phone'] = $this->validator->isPhoneValid($inputData['phone']);
        }
        if (empty($errors['firstname'])) {
            $errors['firstname'] = $this->validator->checkNames($inputData['firstname'], "Firstname");
        }
        if (empty($errors['lastname'])) {
            $errors['lastname'] = $this->validator->checkNames($inputData['lastname'], "Lastname");
        }
        $errors['sex'] = $this->validator->isRadioValid($inputData);

        return $errors;
    }

    public function checkValidLoginData($inputData, $errors)
    {
        $errors = $this->validator->checkFields($inputData, $errors);

        return $errors;
    }

    public function checkValidSignUpData($inputData, $errors)
    {
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['login'])) {
            $errors['login'] = $this->isLoginValid($inputData['login']);
        }
        if (empty($errors['email'])) {
            $errors['email'] = $this->validator->isEmailValid($inputData['email']);
        }
        if (empty($errors['confirm_password'])) {
            $errors['confirm_password'] = $this->validator->checkMatchStrings($inputData['password'], $inputData['confirm_password']);
        }
        if (empty($errors['password'])) {
            $errors['password'] = $this->validator->checkPassword($inputData['password']);
        }
        if (empty($errors['password'])) {
            $errors['password'] = $this->validator->checkStringLength($inputData['password']);
        }
        if (empty($errors['phone'])) {
            $errors['phone'] = $this->validator->isPhoneValid($inputData['phone']);
        }

        if (empty($errors['firstname'])) {
            $errors['firstname'] = $this->validator->checkNames($inputData['firstname'], "Firstname");
        }
        
        if (empty($errors['lastname'])) {
            $errors['lastname'] = $this->validator->checkNames($inputData['lastname'], "Lastname");
        }
        $errors['sex'] = $this->validator->isRadioValid($inputData);

        return $errors;
    }

    public function isSomethingChanged($inputData, $receivedData, $type)
    {
        return $this->validator->dummyCheck($inputData, $receivedData, $type);
    }
}
