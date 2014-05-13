<?php

/**
 * SPDO: proporciona acces a la base de dades
 *
 * @author Alex
 */
    class SPDO extends PDO
    {
            private static $instance = null;

            /**
             * Defineix el host, el nom de la base de dades, l'usuari i la contrassenya
             * Si falla, dona un missatge d'error.
             */
            public function __construct()
            {
                    $config = Config::getInstance();
                    try{
                        //coje datos de Config.json
                        parent::__construct($config->driver.':host=' . $config->dbhost . ';dbname=' .$config->dbname,$config->dbuser, $config->dbpass);}
                    catch (PDOException $e) {
                     echo 'Connection failed: ' . $e->getMessage();}

            }

            /**
             * Retorna una instancia
             */
            public static function singleton()
            {
                    if( self::$instance == null )
                    {
                            self::$instance = new self();
                    }
                    return self::$instance;
            }            
    }

