<?php
require_once('FileReader.php');

class XmlFileReader extends FileReader
{
    public function getContents()
    {
        if(!$this->_fileHandler){
            throw new Exception("Open File Before reading!");
        }
        $xml = simplexml_load_file($this->_filePath);
        $res = $this->_xml2array($xml);
        return $res;
    }

    protected function _xml2array(SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];
            $node = $element->count() ? $this->_xml2array($element) : trim($element);
        }

        return $array;
    }
}
