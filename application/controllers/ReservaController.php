<?php

/**
 * Description of ReservaController
 * S'encarrega de reservar els serveis, i de gestionar el carrito de la compra de l'aplicacio.
 *
 * @author Alex
 */
class ReservaController extends ControllerBase{
    //put your code here
    
    protected $model;
    protected $view;
    private $conf;
    
    public function __construct($arr) {
        parent::__construct($arr);
       //carregar la configuració
        $this->conf=$this->config;
        $this->model= new ReservaModel($arr);
        $this->view=new View();      
    }
    
    /**
     *  La funcio index s'encarrega de carregar la vista de carrito.php.
     *  En aquest cas, s'afegeix com a parametre APP_W, i es defineix el template.
     * 
     */
    public function index(){               
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/carrito.php');
        $this->view->render();       
    } 
    
    /**
    *
    * Agafa els valors servei, i persones del formulari que genera IndexModel, depenent del tipus de servei,
    * i crido a una altre funcio situada a ReservaModel.
    *
    * @param string $idservei conte el id del servei que vol reservar l'usuari, situat al formulari generat per cadascun dels serveis
    * @param string $personas conte el numero de persones per a les cuals es vol realitzar una reserva
    * @param int $guardar_servei conte 0 o 1 en funcio de si s'ha pogut afegir la reserva o no, 0 es OK.
    *
    * @return void
    */
    public function reservar(){
        $idservei=filter_input(INPUT_POST, 'servei', FILTER_SANITIZE_STRING);
        $personas=filter_input(INPUT_POST, 'person', FILTER_SANITIZE_STRING);
        $guardar_servei = $this->model->insertar_servei($idservei, $personas);

        if($guardar_servei==0){
            $this->Redirect('index');
        }else{
            $this->Redirect('login');
        }
    }
    
    /**
    *
    * Agafa el valor id de l'usuari directament de la variable de sessio, i mostra si l'usuari amb aquest id te
     * reserves pendents o no.
    *
    * @param string $usuario conte el id del servei que vol reservar l'usuari, situat al formulari generat per cadascun dels serveis
    * @param string $html conte el codi html a mostrar, que se li passara a la vista
    * @param int $datos conte 0 o 1 en funcio de si es correct o no, 0 es OK.
    * @param array $reemplazo conte les propietats que se li passaran a la vista. 
    *
    * @return void
    */
   public function carrito(){
       $usuario = Session::get('user')->getId();
       //echo $usuario;
       $datos=  $this->model->datos_reserva($usuario);
       if($datos==0){
           $html = "<p>No hi ha cap reserva.</p>";           
       }else{
            $html = "<div>";
            $html = $html."<table align='center'><tr><th>Identificador</th><th>Precio reserva</th><th>Fecha reserva</th><th>Eliminar</th></tr>";
            $html = $html."<tr><td>".$datos[0]."</td>"; 
            $html = $html."<td>".$datos[1]." €</td>";
            $html = $html."<td>".$datos[2]."</td>";
            $html = $html."<td><a href='".APP_W."/reserva/eliminar'><img src='".APP_W."/application/public/img/trash.png'></a></td></tr></table></br></br>";           
       }      
       
       $reemplazo = array("html" => $html, "APP_W" => APP_W);
       $this->view->addProp($reemplazo);
        $this->view->setTemplate(APP.'/public/tpl/carrito.php');
        $this->view->render();
    }
    
    /**
    *
    * Elimina la reserva de l'usuari, crida a la funcio eliminar_reserva de ReservaModel i per acabar
    * crida a la funcio carrito esmentada avans.
    *
    * @param string $usuario conte el id del servei que vol reservar l'usuari, situat al formulari generat per cadascun dels serveis
    *
    * @return void
    */
    public function eliminar(){
        $usuario = Session::get('user')->getId(); 
        $this->model->eliminar_reserva($usuario);
        $this->carrito(); 
    }
}
