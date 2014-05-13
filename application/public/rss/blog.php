<?php
   $filename = "{APP_W}/application/public/rss/rss.xml";
   header("Content-type:text/xml");
   readfile ($filename);
?>