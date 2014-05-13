<?php

include('conexion_bbdd.php');	/*archivo con datos de la conexion a la base de datos*/

if($_POST) 
{ 
	$id_usuario = $_POST['indice'];

	$query = "select * from usuaris where email ='".$id_usuario."'"; 
    $results = mysql_query( $query) or die('ok'); 
      
    if(mysql_num_rows(@$results) > 0) // si es mayor a 0 es que existe 
    {
        while($row = mysql_fetch_row($results)){
            echo "<div>";
            echo "<p>Hola".$row[2]."</p>";
            echo "</div>";
        }
    }	
}
?>
