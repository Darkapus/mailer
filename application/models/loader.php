<?php
/**
 * Cette class permet de gérer les autoload des fichiers dans librairies qui sont désignées par des namespaces
 * Pour cela il suffit de faire :
 * Autoloader::register(); 
 */
class Loader extends \CI_Model{
    /**
     * function static à appeler pour l'autoload
     * 
     */
    static public function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Autoloader de librairies 
     */
    static public function autoload($class)
    {
        $relative_NS     = str_replace(__NAMESPACE__, '', $class);
        
        $translated_path = str_replace('\\', '/', $relative_NS);
        
        // on cherche dans libraries
        $file = __DIR__ . '/../libraries/' . $translated_path . '.php';
        
        if(file_exists($file)){
            require $file;
        }
    }
}