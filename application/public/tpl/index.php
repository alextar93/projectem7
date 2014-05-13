<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Alex Travel</title>
<link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estilos.css">
<script src="{APP_W}/application/public/js/jquery.js"></script>
<script src="{APP_W}/application/public/js/form.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{APP_W}/application/public/js/gmap3/gmap3.min.js"></script>

<script language="javascript">    
    var base_url;
    function ver_vols(){
        $("#vols").show();
        $("#hotels").hide();
        $("#plans").hide();
        $("#perfil").hide();
        $("#hotel").css('background-color', '');
        $("#hotel").css('box-shadow', '');
        $("#pla").css('background-color', '');
        $("#pla").css('box-shadow', '');
        $("#vol").css('background-color', '#FF0');
        $("#vol").css('box-shadow', '7px 0px 0px #888');
        $("#perfi").css('background-color', '');
        $("#perfi").css('box-shadow', '');
    }
    function ver_hot(){
        $("#vols").hide();
        $("#hotels").show();
        $("#plans").hide();
        $("#perfil").hide();
        $("#hotel").css('background-color', '#FF0');
        $("#hotel").css('box-shadow', '7px 0px 0px #888');
        $("#vol").css('background-color', '');
        $("#vol").css('box-shadow', '');
        $("#pla").css('background-color', '');
        $("#pla").css('box-shadow', '');
        $("#perfi").css('background-color', '');
        $("#perfi").css('box-shadow', '');
    }
    function ver_pla(){
        $("#vols").hide();
        $("#hotels").hide();
        $("#perfil").hide();
        $("#plans").show();
        $("#pla").css('background-color', '#FF0');
        $("#pla").css('box-shadow', '7px 0px 0px #888');
        $("#vol").css('background-color', '');
        $("#vol").css('box-shadow', '');
        $("#hotel").css('background-color', '');
        $("#hotel").css('box-shadow', '');
        $("#perfi").css('background-color', '');
        $("#perfi").css('box-shadow', '');
    }
    function ver_perf(){
        $("#vols").hide();
        $("#hotels").hide();
        $("#plans").hide();
        $("#perfil").show();
        $("#perfi").css('background-color', '#FF0');
        $("#perfi").css('box-shadow', '7px 0px 0px #888');
        $("#vol").css('background-color', '');
        $("#vol").css('box-shadow', '');
        $("#hotel").css('background-color', '');
        $("#hotel").css('box-shadow', '');
        $("#pla").css('background-color', '');
        $("#pla").css('box-shadow', '');
    }
    /*$("document").ready(function(){
    var l = window.location;
    base_url=l.protocol+"//"+l.host+"/"+l.pathname.split('/')[1];
    //alert(base_url);
    var u_email = $("#email_usuario").val();
    //alert(u_email);            
            $.ajax({
                //url: "datos_usuario.php",
                url: base_url+"/index/datos_usuario",
                type: "post",
                data: "indice="+u_email,
                success: function(retornado){   //creacion de variable retornado que guarda todo lo que devuelva la consulta ajax(validar.php)
                    $("#dat_usuario").html(retornado);
                }
            });
     });*/   
    
</script>
<style>
#hotels{
        display:none;
    }
#plans{
        display:none;
    }
#perfil{
        display: none;
    }
</style>
</head>

