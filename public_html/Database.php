<?php
class Database
{
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASS = "dev01";
    const DB_NAME = "sessions";

    protected $_dbh;
    protected $_error;
    protected $_stmt;

    public function __construct()
    {
        $this->_createIfNotExists();
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->_dbh = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
        }
        catch(PDOException $e){
            var_dump($e->getMessage()); die;
            $this->_error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->_stmt = $this->_dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->_stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId()
    {
        return $this->_dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->_dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->_dbh->commit();
    }

    public function debugDumpParams()
    {
        return $this->_stmt->debugDumpParams();
    }

    public function close()
    {
        $this->_dbh = NULL;
    }

    protected function _createIfNotExists()
    {
        $conn = new mysqli('localhost', 'root', 'dev01');
        $dbName = self::DB_NAME;
        if(!$conn->query("CREATE DATABASE IF NOT EXISTS {$dbName};")){
            var_dump($conn); die;
        }
        $conn->select_db("{$dbName}");
        if(!$conn->query("
        CREATE TABLE IF NOT EXISTS `sessions` (
        `id` varchar(32) NOT NULL,
        `access` int(10) unsigned DEFAULT NULL,
        `data` text,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;")){
            var_dump($conn); die;
        }
        $conn->close();
    }
}
