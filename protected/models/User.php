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
        $date = new \DateTime();
        $date = $date->format('Y-m-d');
        var_dump($date);
        $sql = "INSERT INTO " . $this::$tableName . " VALUES ";
        die('save');
    }

    public function delete()
    {

    }

    public function update()
    {

    }

    public static function findall()
    {
        $sql = 'SELECT * FROM ' . self::$tableName;
        $connection = DbConnection1::getConnection();
        $result = $connection->getAssoc($sql);
        return $result;
    }
}
