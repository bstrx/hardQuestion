<?php
namespace core;

class DbConnection1
{
    private static $_connection;
    private $_conn;

    private $_connect = array(
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pass' => '',
        'name' => '',
        'charset' => 'utf8'
    );

    private function __construct($connect)
    {
        $this->_connect = array_merge($this->_connect, $connect);
        try {
            $this->_conn = new \PDO('mysql:host=' . $this->_connect['host'] . ';dbname=' . $this->_connect['name'] . ';port='
                . $this->_connect['port'], $this->_connect['user'], $this->_connect['pass']);
            $this->_conn->exec("set names" . $this->_connect['charset']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function __destruct()
    {
        $this->_conn = NULL;
    }

    public static function getConnection($connect = array())
    {
        if (null === self::$_connection) {
            self::$_connection = new self($connect);
        }
        return self::$_connection;
    }

    public function query($sql, $params = array())
    {
        return $this->_conn->prepare($sql)->execute($params);
    }

    public function getAssoc($sql, $params = array())
    {
        $result = array();

        $sth = $this->_conn->prepare($sql);
        $sth->execute($params);
        while ($r = $sth->fetch(\PDO::FETCH_NUM)) {
            $result[$r[0]] = $r[1];
        }
        return $result;
    }
}