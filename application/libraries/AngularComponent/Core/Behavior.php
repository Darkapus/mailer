<?php
namespace AngularComponent\Core;

class Behavior extends Object{
    protected $arguments = array();
    public function __construct(Controller $controller, array $arguments = array(), $content, $id=null){
        
        parent::__construct($id);
        $this->arguments = $arguments;
        $this->setController($controller);
        $this->getController()->addChild($this);
    }
    protected $content ;
    public function setContent($content){
        $this->content = $content;
        return $this;
    }
    public function getContent(){
        return $this->content;
    }
    public function addArgument($name){
    	array_push($this->arguments, $name);
    	return $this;
    }
    public function getArguments(){
    	return $this->arguments;
    }
    
    protected $controller;
    public function setController(Controller $controller){
        $this->controller = $controller;
        return $this;
    }
    public function getController(){
        return $this->controller;
    }
    
    public function render(){
        echo $this->getContent();
    }
}