<?php

/**
 * Description of LoginController
 * S'encarrega de mostrar la pagina de login.php i de que funcioni el login correctament.
 *
 * @author Alex
 */
class LoginController extends ControllerBase{
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
        $this->model= new LoginModel($arr);
        $this->view=new View();      
    }
    
    /**
     *  La funcio index s'encarrega de carregar la pagina que es vol veure cridant a la vista, en aquest cas login.php.
     *  En aquest cas, s'afegeix com a parametre APP_W i html per despres mostrar a la vista, i es defineix el template.
     * 
     */ 
    public function index(){    //aquesta es la primera funcio que busca al anar a aquest controlador 
        $html="";
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W, "html" => $html));
        $this->view->setTemplate(APP.'/public/tpl/login.php');
        $this->view->render();       
    }
    
    /**
    *
    * Agafa els valors email i password del formulari situat a login.php,
    * i crido a una altre funcio situada a LoginModel, per comprobar que existeix l'usuari, en cas de no existir, 
    * carrega la vista de login.php i mostra un missatge d'error.
    *
    * @param string $email conte el email l'usuari desde el formulari
    * @param string $password conte el password que introdueix l'usuari desde el formulari
    * @param int $user conte 0 o 1 en funcio de si existeix o no l'usuari a la bbdd.
    * @param string $html conte missatge d'error si no existeix l'usuari 
    *
    * @return void
    */
    public function login(){
        if(isset($_POST['email'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password=/*md5(*/filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)/*)*/;
            $user=$this->model->login($email, $password);
            if($user==0){   //si devuelve 0 la funcion anterior, es que el usuario existe
                //Session::set('email', $email);
                $this->Redirect('index');  //amb session, la funcio redirect es troba a controller base
            }else{
                $html="<p style='color:red; padding-bottom:20px;'><b>Usuari o password incorrecte</b></p>";
                $this->view->addProp(array('APP_W'=>$this->conf->APP_W, "html" => $html));
                $this->view->setTemplate(APP.'/public/tpl/login.php');
                $this->view->render();
                //$this->Redirect('register');
            }           
        }
    }   

}
