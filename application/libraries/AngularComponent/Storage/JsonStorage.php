<?php
namespace AngularComponent\Storage;

class JsonStorage extends \AngularComponent\Core\Storage{
    protected $jsonData = '{}';
    public function __construct($name, $jsonData, $id = null){
        parent::__construct($name, array('$scope'), $id);
        $this->setData($jsonData);
    }
    
    public function setData($jsonData){
        $this->jsonData = $jsonData;
        return $this;
    }
    public function getData(){
        return $this->jsonData;
    }
    public function render(){
        
        echo '$scope.data = '.$this->getData();
    }
}