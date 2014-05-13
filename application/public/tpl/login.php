<html lang="es">
    <head>
        <title>Login Alex Travel</title>
        <meta charset="utf-8"> 
        
        <link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estilos.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
        <script>

        </script>
        <style>
            #incuser{
                display: none;
                color: red;
            }
        </style>
    </head>
    <body>
    <header>
        <a href="{APP_W}/index"><h1>Alex Travel</h1></a>

    </header>
        <div id="breadcrumbs">HOME <img src="{APP_W}/application/public/img/flecha.png"/> LOGIN</div>
        <div id="formu">
            <div>
                <h1>Iniciar Sessió</h1>
                <form method="post" action="{APP_W}/login/login">   <!--llamo al controlador de login y su funcion login-->
                    <p><input type="text" name="email" value="" placeholder="Email" required></p>
                    <p><input type="password" name="password" value="" placeholder="Password" required></p>
                    <p class="remember_me">

                    </p>
                    <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
                </form>
            </div>
         
            <div class="login-help">
                <p class="registrarse">Ets un nou usuari? <a href="{APP_W}/register" id="nou_registre">Fes clic aquí per registrarte</a>.</p>
            </div>
            <a href="{APP_W}/index">Tornar</a>
            {html}
        </div>
    </body>

</html>