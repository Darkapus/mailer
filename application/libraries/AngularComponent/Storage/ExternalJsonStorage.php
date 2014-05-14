<?php
namespace AngularComponent\Storage;

class JsonStorage extends \AngularComponent\Core\Storage{
    
    public function __construct($name, $id = null, $url, $method='POST', $params = null){
        parent::__construct(new \AngularComponent\Core\Controller($name), array('$scope'), $id);
        
        if(is_null($params)){
             $params = new \stdClass();
        }
        
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setParams($params);
    }
    public function setUrl($url){
        $this->url = $url;
        return $this;
    }
    public function getUrl(){
        return $this->url;
    }
    
    public function setMethod($method){
        $this->method = $method;
        return $this;
    }
    public function getMethod(){
        return $this->method;
    }
    
    public function setParams($params){
        $this->params = $params;
        return $this;
    }
    public function getParams(){
        return $this->params;
    }
    
    public function render(){
        parent::render();
        echo '$http({url: "'.$this->getUrl().'", method: "'.$this.getMethod().'", data: '.json_encode($params).'}).success(function(data) { $scope.data = data;});';
    }
}