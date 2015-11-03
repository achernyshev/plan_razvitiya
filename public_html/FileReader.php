<?php

abstract class FileReader
{
    protected $_filePath = '';
    protected $_fileHandler = NULL;

    abstract public function getContents();

    public function open($filePath)
    {
        $this->_filePath = $filePath;
        $this->_fileHandler = fopen($filePath, "r") or die("Unable to open file!");
    }

    function __destruct()
    {
        fclose($this->_fileHandler);
    }

    public static function getFileSize($filePath)
    {
        $bytes = filesize($filePath);
        $formatedSize = self::_formatSizeUnits($bytes);
        return $formatedSize;
    }

    protected function _formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
    }
}