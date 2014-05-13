<?php

/**
 * Description of LoginModel
 * La seva funcio es buscar a la base de dades informacio sobre l'usuari que vol fer login.
 *
 * @author Alex
 */
class LoginModel extends Model{
    //put your code 
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->setDataout($arr);
    }
    
    /**
    * 
    * Rep com a parametres els valors de email i password, i realitza una consulta de tipus SELECT a la base
    * de dades, filtrant per aquests parametres, retornant un 0 si l'usuari exiteix, i un 1 si no existeix.
    * Si l'usuari existeix, es defineixen variables de sessio amb el nom, cognoms, email, password e id_rol, ho faig
    * creant un nou objecte de tipus Usuari.
    *
    * @param string $email
    * @param string $password 
    *
    * @return int
    */ 
 public function login($email, $password){
     try{       
                //consulta sql
		$sql="SELECT * FROM usuaris WHERE email = ? AND password = ?";
		$query=$this->db->prepare($sql);
                //bind param
                $query->bindParam(1,$email);	
                $query->bindParam(2,$password);
                //ejecucion del $query
                $query->execute();

                //para extraer todos los datos del usuario
                $res=$query->fetch();
                  if($query->rowCount()==1){
                   Session::set('islogged', true);
                  Session::set('user',new Usuari($res['nom'], $res['cognoms'], $res['email'], $res['password'], $res['idrol'], $res['id']));
                  }

                $filas=$query->rowCount();
                if($filas==1){      //es OK             
                    return 0;
                }else{
                    return 1;
                }
	}catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}   
 }
 
}
