<?php
require_once('FileReader.php');

class CsvFileReader extends FileReader
{
    public function getContents()
    {
        if(!$this->_fileHandler){
            throw new Exception('Open File Before reading!');
        }
        $row = 1;
        $res = array();
        while (($data = fgetcsv($this->_fileHandler, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            for ($c=0; $c < $num; $c++) {
                $res[] = $data[$c];
            }
        }
        return $res;
    }
}