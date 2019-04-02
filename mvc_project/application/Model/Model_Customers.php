<?php

namespace application\Model;

use application\Core\Model;


class Model_Customers extends Model
{
    public function selectCustomersData()
    {
        $rows = [];
        $sql = "SELECT * FROM users";
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }
    
    public function selectCustomerDataById($id)
    {
        $sql = "SELECT * FROM users WHERE id = {$id}";
        $result = mysqli_query($this->connection, $sql);

        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }

    public function selectAddressDataById($id)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = {$id}";
        $result = mysqli_query($this->connection, $sql);

        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }

    public function insertCustomerData($inputData)
    {
        $sql = "INSERT INTO users (login, password, email, firstname, lastname, phone, age, sex) VALUES (
            \"{$inputData['login']}\", \"{$inputData['password']}\", \"{$inputData['email']}\", 
            \"{$inputData['firstname']}\", \"{$inputData['lastname']}\", \"{$inputData['phone']}\", 
            {$inputData['age']}, {$inputData['sex']})";
        return mysqli_query($this->connection, $sql);
    }

    public function insertAddressData($inputData, $id)
    {
        $inputData['address'] = $this->validator->trimAddress($inputData['address']);
        $sql = "INSERT INTO addresses (user_id, country, city, address) VALUES (
            $id, \"{$inputData['country']}\", \"{$inputData['city']}\", \"{$inputData['address']}\")";
        return mysqli_query($this->connection, $sql);
    }

    public function updateCustomerData($inputData, $id)
    {
        $sql = "UPDATE users SET email = \"{$inputData['email']}\", firstname = \"{$inputData['firstname']}\", 
                lastname = \"{$inputData['lastname']}\", phone = \"{$inputData['phone']}\", age = \"{$inputData['age']}\", 
                sex = \"{$inputData['sex']}\" WHERE id = {$id}";
        return mysqli_query($this->connection, $sql);
    }
    
    public function updateAddressData($inputData, $id)
    {
        $inputData['address'] = $this->validator->trimAddress($inputData['address']);
        $sql = "UPDATE addresses SET country = \"{$inputData['country']}\", city = \"{$inputData['city']}\", 
            address = \"{$inputData['address']}\" WHERE user_id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function deleteCustomerData($id)
    {
        $sql = "DELETE FROM users WHERE id = $id";
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

    public function checkValidAddData($inputData, $errors)
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

    public function checkValidEditData($inputData, $errors)
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

    public function checkValidAddressData($inputData, $errors)
    {
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['address'])) {
            $errors['address'] = $this->validator->isAddressValid($inputData['address']);
        }

        return $errors;
    }

    public function isSomethingChanged($inputData, $receivedData, $type)
    {
        return $this->validator->dummyCheck($inputData, $receivedData, $type);
    }
}
