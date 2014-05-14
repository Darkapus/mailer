<?php
namespace AngularComponent;

class Renderer{
    
    public static $i = null;
    public static function i(){
        if(is_null(self::$i)){
            self::$i = new Renderer();
        }
        return self::$i;
    }
    public function __construct(){
        $this->application = new Core\Application();
    }
    protected $application = null;
    public function setApplication(Core\Application $application){
        $this->application = $application;
        return $this;
    }
    public function getApplication(){
        return $this->application;
    }
    public function show(Core\Element $element){
        // rendu html
        echo '<div class="ac-application" ng-app="'.$this->getApplication().'">';
        $element->preRender();
        $element->render();
        $element->postRender();
        echo '</div>';
        
        // rendu javascript
        echo '<script>';
        
        
            $this->getApplication()->preRender();
            $this->getApplication()->render();
            $this->getApplication()->postRender();
        
        echo '</script>';
    }
}