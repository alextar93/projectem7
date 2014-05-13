<?php
/**
 * Description of IndexController
 * El controlador de Idex se encarga de cargar la pagina principal, que se encuentra en public/tpl/index.php,
 * y desde aqui gestionaré todas las llamadas a funciones tales como la de buscar vuelos, hoteles y planes
 *
 * @author Alex
 */

class IndexController extends ControllerBase{
    protected $model;
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
        $this->model= new IndexModel($arr);
        $this->view=new View();      
    }
    
    /**
     *  La funcio index s'encarrega de carregar la pagina que es vol veure cridant a la vista.
     *  En aquest cas, s'afegeix com a parametre APP_W, i es defineix el template.
     * 
     */    
    public function index(){               
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/index.php');
        $this->view->render();   
    }
    
    /**
    * Funcio de cerca d'hotels
    *
    * Agafa els valors ciutat, nom i categoria del formulari situat a index.php, a la seccio de hotels,
    * i crido a una altre funcio situada a IndexModel, per mostrar per pantalla la informacio
    * dels hotels
    *
    * @param string $ciutat conte el nom de la ciutat que introdueix l'usuari desde el formulari
    * @param string $nom conte el nom de l'hotel que introdueix l'usuari desde el formulari
    * @param int $categoria conte el numero d'estrelles de l'hotel que introdueix l'usuari desde el formulari
    * @param string $hotel conte la informacio dels hotels que retorna la funcio buscar_hotels de IndexModel 
    *
    * @return void
    */
    public function cercar_hotels(){
        $ciutat=filter_input(INPUT_POST, 'ciutat_hotel', FILTER_SANITIZE_STRING);
        $nom=filter_input(INPUT_POST, 'nom_hotel', FILTER_SANITIZE_STRING);
        $categoria=filter_input(INPUT_POST, 'categoria_hotel', FILTER_SANITIZE_NUMBER_INT);
         //Llamar al modelo     
        $hotel=$this->model->buscar_hotels($ciutat, $nom, $categoria);
        //$hotel es un array con valores de los hoteles
        echo $hotel;  
        //return $hotel;
    }
    
    /**
    * Funcio de cerca de vols
    *
    * Agafa els valors aeroport, desti i adults del formulari situat a index.php, a la seccio de vols,
    * i crido a una altre funcio situada a IndexModel, per mostrar per pantalla la informacio
    * dels vols
    *
    * @param string $aeroport conte el nom de l'aeroport que introdueix l'usuari desde el formulari
    * @param string $desti conte el nom del desti que introdueix l'usuari desde el formulari
    * @param int $adults conte el numero d'adults que volen volar, i que introdueix l'usuari desde el formulari
    * @param string $vol conte la informacio dels vols que retorna la funcio buscar_vols de IndexModel 
    *
    * @return void
    */    
    public function cercar_vols(){
        $aeroport=filter_input(INPUT_POST, 'aeroport', FILTER_SANITIZE_STRING);
        $desti=filter_input(INPUT_POST, 'desti', FILTER_SANITIZE_STRING);
        $adults=filter_input(INPUT_POST, 'num_adults', FILTER_SANITIZE_NUMBER_INT);
         //Llamar al modelo     
        $vol=$this->model->buscar_vols($aeroport, $desti, $adults);
        echo $vol;  
        //return $hotel;
    }
    
    /**
    * Funcio de cerca de plans
    *
    * Agafa el valor de persones del formulari situat a index.php, a la seccio de plans,
    * i crido a una altre funcio situada a IndexModel, per mostrar per pantalla la informacio
    * dels plans
    *
    * @param int $persones conte el numero de persones de l'hotel que introdueix l'usuari desde el formulari
    * @param string $pla conte la informacio dels plans que retorna la funcio buscar_plans de IndexModel 
    *
    * @return void
    */ 
    public function cercar_plans(){
        $persones=filter_input(INPUT_POST, 'persones', FILTER_SANITIZE_NUMBER_INT);
         //Llamar al modelo     
        $pla=$this->model->buscar_plans($persones);
        echo $pla;  
    }    
}
