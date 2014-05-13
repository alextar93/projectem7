<?php

/**
 * Description of RegisterController
 * S'encarrega d'afegir un usuari nou a la base de dades
 *
 * @author Alex
 */
class RegisterController extends ControllerBase{
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
        $this->model= new RegisterModel($arr);
        $this->view=new View();      
    }
    
    /**
     *  La funcio index s'encarrega de carregar la pagina que es vol veure cridant a la vista, en aquest cas register.php.
     *  En aquest cas, s'afegeix com a parametre APP_W, i es defineix el template.
     * 
     */
    public function index(){               
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/register.php');
        $this->view->render();       
    }
    
    /**
    *
    * Agafa els valors email, password, nom i cognoms del formulari situat a register.php,
    * i crido a una altre funcio situada a RegisterModel.
    *
    * @param string $email conte el email que introdueix l'usuari desde el formulari
    * @param string $password conte el password que introdueix l'usuari desde el formulari
    * @param string $nom conte el nom que introdueix l'usuari desde el formulari
    * @param string $cognoms conte el cognom que introdueix l'usuari desde el formulari
    * @param int $user conte 0 o 1 en funcio de si s'ha pogut afegir l'usuari o no, 0 es OK.
    *
    * @return void
    */
    public function registrar_user(){
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['nom']) && isset($_POST['cognoms'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password=/*md5(*/filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)/*)*/;
            $nom=filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $cognoms=filter_input(INPUT_POST, 'cognoms', FILTER_SANITIZE_STRING);
            $user=$this->model->registrar($email, $password, $nom, $cognoms);
            if($user==0){
                $this->Redirect('login');  //si redirige a login es que se ha creado el usuario
            }else{
                $this->Redirect('register');      //la funcio redirect es triba a controller base
            }           
        }
    }
    
    /**
    *
    * Agafa els valors email, password, nom i cognoms del formulari situat a index.php a la seccio "El meu perfil",
    * que nomes es pot veure si l'usuari ha fet login correctament, i crido a una altre funcio situada a RegisterModel.
    *
    * @param string $email conte el email que introdueix l'usuari desde el formulari
    * @param string $password conte el password que introdueix l'usuari desde el formulari
    * @param string $nom conte el nom que introdueix l'usuari desde el formulari
    * @param string $cognoms conte el cognom que introdueix l'usuari desde el formulari
    * @param int $user conte 0 o 1 en funcio de si s'ha pogut editar o no.
    *
    * @return void
    */
    public function edit(){
        if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['email']) && isset($_POST['pass'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password=/*md5(*/filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING)/*)*/;
            $nom=filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $cognoms=filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
            $user=$this->model->editar_registro($email, $password, $nom, $cognoms);
            if($user==0){
                $this->Redirect('index');  //si redirige a index es que se ha editado correctamente
            }
        }
    }
}
