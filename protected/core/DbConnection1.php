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

    /**
     * @param array $connect
     */
    private function __construct(array $connect)
    {
        $this->_connect = array_merge($this->_connect, $connect);
        try {
            $this->_conn = new \PDO('mysql:host=' . $this->_connect['host'] . ';dbname=' . $this->_connect['name'] .
                ';port=' . $this->_connect['port'], $this->_connect['user'], $this->_connect['pass']);
            $this->_conn->exec("set names" . $this->_connect['charset']);
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
     * @param array $connect
     * @return DbConnection1
     */
    public static function getConnection($connect = array())
    {
        if (null === self::$_connection) {
            self::$_connection = new self($connect);
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
        return $this->_conn->prepare($sql)->execute($params);
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function getNum($sql, $params = array())
    {
        $result = array();

        $result_temp = $this->_conn->prepare($sql);
        $result_temp->execute($params);
        while ($r = $result_temp->fetch(\PDO::FETCH_NUM)) {
            $result[$r[0]] = $r[1];
        }
        return $result;
    }
}