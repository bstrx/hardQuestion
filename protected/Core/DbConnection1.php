<?php
namespace Core;
use config\Configuration;

class DbConnection1
{
    private static $_connection;
    private $_connections;

    private $_connect = array(
        'host' => 'localhost',
        'user' => 'root',
        'port' => '3306',
        'pass' => '12071990',
        'name' => 'hardquestion',
        'charset' => 'utf8'
    );

    /**
     *
     */
    private function __construct()
    {
        $this->_connect = array_merge($this->_connect);
        try {
            $connectionString = 'mysql:host=' . $this->_connect['host'] . ';dbname=' . $this->_connect['name'] .
                ';port=' . $this->_connect['port'];
            $this->_connections = new \PDO($connectionString, $this->_connect['user'], $this->_connect['pass']);
            $this->_connections->exec("set names" . $this->_connect['charset']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * do not allow cloning
     */
    private function __clone()
    {
    }

    /**
     * do not allow wakeup
     */
    private function __wakeup()
    {
    }

    /**
     *
     * @return DbConnection1
     */
    public static function getConnection()
    {
        if (null === self::$_connection) {
            self::$_connection = new self();
        }
        return self::$_connection;
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function query($sql, $params = array())
    {
        $result = $this->_connections->prepare($sql);
        $result->execute($params);
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function getNum($sql, $params = array())
    {
        $result = array();
        $r = $this->query($sql)->fetchAll(\PDO::FETCH_NUM);
        foreach ($r as $res) {
            $result[$res[0]] = $res[1];
        }
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function getAssoc($sql, $params = array())
    {
        $result = $this->query($sql);
        $result = $result->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
