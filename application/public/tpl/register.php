<html lang="es">
    <head>
        <title>Registre Alex Travel</title>
        <meta charset="utf-8"> 
        
        <link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estilos.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
        <script>
        $("document").ready(function(){
            $("#pass").blur(function(){
                $("#rep_cont").show("slow");
            });    
         });
        </script>
        <style>
            #rep_cont{
                display: none;
            }
            li{
		display: inline-block;
		margin-right: 3%;
		font-family: sans-serif;
		background-color: #9b59b6;
		padding-top: 1%;
		padding-bottom: 1%;
		border-radius: 10px 2px 10px 2px;
		cursor: pointer;
		box-shadow: 3px 3px #8e44ad;
		font-weight: bold;
                font-size: 10px;
	}
        </style>
    </head>
    <body>
         <header>
             <a href="{APP_W}/index"><h1>Alex Travel</h1></a>
    </header>
        <div id="breadcrumbs">HOME <img src="{APP_W}/application/public/img/flecha.png"/> REGISTRE</div>
        <div id="formu">
            <div>
                <h1>Registre</h1>
                <form method="post" action="{APP_W}/register/registrar_user">   <!--llamo al controlador de register y su funcion registrar_user-->
                    <table align="center">
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" name="email" value="" placeholder="Email" required></td>
                        </tr>
                        <tr>
                            <td>Contrassenya:</td>
                            <td><input type="password" name="password" value="" id="pass" placeholder="Password" required></td>
                        </tr>
                        <tr id="rep_cont">
                            <td>Repeteix contrassenya:</td>
                            <td><input type="password" name="password2" value="" placeholder="Re-type Password" required></td>
                        </tr>
                        <tr>
                            <td>Nom:</td>
                            <td><input type="text" name="nom" value="" placeholder="Nom" required></td>
                        </tr>
                        <tr>
                            <td>Cognoms:</td>
                            <td><input type="text" name="cognoms" value="" placeholder="Cognoms" required></td>
                        </tr>
                    </table>
                    <p class="submit"><input type="submit" name="commit" value="Registrar"></p>
                </form>
            </div>

            <a href="{APP_W}/login">Tornar</a>
        </div>
    </body>

</html>