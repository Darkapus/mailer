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
    
    
	
	protected $attributes = array();
	public function addAttribute($name, $content){
	    $this->attributes = new Attribute($name, $content);
	    return $this;
	}
	public function getAttributes(){
	    return $this->attributes;
	}
	
	protected $jsElements   = array();
	public function addJsElement($jsElement){
        array_push($this->jsElements, $jsElement);
        return $this;
    }
    public function getJsElements(){
        return $this->jsElements;
    }
    
	public function preRender(){
	    echo '<'.$this->getDom().' id="'.$this->getId().'" class="'.implode(' ', $this->getClass()).'"';
	    foreach($this->getAttributes() as $attribute){
	        echo $attribute->getName().'='.$attribute->getContent();
	    }
	    echo '>';
	}
	public function render(){
	    
	}
	public function postRender(){
	    echo '</'.$this->getDom().'>';
	}
}