<body>
	
    <header>
    	<h1>Alex Travel</h1>
        <div id="registro" align="right">
             <?php
             if(Session::isget('islogged')==TRUE){ //funcion creada expresamente para saber si una variable de sesion esta definida, en Session.php y es publica, para que pueda acceder a ella
               echo "Bienvenido ".Session::get('user')->getNom();  
               echo "<br><a href='{APP_W}/user/logout'>Cerrar sesion</a>";
               echo "<br><a href='{APP_W}/reserva/carrito'><img src='{APP_W}/application/public/img/carrito.png'></a>";
             }else{
                 echo "<a href='{APP_W}/login'><img src='{APP_W}/application/public/img/registro.png'>&nbsp;&nbsp;Accedir</a>";  
             }
             ?>
        </div>
    </header>
    
    <ul>
        	<a><li id="vol" onclick="ver_vols()" style="background-color:#FF0; box-shadow: 7px 0px 0px #888;">Vols</li></a>
            <a><li id="hotel" onclick="ver_hot()">Hotels</li></a>
            <a><li id="pla" onclick="ver_pla()">Plans</li></a>
            <?php
             if(Session::isget('islogged')==TRUE){ //funcion creada expresamente para saber si una variable de sesion esta definida
               echo "<a><li id='perfi' onclick='ver_perf()'>Mi perfil</li></a>";  
             }
             ?>
            
    </ul>
    <div class="aplicacion" id="vols">    
    <p id="cercador">Cercador de vols</p>

    <form class="ajax" name="formvols" method="post" action="{APP_W}/index/cercar_vols" id="fovol">

        Origen: <select name="aeroport">   
            <option value="Barcelona" selected="selected">Barcelona</option> 
            <option value="Roma">Roma</option>
  	</select>
        Destí: <select name="desti">   
            <option value="Roma" selected="selected">Roma</option> 
            <option value="Barcelona">Barcelona</option>
  	</select> 
        Hora: <select name="hora_sortida">   
        	<option value="mes_barat" selected="selected">Més asequible</option> 
       		<option value="mati">Matí</option>
       		<option value="tarda">Tarda</option>
                <option value="nit">Nit</option>
  	</select>
        Arribada: <input type="date"/></br></br> 
        <br><br>
        <div align="right">
        <input type="submit" name="commit_vol" value="Cercar">
        </div>       
    </form>
    <div id="con_vols"></div>
    </div>
    
    
    <div class="aplicacion" id="hotels">    
    <p id="cercador">Cercador d'hotels</p>
    <!-- ********************************************************************Hotels -->
    <form class="ajax" name="formhotel" method="post" action="{APP_W}/index/cercar_hotels" id="fohotel">
    	
         Ciutat *: <select name="ciutat_hotel" required>   
                            <option value="Roma" selected="selected">Roma</option>
                            <option value="Barcelona">Barcelona</option>
  		</select><br><br>
        Nom de l'hotel: <input type="text" name="nom_hotel"/>
        <br><br>

        Categoria:<select name="categoria_hotel" required>
                                                <option value="0">Cualsevol</option>
       						<option value="1">1*</option>
       						<option value="2">2*</option>
      			 			<option value="3">3*</option>
                                                <option value="4">4*</option>
                                                <option value="5">5*</option>

  					</select>
<br><br>
        <div align="right">
        <input type="submit" name="commit_hotel" value="Cercar">
        </div>
    </form>
    <div id="con_hotels"></div>
 
    </div>
    
    
    <div class="aplicacion" id="plans">    
    <p id="cercador">Cercador de Plans de viatjes</p>
    <form class="ajax" name="formplans" method="post" action="{APP_W}/index/cercar_plans">
        Arribada: <input type="date"/>
        Persones:<select name="persones" required>
       						<option value="1">1</option>
       						<option value="2">2</option>
      			 			<option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
  					</select>

        <div align="right">
        <input type="submit" name="commit_pla" value="Cercar">
        </div>       
    </form>
    <div id="con_plans"></div>
 
    </div>
    
    <div class="aplicacion" id="perfil">    
    <p id="cercador">El meu perfil</p>
    <form method="post" action="{APP_W}/register/edit">
    <?php
    if(Session::isget('islogged')==TRUE){ //funcion creada expresamente para saber si una variable de sesion esta definida
         echo "Nom: <input type='text' name='nombre' value='".Session::get('user')->getNom()."' /><br>";
         echo "Cognoms: <input type='text' name='apellidos' value='".Session::get('user')->getCognoms()."' /><br>";
         echo "Email: <input type='text' name='email' value='".Session::get('user')->getEmail()."' /><br>";
         echo "Password: <input type='text' name='pass' value='".Session::get('user')->getPassword()."' />";
     }
         
    ?>
        <p class="submit"><input type="submit" name="commit_edit" value="Editar"></p>
    </form>

    </div>
    
    
    

<div id="banners" align="center">
    <a href="#"><img src="{APP_W}/application/public/img/venecia_banner.jpg"/></a>
    <a href="#"><img src="{APP_W}/application/public/img/ireland_banner.jpg"/></a>
    <a href="#"><img src="{APP_W}/application/public/img/roma_banner.png"/></a>
</div>
    
    <div id="footer">
    </div> 
    <div align="center" style="margin-top: 30px;">
        <a href="{APP_W}/rss"><img src="{APP_W}/application/public/img/rss.png"</a>
    </div>    
    
</body>
</html>