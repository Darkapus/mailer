<?php
namespace AngularComponent\Core;

class Controller extends Object{
    /**
     * 
     */
    public function __construct($name=null, $id=null){
    	parent::__construct($id);
    	\AngularComponent\Renderer::i()->getApplication()->addController($this);
    	$name && $this->setName($name);
    }
    /**
     * 
     */
    protected $name     	= null;
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    public function getName(){
       return $this->name;
    }
    /**
     * 
     */
    protected $url      	= null;
    public function setUrl($url){
        $this->url = $url;
        return $this;
    }
    public function getUrl(){
        return $this->url;
    }
    /**
     * 
     */
    protected $route    	= null;
    public function setRoute($route){
        $this->route = $route;
        return $this;
    }
    public function getRoute(){
        return $this->route;
    }
    /**
     * 
     */
    
    
    protected $childs = array();
    public function addChild(Behavior $child){
        array_push($this->childs, $child);
        
        return $this;
    }
    public function getChilds(){
        return $this->childs;
    }
    
    
    /**
     * 
     */
    public function preRender(){
        echo ',[';
        $arguments = array();
        // on merge les arguments de tous ses enfants
        foreach($this->getChilds() as $content){
            $arguments = array_merge($arguments, $content->getArguments());
        }
        $arguments = array_unique($arguments);
        
        foreach($arguments as $k=>$argument){
            if($k>0) echo ",";
            echo "'$argument'";
        }
        echo ', function(';
        foreach($arguments as $k=>$argument){
            if($k>0) echo ",";
            echo $argument;
        }
        echo '){';
    }
    public function render(){
        
        foreach($this->getChilds() as $child){
        	$child->preRender();
        	$child->render();
        	$child->postRender();
        }
    }   
    public function postRender(){
        echo '}]';
    }
    
}