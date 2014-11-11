<?php
namespace models;

use Core\DbConnection1;
use Core\ActiveRecord;

class User extends ActiveRecord
{
    protected static $tableName = 'user';
    public $id;
    public $name;
    public $surname;
    public $date;
    protected static $mapping = array(
        'id' => 'id',
        'firstName' => 'name',
        'lastName' => 'surname',
        'createdDate' => 'date',
    );
}
