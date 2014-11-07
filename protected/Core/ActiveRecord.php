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

}