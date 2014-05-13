<?php

/**
 * Description of ReservaModel
 * S'encarrega de processar les dades que arriben de ReservaController, i de fer consultes a la base de dades mitjançant PDO.
 * 
 *
 * @author Alex
 */
class ReservaModel extends Model{
    //put your code here
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->setDataout($arr);
    }
    
    /**
    * 
    * Rep com a parametres el id de servei i el numero de persones, i realitza consultes de tipus SELECT, INSERT i 
     * UPDATE per a insertar un servei a les taules reserves i serveis_reservats, i modificar el seu contingut
     * en cas de existir una reserva per aquest usuari.
    *
    * @param string $idservei conte el identificador del servei pel cual es vol realitzar la reserva
    * @param int $personas conte el numero de persones per a les cuals es vol realitzar la reserva
    * @param float $preuservei conte el preu del servei multiplicat pel numero de persones
    * @param float $total_preu conte el preu total de la reserva 
    * @param string $iduser conte el identificador de l'usuari que realitza la reserva
    * @param string $sql conte la consulta sql a realitzar
    *
    * @return int, retorna 0 si s'ha pogut insertar el servei i un 1 si no.
    */ 
    public function insertar_servei($idservei, $personas){
        $sql="SELECT * FROM serveis WHERE id = ?";
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$idservei);
        $query->execute();
        $res=$query->fetch();
        $preuservei = $res['preu'] * $personas; //preu total de la reserva
        
        if(Session::isget('islogged')==TRUE){   //si l'usuari ha fet login
            $iduser = Session::get('user')->getId();            
            //treure el id de la reserva
            $sql="SELECT * FROM reserves WHERE idusuari = ? AND status = 'Pendent' LIMIT 1";
            $query=$this->db->prepare($sql);
            $query->bindParam(1,$iduser);
            $query->execute();
            $res=$query->fetch();
            $idreserva = $res['id'];
            $filas=$query->rowCount();

            if($filas==0){  //si es 0 es que no existeix reserva pendent de l'usuari
                /*reserva*/
                $sql="INSERT INTO reserves (id, idusuari, status, preu_res, data_res) VALUES (NULL, ?, 'Pendent', ?, curdate())";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$iduser);
                $query->bindParam(2,$preuservei);
                $query->execute(); 
                //treure el id de la reserva
                $sql="SELECT * FROM reserves WHERE idusuari = ? AND status = 'Pendent' LIMIT 1";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$iduser);
                $query->execute();
                $res=$query->fetch();
                $idreserva2 = $res['id'];
                /*servei reservat*/
                $sql="INSERT INTO serveis_reservats (idservei, idreserva, dataRes, places, preu_servei) VALUES (?, ?, curdate(), ?, ?)";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$idservei);
                $query->bindParam(2,$idreserva2);
                $query->bindParam(3,$personas);
                $query->bindParam(4,$preuservei);
                $query->execute();                                 
            }else{
                $sql="SELECT * FROM reserves WHERE idusuari = ? AND status = 'Pendent' LIMIT 1";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$iduser);
                $query->execute();
                $res=$query->fetch();
                $idrese = $res['id'];
                $preu2 = $res['preu_res'];
                $total_preu = $preu2 + $preuservei;
                
                $sql="UPDATE reserves SET preu_res = ? WHERE  id = ?";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$total_preu);
                $query->bindParam(2,$idrese);
                $query->execute();
                //$res=$query->fetch();
                
                $sql="INSERT INTO serveis_reservats (idservei, idreserva, dataRes, places, preu_servei) VALUES (?, ?, curdate(), ?, ?)";
                $query=$this->db->prepare($sql);
                $query->bindParam(1,$idservei);
                $query->bindParam(2,$idreserva);
                $query->bindParam(3,$personas);
                $query->bindParam(4,$preuservei);
                $query->execute();              
            }
            return 0;
        }else{
            return 1;
        }
    }
    
    /**
    * 
    * Rep com a parametres el id de l'usuari i realitza una consulta SELECT per extreure les dades de la seva reserva. 
    *
    * @param string $usuari conte el identificador de l'usuari
    * @param string $sql conte la consulta sql a realitzar
    * @param string $idreserva conte el id de la reserva 
    * @param float $preu conte el valor de la reserva
    * @param string $data conte la data de ultima modificacio de la reserva
    * @param string $array conte la informacio de la reserva
    *
    * @return array $array
    */ 
    public function datos_reserva($usuari){
        $sql="SELECT * FROM reserves WHERE idusuari = ? AND status = 'Pendent' LIMIT 1";
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$usuari);
        $query->execute();
        $res=$query->fetch();
        $filas=$query->rowCount();       
        
        if($filas==0){
            return 0;            
        }else{
            $idreserva = $res['id'];
            $preu = $res['preu_res'];
            $data = $res['data_res'];
            
            //
            /*$sql="SELECT * FROM serveis_reservats sr INNER JOIN serveis s ON sr.idservei=s.id WHERE idreserva = ?";    
            $query=$this->db->prepare($sql);
            $query->bindParam(1,$idreserva);
            $query->execute();
            if($query->rowCount()>=1){
                while($res=$query->fetch()){
                    
                }
            }*/
            //
            
            $array = array($idreserva, $preu, $data);
            return $array;            
        }       
    }
    
    /**
    * 
    * Rep com a parametres el id de l'usuari i realitza una consulta SELECT i DELETE. 
    *
    * @param string $usuari conte el identificador de l'usuari
    * @param string $sql conte la consulta sql a realitzar
    * @param string $idreserva conte el id de la reserva a eliminar
    *
    * @return void
    */ 
    public function eliminar_reserva($usuari){
        $sql="SELECT * FROM reserves WHERE idusuari = ? AND status = 'Pendent' LIMIT 1";
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$usuari);
        $query->execute();
        $res=$query->fetch();
        
        $idreserva = $res['id']; 
        
        $sql="DELETE FROM serveis_reservats WHERE idreserva = ?";
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$idreserva);
        $query->execute();
        
        $sql="DELETE FROM reserves WHERE idusuari = ? AND status = 'Pendent'";
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$usuari);
        $query->execute();
        
    }
}
