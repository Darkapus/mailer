<?php
namespace AngularComponent\Core;
/**
 * Le storage c'est le scope angularjs
 * Il permet de gérer la stratégie des données
 */
class Storage extends Behavior{
    protected $fields = array();
    /**
     * La définition des champs est à déclarer ici
     */
    public function addField($name, $type='string'){
        array_push($this->fields, new Field($name, $type));
        return $this;
    }
    public function getFields(){
        return $this->fields;
    }
    
    
    
    /**
     * Comment on récupére la data ici
     */
    public function render(){
        echo '$scope.data       = []';
    }
}