<?php

/**
 * Description of ControllerBase
 * Es el controlador principal
 * @author Alex
 */
class ControllerBase {
    
    protected $model;
    protected $view;
    protected $config;
    protected $arguments=array();
    
  function __construct($arr) {
      $conf=  Config::getInstance();
      $conf->APP_W=  dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME',FILTER_SANITIZE_URL));
      $this->config=$conf;
      $this->arguments=$arr;
        /**
         * instanciem model
         */
      //  $this->model=new Model($arr);
      //  $this->view=new View();
        
    }
    
  /**
   *  Redirigeix cap a un controlador de la nostra aplicacio
   * @param string $pagina conte el nom del controlador al que volem anar
   * @return void
   */
  function Redirect($pagina){
          header("Location:".APP_W.'/'.$pagina);
  }
}
