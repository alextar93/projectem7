<?php

/**
 * Description of Bootstrap
 * Inicia el sistema
 * És una classe singleton que controla el fluxe del programa
 * 
 * @author Alex
 */

class Bootstrap {
    protected $controller;
    protected $action;
    protected $params;
    protected $body;
    
    static $instace;
    
    /**
     * 
     * Retorna una instancia
     */
    public static function getInstance(){
        if (!(self::$instace instanceof self)){
            self::$instace=new self();
        }
        return self::$instace;
        }
        

     /**
     *  funcio que s'encarrega de particionar la url i defini el controlador i l'accio
     */
   private function __construct() {
            $request = filter_input(INPUT_SERVER,'REQUEST_URI',FILTER_DEFAULT);
            $parts=explode('/',trim($request,'/'));
            //treiem part del nom d'aplicació
            array_shift($parts);
            
            $this->controller=!empty($parts[0])?$parts[0]==="index.php"?DEF_CONTROLLER:$parts[0]:DEF_CONTROLLER;
            $this->action=!empty($parts[1])?$parts[1]:DEF_ACTION;
            // completem un array associatiu amb el paràmetres.
            if (!empty($parts[2])){
                $keys=$values=array();
                for($i=2,$cnt=count($parts);$i<$cnt;$i++){
                    if($i%2==0){
                        // si és parell és una clau
                        $keys[]=$parts[$i];
                    }
                    else{
                        //és imparell és un valor
                        $values[]=$parts[$i];
                    }
                }               
                   $this->params=  array_combine($keys, $values);                
            }
        }
        
        /**
        *  funcio que s'encarrega de seleccionar el controlador i d'arrencarlo segons la seva accio,
         * si no ho troba, donara missatge de error.
        */
        public function route(){
            $classe=ucfirst(strtolower($this->getController())).'Controller';
            
            if (class_exists($classe)){
                
                $routeCont=new ReflectionClass($classe);
                if($routeCont->hasMethod($this->getAction())){
                    $controller=$routeCont->newInstance($this->params);
                    $method=$routeCont->getMethod($this->getAction());
                    $method->invoke($controller);
                }else{
                    throw new Exception("No Action");
                }
                
            }else{
                throw new Exception("No Controller");            
            }
        }
        
        /**
        *  retorna el controlador
        */
        public function getController(){
            return $this->controller;
        }
        
        /**
        *  retorna l'accio
        */
        public function getAction(){
            return $this->action;
        }
        
        /**
        *  retorna els parametres
        */
        public function getParams(){
            return $this->params;                    
        }
    
}
