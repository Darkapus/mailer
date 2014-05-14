<?php
namespace AngularComponent\Grid;

use \AngularComponent\Core\Element;

class Grid extends Element{
    /**
     * 
     */
    protected $headers = array();
    protected $storage = null;
    protected $hasHeader = true;
    public function hasHeader(){
        return $this->hasHeader;
    }
    /**
     * Storage = scope
     */
    public function __construct(\AngularComponent\Core\Storage $storage, $id=null){
        parent::__construct($id);
        $this->setStorage($storage);
        
    }
    
    public function getStorage(){
        return $this->storage;
    }
    /**
     * Storage Needed. It is the data strategy + data
     * @return Grid
     */
    public function setStorage(\AngularComponent\Core\Storage $storage){
        $this->storage = $storage;
        return $this;
    }
    
	
	
    /**
     * Add an object header for data binding
     * @return Grid
     * */
    public function addHeader(Header $header){
        array_push($this->headers, $header);
        return $this;
    }
    public function getHeaders(){
        return $this->headers;
    }
    /**
     * Add an header for data binding
     * @Return Header
     * */
    public function addColumn($label, $index, $width=null){
        $this->addHeader($header = new Header($label, $index, $width));
        return $header;
    }
    
    
    public function getController(){
        return $this->getStorage()->getController();
    }
    
    public function preRender(){
        $this->addJsElement($this->getController());
        
        parent::preRender();
	    echo '<table class="ac-table unselectable" unselectable="on">';
	    if($this->hasHeader()){
	        echo '<thead class="ac-header">';
	        echo '<tr class="ac-header-row">';
	        foreach($this->getHeaders() as $header){
    	        echo '<td id="'.$header->getId().'" class="ac-header-cell">';
    	        echo $header->getLabel();
    	        echo '</td>'; 
	        }
	        echo '</tr>';
    	    echo '</thead>';
	    }
	    return $this;
	}
	public function render(){
	    parent::render();
	    echo '<tbody ng-controller="'.$this->getStorage()->getController().'" class="ac-body">';
	    echo '<tr class="ac-body-row" ng-repeat="row in data" ng-class="{\'ac-selected\': row.class}" ng-click="row.class=!row.class">';
	    foreach($this->getHeaders() as $header){
	    	echo '<td class="ac-body-cell"><div class="ac-inner-cell">{{ row.'.$header->getIndex().' }}</div></td>';
	    }
	    echo '</tr>';
	    echo "</tbody>";
	    return $this;
	}
	public function postRender(){
	    echo '</table>';
	    return parent::postRender();
	}
}
