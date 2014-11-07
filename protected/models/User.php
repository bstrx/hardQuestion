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

    /**
     * @return bool
     */
    public function save()
    {
        if ($this->date == NULL) {
            $this->date = date('Y-m-d H:i:s');
        }
        $user = (array)$this;
        unset($user['id']);
        $properties = $this->getMapping();
        $properties = array_flip($properties);
        $keysUser = array_keys($user);
        $valuesUser = array_values($user);
        foreach ($keysUser as $key) {
            $newKeys[] = $properties[$key];
        }
        $user = array_combine($newKeys, $valuesUser);
        $sql = "INSERT INTO " . self::$tableName . '(' . implode(',', $newKeys) . ') VALUES ("' . implode('","', $valuesUser) . '")';
        return DbConnection1::getConnection()->query($sql);
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public static function delete($conditions = array())
    {
        if (isset($conditions) and !empty($conditions)){
            $sql = 'DELETE FROM ' . self::$tableName;
            $sql .= self::addWhere($conditions);
            return DbConnection1::getConnection()->query($sql);
        }else {
            return NULL;
        }
    }

    /**
     * @return bool
     */
    public function update()
    {
        $sql = 'UPDATE ' . self::$tableName . ' SET ';
        $user = (array)$this;
        $id = $user['id'];
        unset($user['id']);
        $properties = $this->getMapping();
        $properties = array_flip($properties);
        foreach ($user as $field => $value) {
            $sql .= sprintf('%s = "%s", ', $properties[$field], $value);
        }
        $sql = rtrim($sql, ", ") . " WHERE id=" . $id;
        return DbConnection1::getConnection()->query($sql);
    }

    /**
     * @param array $conditions
     * @return User
     */
    public static function findOne($conditions)
    {
        $sql = 'SELECT * FROM ' . self::$tableName;
        $sql .= self::addWhere($conditions);
        $sql .= ' LIMIT 1';
        $result = DbConnection1::getConnection()->getAssoc($sql);
        if (isset($result[0])) {
            $user = new User();
            $properties = self::getMapping();
            foreach ($result[0] as $dbField => $value) {
                $user->$properties[$dbField] = $value;
            }
            return $user;
        }
    }

}
