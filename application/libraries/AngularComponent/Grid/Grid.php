<?php
namespace AngularComponent\Grid;

use \AngularComponent\Core\Element;
use \AngularComponent\Core\Behavior;
class Grid extends \AngularComponent\Panel\Panel{
    /**
     * 
     */
    protected $headers      = array();
    protected $storage      = null;
    protected $hasHeader    = true;
    protected $order        = null;
    
    
    public function hasHeader(){
        return $this->hasHeader;
    }
    /**
     * Storage = scope
     * donc obligatoire, il n'est donc pas necessaire de preciser ici le controller, il prendra automatiquement celui du storage
     */
    public function __construct(\AngularComponent\Core\Storage $storage, $title=null, $order=null, $id=null){
        parent::__construct($title, $id);
        $this->setStorage($storage);
        //$this->setController($controller = new \AngularComponent\Core\Controller($storage->getName()));
        $this->getController()->addChild($storage);
    }
    public function setOrder($order){
        $this->order = $order;
        return $this;
    }
    public function getOrder(){
        return $this->order;
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
    
    
    public function preRender(){
        $this->getController()->addChild(new Behavior('$scope.header={}'));
        $all_style = '';
        $o = new \stdClass();
        
        foreach($this->getHeaders() as $header){
            $name       = $header->getIndex();
            $o->$name   = $header->getWidth();
            //$this->getController()->addChild(new Behavior('$scope.header.'.$header->getIndex().'='.$header->getWidth()));
            //if($all_style) $all_style .= '+';
            //$all_style .= '$scope.header.'.$header->getIndex();
        }
        $this->getController()->addChild(new Behavior('$scope.header='.json_encode($o)));
        $this->getController()->addChild(new Behavior('$scope.sort={}'));
        //$this->getController()->addChild(new Behavior('$scope.'.$this.'='.$all_style));
        
        //$this->addAttribute('ng-style', '{width: '.$this.'}');
        
        parent::preRender();
	    echo '<table class="ac-table unselectable" unselectable="on">'.RC;
	    if($this->hasHeader()){
	        echo '<thead class="ac-table-header">'.RC;
	        echo '<tr class="ac-table-header-row">'.RC;
	        foreach($this->getHeaders() as $header){
    	        echo '<td id="'.$header->getId().'" class="ac-table-header-cell" ng-style="{width: header.'.$header->getIndex().'}" ng-click="sort.column=\''.$header->getIndex().'\';sort.descending=!sort.descending;">'.RC;
    	        echo $header->getLabel();
    	        echo '</td>'.RC; 
	        }
	        echo '</tr>'.RC;
    	    echo '</thead>'.RC;
	    }
	    return $this;
	}
	protected $rowClick = '';
	public function onRowClick(\AngularComponent\Core\Behavior $behavior){
	    //$this->rowClick = $behavior;
	    
        $this->rowClick = new \AngularComponent\Core\Behavior($this.'.'.$behavior->getContent());
        //$chaine = '$scope.'.$this.'_load = function(dest, type, params){$.ajax({url:dest,headers : {\'Content-Type\':\'application/x-www-form-urlencoded; charset=UTF-8\'},\'type\':type, data: params}).success(function(data){$(\'#'.$this.' .ac-panel-body\').html(data);});}';
        
        //$this->getController()->addChild(new \AngularComponent\Core\Behavior($chaine));
	    
	    return $this;
	}
	public function getRowClick(){
	    return $this->rowClick;
	}
	public function render(){
	    parent::render();
	    echo '<tbody class="ac-table-body">'.RC;
	    echo '<tr class="ac-table-body-row" ';
	    
	    echo 'ng-repeat="row in data ';
	    echo ' | orderBy:sort.column:sort.descending';
	    
	    echo '" ng-class="{\'ac-selected\': row.class';
	    if($rowclass = $this->getRowClass()){
	        echo ', '.$rowclass.RC;
	    }
	    echo'}" ng-click="row.class=!row.class;'.$this->getRowClick()->getContent().'">'.RC;
	    
	    //$this->getController()->addChild(new Behavior(''));
	    
	    foreach($this->getHeaders() as $header){
	    	echo '<td class="ac-table-body-cell" ng-style="{width: header.'.$header->getIndex().'}">'.RC;
	    	echo '<div class="ac-inner-cell" ng-style="{width: header.'.$header->getIndex().'}">'.RC;
	    	echo \AngularComponent\Renderer::i()->getApplication()->getStartSymbol();
	    	echo ' row.'.$header->getIndex().' '.\AngularComponent\Renderer::i()->getApplication()->getEndSymbol().RC;
	    	echo '</div></td>'.RC;
	    }
	    echo '</tr>'.RC;
	    echo "</tbody>".RC;
	    return $this;
	}
	public function postRender(){
	    echo '</table>'.RC;
	    return parent::postRender();
	}
	
	protected $rowClass = '';
	public function setRowClass($class){
	    $this->rowClass = $class;
	    return $this;
	}
	public function getRowClass(){
	    return $this->rowClass;
	}
}
