<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author toni
 */

class UserController extends ControllerBase{
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
        //$this->model= new UserModel($arr);
        $this->view=new View();      
       
    }

    /**
     *  La funcio logout destrueix les variables de sessio actives.
     *  A continuacio, redirigeix cap a index.php
     * 
     */
    public function logout(){
        Session::destroy();
        $this->Redirect('index');
    }
    
    
    
}
