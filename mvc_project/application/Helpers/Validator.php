<?php
namespace application\Helpers;

class Validator
{
    public function checkFields($inputData, $errors)
    {
        foreach ($inputData as $key => $item) {
            if (empty($item) && $item !== 0) {
                $errors[$key] = ucfirst($key) . " field is empty";
            }
        }
        return $errors;
    }

    public function isEmailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Email is not valid';
        }
        return '';
    }

    public function isPhoneValid($phone)
    {
        if (!preg_match('/^[+][3][8][0][0-9]{2}[-][0-9]{2}[-][0-9]{2}[-][0-9]{3}+$/', $phone)) {
            return 'Phone is not valid';
        }
        return '';
    }

    public function isRadioValid($inputData)
    {
        if (!isset($inputData['sex'])) {
            return 'Select gender';
        }
        return '';
    }

    public function checkNames($string, $type)
    {
        if (!preg_match('/^[a-zA-z]+$/', $string)) {
            return "$type must contain only letters";
        }
        return '';
    }

    public function checkPassword($password)
    {
        $result = $this->checkStringLength($password);
        if ($result == "") {

            $numeric = false;
            $lowercase = false;
            $uppercase = false;
            for ($i = 0; $i < strlen($password); $i++) {
                if (is_numeric($password[$i])) {
                    $numeric = true;
                } elseif (ctype_lower($password[$i])) {
                    $lowercase = true;
                } elseif (ctype_upper($password[$i])) {
                    $uppercase = true;
                }
                if ($numeric && $lowercase && $uppercase) {
                    return '';
                }
            }
            return 'Password must contain number, lowercase and uppercase letters';
        } else {
            return $result;
        }
    }

    public function checkMatchStrings($stringOne, $stringTwo, $type = 'Passwords')
    {
        if ($stringOne != $stringTwo) {
            return $type . ' must be equal';
        }
        return '';
    }

    public function checkStringLength($string, $length = 8, $type = 'Password')
    {
        if (strlen($string) < $length) {
            return $type . ' should contain atleast ' . $length . ' symbols';
        }
        return '';
    }

    public function isAddressValid($address)
    {
        $array = explode(",", $address);

        foreach ($array as $key => $item) {
            $array[$key] = trim($item);
        }

        if (count($array) == 2) {
            if (strlen($array[1]) <= 3 && strlen($array[1]) >= 1) {
                return "";
            }
        } elseif (count($array) == 3) {
            if ((strlen($array[1]) <= 3 && strlen($array[1]) >= 1) && (strlen($array[2]) <= 3 && strlen($array[2]) >= 1)) {
                return "";
            }
        }
        
        return "Address is not valid";
    }

    public function isCategoryNameUnique($inputData, $categories, $id)
    {
        for ($i = 0; $i < count($categories); $i++) {
            if ($categories[$i]['category_name'] == $inputData['category_name'] && $categories[$i]['id'] != $id) {
                return "Category already exist";
            }
        }
        return "";
    }
    
    public function isProductNameUnique($inputData, $products, $id)
    {
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]['product_name'] == $inputData['product_name'] && $products[$i]['id'] != $id) {
                return "Product already exist";
            }
        }
        return "";
    }


    public function isCategoryIdValid($id, $categories, $message) {
        if (is_numeric($id) && $id === 0)
        {
            return "";
        }

        for ($i = 0; $i < count($categories); $i++) {
            if ($categories[$i]['id'] == $id) {
                return "";
            }
        }
        return "$message is not valid";
    }

    public function isDescriptionLengthValid($text) {
        if (!(strlen($text) < 255)) {
            return "Description length must be under 255 symbols";
        }
        return "";
    }

    public function isFileValid($index, $destination) {
        if (is_uploaded_file($_FILES[$index]['tmp_name'])) {
            if(empty($_FILES[$index]['name'])) {
                return "File name is empty";
            }

            $upload_file_name = $_FILES[$index]['name'];

            if(strlen($upload_file_name) > 100) {
                return "File name must be less than 100 symbols";
            }

            if ($_FILES[$index]['size'] > 2097152) {
                return "File size must be less than 2mb";
            }

            $filepath = $destination .$upload_file_name;
            $file_parts = pathinfo($filepath);

            if ($file_parts['extension'] != "jpg" && $file_parts['extension'] != "jpeg" && $file_parts['extension'] != "png") {
                return "Only png and jpg files are allowed";
            }
            if (file_exists($filepath)) {
                return "File already exist";
            }

            $_FILES[$index]['name'] = $upload_file_name = preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $upload_file_name);
        }
            return "";
    }

    public function isSkuValid($sku, $products, $id)
    {
        if (!preg_match('/^[0-9]{13}$/', $sku)) {
            return "Sku must be 13 symbols long and contain only numbers";
        }
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]['sku'] == $sku && $products[$i]['id'] != $id) {
                return "SKU already exist";
            }
        }
        return "";
    }

    public function isNumberDecimal($number)
    {
        return strpos($number, ".") === false ? "" : "Quantity must be a decimal number";
    }

    public function isNumberFloatWithPoints($number, $points, $text) {
        if (!preg_match("/^[0-9]+\.|\,[0-9]{{$points}}$/", $number)) {
            return "$text is not valid";
        }
        if(($res = strpos($number, ",")) !== false) {
            $number[$res] = '.';
        }
        return "";
    }

    public function dummyCheck($inputData, $receivedData, $type)
    {
        if($type == "user") {
            unset($inputData['send']);
            unset($receivedData['id']);
            if (isset($receivedData['login'])) {
                unset($receivedData['login']);
            }
            if (isset($inputData['login'])) {
                unset($inputData['login']);
            }
        }
        
        if ($type == "address") {   
            $receivedData = ['country' => $receivedData['country'], 'city' => $receivedData['city'], 'address' => $receivedData['address']];
            $inputData = ['country' => $inputData['country'], 'city' => $inputData['city'], 'address' => $inputData['address']];
        }

        if ($type == "category") {
            $inputData = ['category_name' => $inputData['category_name'], 'parent' => $inputData['parent']];
            $receivedData = ['category_name' => $receivedData['category_name'], 'parent' => $receivedData['parent']];
        }
        
        if ($inputData == $receivedData) {
            return false;
        } 
        return true;
    }

    public function trimAddress($address)
    {
        $address = explode(",", $address);

        foreach ($address as $key => $item) {
            $address[$key] = trim($item);
        }

        return implode(",", $address);
    }
}
