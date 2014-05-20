<?php
namespace AngularComponent\Core;

class Element extends Object{
    
    protected $class        = array('ac-panel');
    public function addClass($class){
        array_push($this->class, $class);
        return $this;
    }
    public function getClass(){
        return $this->class;
    }
    
    protected $dom      = 'div';
    public function setDom($dom){
        $this->dom = $dom;
        return $this;
    }
    public function getDom(){
        return $this->dom;
    }
    
    protected $controller;
    public function setController($controller){
        $this->controller = $controller;
    }
    public function getController(){
        return $this->controller;
    }
	
	protected $attributes = array();
	public function addAttribute($name, $content){
	    array_push($this->attributes, new Attribute($name, $content));
	    return $this;
	}
	public function getAttributes(){
	    return $this->attributes;
	}
	/*
	protected $jsElements   = array();
	public function addJsElement($jsElement){
        array_push($this->jsElements, $jsElement);
        return $this;
    }
    public function getJsElements(){
        return $this->jsElements;
    }
    */
	public function preRender(){
	    // si il existe un controller
	    $this->getController() && $this->addAttribute("ng-controller", $this->getController().'');
	    $this->addAttribute("id", $this.'');
	    $this->addAttribute("class", implode(' ', $this->getClass()));
	    
	    echo '<'.$this->getDom().' ';
	    foreach($this->getAttributes() as $attribute){
	        echo $attribute->__toString();
	    }
	    echo '>';
	}
	public function render(){
	    parent::render();
	}
	public function postRender(){
	    echo '</'.$this->getDom().'>';
	}
	
	public function addFunction($name, $function){
	    $this->getController()->addChild(new Behavior('$scope.'.$name.'='.$function.';'));
	    return $this;
	}
}