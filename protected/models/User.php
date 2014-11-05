<?php
namespace models;

use Core\DbConnection1;

class User /*extends ActiveRecord */
{
    public static $tableName = 'user';
    public $id;
    public $firstName;
    public $lastName;
    public $createdDate;

    public function fieldsTable()
    {
        return array(
            'id' => 'Id',
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'createdDate' => 'Дата создания',
        );
    }

    public function save()
    {
        var_dump($this);
        $sql = "INSERT INTO " . $this::$tableName . " VALUES ";
        die('save');
    }

    public function delete()
    {

    }

    public function update()
    {

    }

    public function findall()
    {
        $sql = 'SELECT * FROM ' . $this::$tableName;
        $connection = DbConnection1::getConnection();
        $result = $connection->getAssoc($sql);
        return $result;
    }
}
