<?php

namespace application\Model;

use application\Core\Model;


class Model_Products extends Model
{
    public function selectProductsData()
    {
        $rows = [];
        $sql = "SELECT * FROM Products";
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }
    
    public function selectProductDataById($id)
    {
        $sql = "SELECT * FROM products WHERE id = {$id}";
        $result = mysqli_query($this->connection, $sql);

        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }
    
    public function selectCategoriesData()
    {
        $rows = [];
        $sql = "SELECT id, category_name FROM categories";
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function insertProductData($inputData, $fileName)
    {
        $sql = "INSERT INTO products(product_name, sku, qty, price, category_id, image, description) VALUES 
        (\"{$inputData['product_name']}\", \"{$inputData['sku']}\", {$inputData['qty']}, 
        {$inputData['price']}, {$inputData['category_id']}, \"{$fileName}\", \"{$inputData['description']}\")";
        return mysqli_query($this->connection, $sql);
    }

    public function updateProductData($inputData, $fileName, $id)
    {
        $sql = "UPDATE products SET product_name = \"{$inputData['product_name']}\", sku = \"{$inputData['sku']}\", 
        qty = {$inputData['qty']}, price = {$inputData['price']}, category_id = {$inputData['category_id']}, 
        image = \"{$fileName}\", description = \"{$inputData['description']}\" WHERE id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function deleteProductData($id)
    {
        $sql = "DELETE FROM products WHERE id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function checkValidProductData($inputData, $errors, $products, $categories, $id = null)
    {
        $inputData['category_id'] = (int) $inputData['category_id'];
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['category_id'])) {
            $errors['category_id'] = $this->validator->isCategoryIdValid((int)$inputData['category_id'], $categories, "Category ID");
        }
        if (empty($errors['description'])) {
            $errors['description'] = $this->validator->isDescriptionLengthValid($inputData['description']);
        }
        if (empty($errors['qty'])) {
            $errors['qty'] = $this->validator->isNumberDecimal($inputData['qty']);
        }
        if (empty($errors['price'])) {
            $errors['price'] = $this->validator->isNumberFloatWithPoints($inputData['price'], 2, "Price");
        }
        if (empty($errors['product_name'])) {
            $errors['product_name'] = $this->validator->isProductNameUnique($inputData, $products, $id);
        }
        if (empty($errors['sku'])) {
            $errors['sku'] = $this->validator->isSkuValid($inputData['sku'], $products, $id);
        }
        
        $errors['image'] = $this->validator->isFileValid("image", "././assets/images/");

        return $errors;
    }

    public function prepareInsertProductData($inputData) {
        move_uploaded_file($_FILES['image']['tmp_name'], "././" .IMAGES_PATH .$_FILES['image']['name']);
        if ((int)$inputData['category_id'] === 0) {
            $inputData['category_id'] = "NULL";
        }
        return $this->insertProductData($inputData, $_FILES['image']['name']);
    }

    public function prepareUpdateProductData($inputData, $filePath, $id) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], "././" .IMAGES_PATH .$_FILES['image']['name']);
        if ((int)$inputData['category_id'] === 0) {
            $inputData['category_id'] = "NULL";
        }
        return $this->updateProductData($inputData, $_FILES['image']['name'], $id);
    }

    public function prepareDeleteProductData($filePath, $id) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }        
        return $this->deleteProductData($id);
    }

    public function isSomethingChanged($inputData, $receivedData)
    {  
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            return true;
        }
        $inputData = ['product_name' => $inputData['product_name'], 'sku' => $inputData['sku'], 'qty' => $inputData['qty'],
                    'price' => $inputData['price'], 'description' => $inputData['description'], 'category_id' => $inputData['category_id'],];
        $receivedData = ['product_name' => $receivedData['product_name'], 'sku' => $receivedData['sku'], 'qty' => $receivedData['qty'],
                    'price' => $receivedData['price'], 'description' => $receivedData['description'], 'category_id' => $receivedData['category_id'],];

        if ($inputData == $receivedData) {
            return false;
        } 
        return true;
    }
}
