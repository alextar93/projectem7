<html>
  <head>
    <title>RSS Alex Travel</title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
     <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
     <link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estilos.css">
    <script>
      $(document).ready(function (){
       var url="../rss/blog.php"; //iniciar la url d'on estarà l'adreça del rss
       setTimeout(function(){
         load_page(url, "#rss");
       } , 1000);
       //funció que carrega el rss passats 1s. (el#, és per indicar que és un id)
    });

     function load_page(url,id_contenidor){
        var xml = $.ajax({ //començo el AJAX i li assigno les propietats
             url: url, // la url
             success: function(xml){// quan tingui èxit
                $(id_contenidor).html("");//esborrar el missatge "loading...""
                load_rss(xml, id_contenidor);//crido la funció que me mostrara les entrades, xml equival a l'arxiu xml de la web que hi hagi en blog.php
       }
     });
    }

    function load_rss(xml, id_contenidor){
       var limit = xml.getElementsByTagName('item').length; //obtinc la quantitat d'entrades
       var rss = ""; //començo el string
       for (var l=1; l<=limit; l++){ // un for desde 1 fins la quantitat de'entrades
    //obtinc titol vincle data de publicació i descripció
      var title = xml.getElementsByTagName('title').item(l+1).firstChild.data;
      var link = xml.getElementsByTagName('link').item(l+1).firstChild.data;
      var pubDate = xml.getElementsByTagName('pubDate').item(l- 1).firstChild.data;
      var description = xml.getElementsByTagName('description').item(l+1).firstChild.data;
      var date = pubDate.split("+",1);
      rss = "<data>"+date+"<data><br/><titol><a href=\""+link+"\">"+title+"</a></titol><br/><descripcio>"+description+"</descripcio><hr />";//relleno el string con la información
      $(id_contenidor).append(rss);//l'agrego en el contenidor rss

      }
    }
    </script>
  </head>
  
  <body>
         <header>
             <a href="{APP_W}/index"><h1>Alex Travel</h1></a>
    </header>
        <div id="breadcrumbs">HOME <img src="{APP_W}/application/public/img/flecha.png"/> RSS</div>
        <div id="formu">
            <div>
                <h1>RSS</h1>
                
                <div id="rss">
                    <load>Loading...</load>
                </div>
                
            </div>

            <a href="{APP_W}/index">Tornar</a>
        </div>
    </body>


</html>