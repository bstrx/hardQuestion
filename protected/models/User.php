<?php
namespace models;

use Core\DbConnection1;

class User /*extends ActiveRecord */
{
    public static $tableName = 'user';
    public $id;
    public $name;
    public $surname;
    public $date;

    public static function getMapping()
    {
        return array(
            'id' => 'id',
            'firstName' => 'name',
            'lastName' => 'surname',
            'createdDate' => 'date',
        );
    }

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
     * @return array
     */
    public static function find($conditions = array())
    {
        $sql = self::selectUser($conditions);
        $result = DbConnection1::getConnection()->getAssoc($sql);
        $properties = self::getMapping();
        foreach ($result as $userInfo) {
            $user = new User();
            foreach ($userInfo as $dbField => $value) {
                $user->$properties[$dbField] = $value;
            }
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param array $conditions
     * @return User
     */
    public static function findOne($conditions = array())
    {
        $sql = self::selectUser($conditions);
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

    /**
     * @param array $conditions
     * @return string
     */
    public static function selectUser($conditions = array())
    {
        $sql = 'SELECT * FROM ' . self::$tableName;
        $sql .= self::addWhere($conditions);
        return $sql;
    }

    /**
     * @param array $conditions
     * @return string
     */
    public static function addWhere($conditions = array())
    {
        if (isset($conditions) and !empty($conditions)) {
            $sql = ' WHERE ';
            foreach ($conditions as $key => $value) {
                $condition[] = sprintf('%s = "%s"', $key, $value);
            }
            $sql .= implode(' AND ', $condition);
            return $sql;
        }
    }
}
