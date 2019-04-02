<?php

namespace application\Model;

use application\Core\Model;


class Model_Categories extends Model
{
    public function selectCategoriesData()
    {
        $rows = [];
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function selectCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = {$id}";
        $result = mysqli_query($this->connection, $sql);

        return ($res = mysqli_fetch_assoc($result)) ? $res : [];
    }


    public function insertCategoryData($inputData)
    {
        $sql = "INSERT INTO categories(category_name, parent) VALUES (\"{$inputData['category_name']}\", {$inputData['parent']})";
        return mysqli_query($this->connection, $sql);
    }

    public function updateCategoryData($inputData, $id)
    {
        $sql = "UPDATE categories SET category_name = \"{$inputData['category_name']}\", parent = {$inputData['parent']} WHERE id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function deleteCategoryData($id)
    {
        $sql = "DELETE FROM categories WHERE id = $id";
        return mysqli_query($this->connection, $sql);
    }

    public function checkValidCategoryData($inputData, $errors, $categories, $id = null)
    {
        $inputData['parent'] = (int) $inputData['parent'];
        $errors = $this->validator->checkFields($inputData, $errors);

        if (empty($errors['category_name'])) {
            $errors['category_name'] = $this->validator->isCategoryNameUnique($inputData, $categories, $id);
        }
        if (empty($errors['parent'])) {
            $errors['parent'] = $this->validator->isCategoryIdValid($inputData['parent'], $categories, "Parent ID");
        }

        return $errors;
    }

    public function isSomethingChanged($inputData, $receivedData)
    {  
        return $this->validator->dummyCheck($inputData, $receivedData, "category");
    }
}
