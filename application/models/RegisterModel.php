<?php

/**
 * Description of RegisterModel
 * S'encarrega de registrar i editar els usuaris a la base de dades.
 *
 * @author Alex
 */
class RegisterModel extends Model{
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->setDataout($arr);
    }
    
    /**
    * 
    * Rep com a parametres el valor de email i realitza una consulta de tipus SELECT a la base
    * de dades, filtrant per aquest parametre.
    *
    * @param string $sql_email aquest parametre conte la consulta SELECT
    * @param string $email 
    * @param int $filas conte el numero de filas que retorna la consulta
    *
    * @return int $filas
    */ 
    public function comprovar_email($email){
        $sql_email="SELECT * FROM usuaris WHERE email = ?";
        $query2=$this->db->prepare($sql_email);
        $query2->bindParam(1,$email);
        $query2->execute();                
        $filas=$query2->rowCount();
        return $filas;        
    }

    /**
    * 
    * Rep com a parametres el valor de email, password, nom i cognoms i realitza una consulta de tipus INSERT a la base
    * de dades per afegir l'usuari.
    *
    * @param string $email
    * @param string $password
    * @param string $nom
    * @param string $cognoms
    * @param int $filas conte el valor que retorna la funcio comprovar_email, sera OK si retorna 1, vol dir que l'email no
     * esta essent utilitzat
    *
    * @return int, retorna 0 si s'ha registrat, i 1 si no s'ha pogut registrar
    */ 
    public function registrar($email, $password, $nom, $cognoms){
        try{
                $filas=  $this->comprovar_email($email);
                
                if($filas==0){      //es OK, quiere decir que no hay ningun registro con ese email
                    $sql="INSERT INTO usuaris (id, nom, cognoms, email, password, idrol) VALUES (NULL, ?, ?, ?, ?, '2')";
                    $query=$this->db->prepare($sql);
                    //bind param
                    $query->bindParam(3,$email);	
                    $query->bindParam(4,$password);
                    $query->bindParam(1,$nom);
                    $query->bindParam(2,$cognoms);
                    //ejecucion del $query
                    $query->execute();
                    return 0;
                }else{                    
                     return 1;
                }               
	}catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}        
    } 
    
    /**
    * 
    * Rep com a parametres el valor de email, password, nom i cognoms i realitza una consulta de tipus UPDATE a la base
    * de dades per editar l'usuari.
    *
    * @param string $email
    * @param string $password
    * @param string $nom
    * @param string $cognoms
    * @param string $email_inicial conte el valor del email inicial, que es com l'identificador de l'usuari, ho extrec 
     * directament de la variable de sessio
    * @param string $sql conte la consulta sql a realitzar
    * @param int $filas conte el valor que retorna la funcio comprovar_email, sera OK si retorna 1, vol dir que l'email no
     * esta essent utilitzat
    *
    * @return int, retorna 0 si s'ha registrat, i 1 si no s'ha pogut editar l'usuari
    */
    public function editar_registro($email, $password, $nom, $cognoms){
        try{
                $filas=  $this->comprovar_email($email);
                $email_inicial=Session::get('user')->getEmail();
                
                if($filas==0 || $email_inicial==$email){      //es OK, quiere decir que no hay ningun registro con ese email
                    $sql="update usuaris set nom = ?, cognoms = ?, email = ?, password = ? where email = ?";
                    $query=$this->db->prepare($sql);
                    //bind param
                    $query->bindParam(3,$email);	
                    $query->bindParam(4,$password);
                    $query->bindParam(1,$nom);
                    $query->bindParam(2,$cognoms);
                    $query->bindParam(5,$email_inicial);
                    //ejecucion del $query
                    $query->execute();
                    return 0;
                }else{                    
                     return 1;
                }                
	}catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}
    }
    
}
