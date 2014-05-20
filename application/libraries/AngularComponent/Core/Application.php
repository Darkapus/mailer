<?php
namespace AngularComponent\Core;

class Application extends Object{
	
    protected $controllers = array();
    protected $routes = null;
    public function addController(Controller $controller){
        array_push($this->controllers, $controller);
        return $this;
    }
    public function getControllers(){
        return $this->controllers;
    }
    /*public function preRender(){
        echo '<script>';
        foreach($this->getControllers() as $controller){
        	if(!is_null($controller->getRoute())){
        		$o = new \stdClass();
        		$o->templateUrl= $controller->getRoute();
          		$o->controller= $controller.'';
          		$o->controllerAs= $controller.'';
				$this->routes = $o;          		
        	}
        }
    }*/
    public function preRender(){
        
    }
    
    protected $startSymbol = "[[";
    public function setStartSymbol($start){
        $this->startSymbol = $start;
        return $this;
    }
    public function getStartSymbol(){
        return $this->startSymbol;
    }
    protected $endSymbol = "]]";
    public function setEndSymbol($end){
        $this->endSymbol = $end;
        return $this;
    }
    public function getEndSymbol(){
        return $this->endSymbol;
    }
    
    public function render(){
        echo 'var '.$this.' = angular.module("'.$this.'", ["ngRoute"]);'.RC;
        echo $this.'.config(function($interpolateProvider) {
          $interpolateProvider.startSymbol("'.$this->getStartSymbol().'");
          $interpolateProvider.endSymbol("'.$this->getEndSymbol().'");
        });'.RC;
        foreach($this->getControllers() as $controller){
            echo $this.'.controller("'.$controller.'"';
            $controller->preRender();
            $controller->render();
            $controller->postRender();
            echo ');'.RC;
        }
        
        
        /*
        if(count($this->routes)){
        	echo $this.'.config(["$routeProvider","$locationProvider", function($routeProvider, $locationProvider){';
        	echo '$routeProvider';
        	foreach($this->getControllers() as $controller){
        		echo ".when('".$this->getControllers()->getRoute()."', {
		          templateUrl: '".$this->getControllers()->getTemplate()."',
		          controller: '".$this."',
		          controllerAs: '".$this."'
		        })";
        	}
        	echo'$locationProvider.html5Mode(true);';
			echo '}]);';
        }*/
    }   
    public function postRender(){
        
    }
}