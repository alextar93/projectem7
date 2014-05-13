<?php

/**
 * Description of IndexModel
 * El Model de Index s'encarrega de processar tota la informació que li passa el IndexController per fer consultes
 * a la base de dades mitjançant PDO
 *
 * @author Alex
 */
class IndexModel extends Model{
    
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->addDataout($arr);
    }

    /**
    * 
    * Rep com a parametres els valors de ciutat, nom i categoria, i realitza una consulta de tipus SELECT a la base
    * de dades, filtrant per aquests parametres.
    *
    * @param string $ciutat
    * @param string $nom 
    * @param int $categoria
    * @param string $html conte la informacio en format html trobada en base al filtrat de ciutat, nom i/o categoria a la bbdd. 
    *
    * @return string $html
    */    
    public function buscar_hotels($ciutat, $nom, $categoria){
        //if ciutat es nulo o nom es nulo
        $html="";
        try{
            if($nom!=null){
                $sql="SELECT * FROM hotels h INNER JOIN serveis s ON h.id=s.id WHERE nom = ? AND ciutat = ?"; 
                $query=$this->db->prepare($sql);
                //bind param
                $query->bindParam(1,$nom);	
                $query->bindParam(2,$ciutat);
            }else{
                if($categoria=="0"){
                    $sql="SELECT * FROM hotels h INNER JOIN serveis s ON h.id=s.id WHERE ciutat = ?";    
                    $query=$this->db->prepare($sql);
                    //bind param
                    $query->bindParam(1,$ciutat);
                }else{
                    $sql="SELECT * FROM hotels h INNER JOIN serveis s ON h.id=s.id WHERE ciutat = ? AND categoria = ?";    
                    $query=$this->db->prepare($sql);
                    //bind param
                    $query->bindParam(1,$ciutat);
                    $query->bindParam(2,$categoria);                    
                }                
            }
                //ejecucion del $query
           $query->execute();

                  if($query->rowCount()>=1){
                      $html.= "<table>";
                      while($res=$query->fetch()){                        
                        $html.= "<tr>";
                        $html.= "<td>".$res['nom']."</br><img src='".APP_W."/application/public/img/hotels/".$res['categoria'].".gif'></td>";
                        $html.= "<td><img src='".APP_W."/application/public/img/hotels/".$res['nom'].".jpg'></td>";
                        $html.= "<td><div id='map".$res['id']."' style='height:200px;width: 250px;background-color: blue;'></div></td>";
                        $html.= "<td>".$res['preu']." €</td>";
                        $html.= "<script>$(document).ready(function(){
                                $('#map".$res['id']."').gmap3({
                                marker:{
                                  latLng: [".$res['altitud'].", ".$res['latitud']."],
                                },    
                                map:{
                                      options:{
                                        zoom:15,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                                        mapTypeControl: false,
                                        mapTypeControlOptions: {
                                          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                                        },
                                        navigationControl: true,
                                        scrollwheel: true,
                                        streetViewControl: false,
                                        zoomControl: false
                                      }
                                    }
                                });
                            });</script>";
                        $html.= "<td><form name='".$res['id']."' method='post' action='".APP_W."/reserva/reservar'><select name='person'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option></select><input type='submit' name='res_hotel' value='RESERVAR'>";
                        $html.= "<input type='hidden' name='servei' value='".$res['id']."'></form></td>";
                        $html.= "</tr>";
                      }
                      $html.= "</table>";
                      return $html;                       
                  }else{
                        $html= "<div>";
                        $html.= "<p>No existeix cap hotel amb aquests parametres</p>";
                        $html.= "</div>";
                        return $html;
                  }           
        }catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}
    }
    
    /**
    * 
    * Rep com a parametres els valors de aeroport, desti i adults, i realitza una consulta de tipus SELECT a la base
    * de dades, filtrant per aquests parametres.
    *
    * @param string $aeroport
    * @param string $desti 
    * @param int $adults
    * @param string $html conte la informacio en format html trobada en base al filtrat de seroport de origen i de desti a la bbdd. 
    *
    * @return string $html
    */  
    public function buscar_vols($aeroport, $desti, $adults){
        $html="";
        try{
        $sql="SELECT * FROM vols v INNER JOIN serveis s ON v.id=s.id WHERE dest = ? AND aeroport = ?"; 
        $query=$this->db->prepare($sql);
        $query->bindParam(1,$desti);	
        $query->bindParam(2,$aeroport);
        $query->execute();
        
        if($query->rowCount()>=1){
           $html= "<table align='center'>";
           $html .="<tr><th>Aeroport sortida</th><th>Desti</th><th>Preu/persona</th><th>Persones</th><td></td>";
                while($res=$query->fetch()){
                    $html .="<tr><td>".$aeroport."</td><td>".$desti."</td><td>".$res['preu']." €</td>";
                    $html.= "<td><form name='".$res['id']."' method='post' action='".APP_W."/reserva/reservar'><select name='person'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option></select><input type='submit' name='res_vol' value='RESERVAR'>";
                    $html.= "<input type='hidden' name='servei' value='".$res['id']."'></form></td>";
                    $html.= "</tr>";
                          
                }
            $html.= "</table>";
            
        }else{
            $html= "<div>";
            $html.= "<p>No existeix cap vol amb aquests parametres</p>";
            $html.= "</div>";

        }
        }catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}
     return $html;        
    }
    
    /**
    * 
    * Rep com a parametres el valor de persones, i realitza una consulta de tipus SELECT a la base
    * de dades.
    *
    * @param int $persones
    * @param string $html conte la informacio en format html trobada de tots els plans disponibles. 
    *
    * @return string $html
    */ 
    public function buscar_plans($persones){
        $html="";
        try{
        $sql="SELECT * FROM plans p INNER JOIN serveis s ON p.id=s.id"; 
        $query=$this->db->prepare($sql);
        $query->execute();
        
        if($query->rowCount()>=1){
           $html= "<table>";
                while($res=$query->fetch()){
                    $html .="<tr><td><b>".$res['nom']."</b></td><td>".$res['descrip']."</td><td><img src='".APP_W."/application/public/img/plans/".$res['nom'].".jpg'></td><td>".$res['preu']." €</td>";
                    $html.= "<td><form name='".$res['id']."' method='post' action='".APP_W."/reserva/reservar'><input type='submit' name='res_pla' value='RESERVAR'>";
                    $html.= "<input type='hidden' name='servei' value='".$res['id']."'><input type='hidden' name='person' value='".$persones."'></form></td>";
                    $html.= "</tr>";
                          
                }
            $html.= "</table>";
            
        }else{
            $html= "<div>";
            $html.= "<p>No existeix cap pla amb aquestes caracteristiques</p>";
            $html.= "</div>";

        }
        }catch(PDOException $e){
		print "Error: ".$e->getMessage();
	}
     return $html;       
    }
    
}
