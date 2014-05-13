<?php

/**
 * Description of Usuari
 * La classe usuari l'utilitzo per crear objectes del tipus Usuari, amb els seus atributs nom, cognoms, email, 
 * password, idrol e id.
 *
 * @author Alex
 */
class Usuari {
    //put your code here
    public $nom;
    public $cognoms;
    public $email;
    public $password;
    public $idrol;
    public $id;
    
    /**
     *  rep com a parametres nom, cognoms, email, password idrol e id. i s'encarrega d'igualarlos
     * per després poder utilitzarlos amb metodes de l'objecte.
     * 
     */ 
    //Utilizo la clase Usuari a LoginModel, per crear les variables de sessio
    function __construct($nom, $cognoms, $email, $password, $idrol, $id) {
        $this->nom=$nom;
        $this->cognoms=$cognoms;
        $this->email=$email;
        $this->password=$password;
        $this->idrol=$idrol;
        $this->id=$id;
    }
    
    /**
     *  funcio que s'encarrega de retornar el nom de l'usuari
     */ 
    function getNom(){
        return $this->nom;
    }
    
    /**
     *  funcio que s'encarrega de retornar el nom de l'usuari
     */ 
    function getCognoms(){
        return $this->cognoms;
    }
    
    /**
     *  funcio que s'encarrega de retornar el cognom de l'usuari
     */ 
    function getEmail(){
        return $this->email;
    }
    
    /**
     *  funcio que s'encarrega de retornar el email de l'usuari
     */ 
    function getPassword(){
        return $this->password;
    }
    
    /**
     *  funcio que s'encarrega de retornar el rol de l'usuari
     */ 
    function getIdrol(){
        return $this->idrol;
    }
    
    /**
     *  funcio que s'encarrega de retornar el id de l'usuari
     */ 
    function getId(){
        return $this->id;
    }
}
