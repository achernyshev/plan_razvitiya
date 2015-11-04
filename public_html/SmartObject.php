<?php

class SmartObject
{
    protected $_container = array();
    const GETTER_PREF = 'get';
    const SETTER_PREF = 'set';

    public function __call($name, $arguments)
    {
        if(count($arguments) == 1){
            $arguments = current($arguments);
        }
        $methodName = strtolower($name);
        $key = '';
        $isSetter = false;
        if(strpos($methodName, self::GETTER_PREF) !== false){
            $key = str_replace(self::GETTER_PREF, '', $methodName);
        }
        else if(strpos($methodName, self::SETTER_PREF) !== false){
            $key = str_replace(self::SETTER_PREF, '', $methodName);
            $isSetter = true;
        }
        if(!$isSetter && array_key_exists($key, $this->_container)){
            return $this->_container[$key];
        }
        else {
            $this->_container[$key] = $arguments;
            return $this;
        }
    }
}