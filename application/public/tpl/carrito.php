<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Carrito Alex Travel</title>
        <meta charset="utf-8"> 
        
        <link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estilos.css">
        <script src="{APP_W}/application/public/js/jquery.js"></script>
        
        
        <script>
        $("document").ready(function(){
   
         });
        </script>
        <style>
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
        <div id="breadcrumbs">HOME <img src="{APP_W}/application/public/img/flecha.png"/> CARRITO</div>
        <div id="formu">
            <div>
                <h1>Carrito</h1>
                
                {html}
                
            </div>

            <a href="{APP_W}/index">Tornar</a>
        </div>
    </body>

</html>

