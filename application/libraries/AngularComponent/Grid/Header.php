<?php
namespace AngularComponent\Grid;
class Header extends \AngularComponent\Core\Object{
    public function __construct($label, $index, $width=null){
        $this->setLabel($label);
        $this->setIndex($index);
        $this->setWidth($width);
        
    }
    
    protected $label;
    public function setLabel($label){
        $this->label=$label;
        return $this;
    }
    public function getLabel(){
        return $this->label;
    }   
    
    
    protected $index;
    public function setIndex($index){
        $this->index=$index;
        return $this;
    }
    public function getIndex(){
        return $this->index;
    }   
    
    
    protected $width;
    public function setWidth($width){
        $this->width=$width;
        return $this;
    }
    public function getWidth(){
        return $this->width;
    }   
}