<?php
namespace Core;

use Core\DbConnection1;

abstract class ActiveRecord
{
    protected $db;
    protected static $tableName;
    protected static $mapping = [
        'id' => '',

    ];

    /**
     * @param $conditions
     * @return array
     */
    public static function find($conditions)
    {
        $results = array();
        $sql = 'SELECT * FROM ' . static::$tableName;
        $sql .= self::addWhere($conditions);
        $result = DbConnection1::getConnection()->getAssoc($sql);
        $properties = static::$mapping;
        foreach ($result as $objectInfo) {
            $result = new static();
            foreach ($objectInfo as $dbField => $value) {
                $result->$properties[$dbField] = $value;
            }
            $results[] = $result;
        }
        return $results;
    }

    /**
     * @param array $conditions
     * @return array
     */
    public static function findOne($conditions)
    {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $sql .= self::addWhere($conditions);
        $sql .= ' LIMIT 1';
        $result = DbConnection1::getConnection()->getAssoc($sql);
        if (isset($result[0])) {
            $results = new static();
            $properties = static::$mapping;
            foreach ($result[0] as $dbField => $value) {
                $results->$properties[$dbField] = $value;
            }
            return $results;
        } else {
            return NULL;
        }
    }
    /**
     * @param $conditions
     * @return null|string
     */
    public static function addWhere($conditions)
    {
        if (isset($conditions) and !empty($conditions)) {
            $sql = ' WHERE ';
            foreach ($conditions as $key => $value) {
                $condition[] = sprintf('%s = "%s"', $key, $value);
            }
            $sql .= implode(' AND ', $condition);
            return $sql;
        } else {
            return NULL;
        }
    }

    /**
     * @return bool
     */
    public function update()
    {
        $sql = 'UPDATE ' . static::$tableName . ' SET ';
        $result = (array)$this;
        $id = $result['id'];
        unset($result['id']);
        $properties = static::$mapping;
        $properties = array_flip($properties);
        foreach ($result as $field => $value) {
            if(isset($properties[$field])) {
                $sql .= sprintf('%s = "%s", ', $properties[$field], $value);
            }
        }
        $sql = rtrim($sql, ", ") . " WHERE id=" . $id;
        return DbConnection1::getConnection()->query($sql);
    }

    /**
     * @return bool
     */
    public function save()
    {
        if ($this->date == NULL) {
            $this->date = date('Y-m-d H:i:s');
        }
        $result = (array)$this;
        $result = array_filter($result);
        $properties = static::$mapping;
        $properties = array_flip($properties);
        $keysUser = array_keys($result);
        $valuesResult = array_values($result);
        foreach ($keysUser as $key) {
            if(isset($properties[$key])) {
                $newKeys[] = $properties[$key];
            }
        }
        $sql = "INSERT INTO " . static::$tableName . '(' . implode(',', $newKeys) . ') VALUES ("' . implode('","', $valuesResult) . '")';
        return DbConnection1::getConnection()->query($sql);
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public static function delete($conditions)
    {
        if (isset($conditions) and !empty($conditions)){
            $sql = 'DELETE FROM ' . static::$tableName;
            $sql .= self::addWhere($conditions);
            return DbConnection1::getConnection()->query($sql);
        } else {
            return NULL;
        }
    }

}
