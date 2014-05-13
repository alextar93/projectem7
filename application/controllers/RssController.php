<?php

/**
 * Description of RssController
 * Aquest controlador l'utilitzo unicament per carregar la vista de rss.php.
 *
 * @author Alex
 */
class RssController extends ControllerBase{
    //put your code here
    protected $view;
    private $conf;
    
    /**
     * rep con a paràmetre un array associatiu que 
     * permet passar els paràmetres de la URI
     * @param array $arr
     */
    public function __construct($arr) {
        parent::__construct($arr);
       //carregar la configuració
        $this->conf=$this->config;
        $this->view=new View();      
    }
    
    /**
     *  La funcio index s'encarrega de carregar la pagina rss.php cridant a la vista.
     *  En aquest cas, s'afegeix com a parametre APP_W, i es defineix el template.
     * 
     */
    public function index(){               
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/rss.php');
        $this->view->render();       
    }
}
