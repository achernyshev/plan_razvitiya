<?php

require_once('Database.php');
class Session
{
    protected $_database;

    public function __construct()
    {
        $this->_database = new Database;
        session_set_save_handler(
            array($this, "_open"),
            array($this, "_close"),
            array($this, "_read"),
            array($this, "_write"),
            array($this, "_destroy"),
            array($this, "_gc")
        );
        session_start();
    }

    public function _open()
    {
        if($this->_database){
            return true;
        }
        return false;
    }

    public function _close(){
        if($this->_database->close()){
            return true;
        }
        return false;
    }

    public function _read($id){
        $this->_database->query('SELECT data FROM sessions WHERE id = :id');
        $this->_database->bind(':id', $id);

        if($this->_database->execute()){
            $row = $this->_database->single();
            return $row['data'];
        }else{
            return '';
        }
    }

    public function _write($id, $data)
    {
        $access = time();

        $this->_database->query('REPLACE INTO sessions VALUES (:id, :access, :data)');

        $this->_database->bind(':id', $id);
        $this->_database->bind(':access', $access);
        $this->_database->bind(':data', $data);

        if($this->_database->execute()){
            return true;
        }
        return false;
    }

    public function _destroy($id)
    {
        $this->_database->query('DELETE FROM sessions WHERE id = :id');
        $this->_database->bind(':id', $id);
        if($this->_database->execute()){
            return true;
        }
        return false;
    }

    public function _gc($max)
    {
        $old = time() - $max;
        $this->_database->query('DELETE * FROM sessions WHERE access < :old');
        $this->_database->bind(':old', $old);
        if($this->_database->execute()){
            return true;
        }
        return false;
    }
}
