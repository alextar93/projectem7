<?php

/**
 * Session: proporciona la configuracio de les variables de sessio a l'aplicacio
 *
 * @author Alex
 */
class Session
{
    /**
     * Inicia la sessio
     */
    public static function init()
    {
        session_start();
    }
    
    /**
     * Destrueix les variables de sessio, si li passem un valor destrueix aquesta, si no, les destrueix totes.
     */
    public static function destroy($key = false)
    {
        if($key){
            if(is_array($key)){
                for($i = 0; $i < count($key); $i++){
                    if(isset($_SESSION[$key[$i]])){
                        unset($_SESSION[$key[$i]]);
                    }
                }
            }
            else{
                if(isset($_SESSION[$key])){
                    unset($_SESSION[$key]);
                }
            }
        }
        else{
            session_destroy();
        }
    }
    
    /**
     * Crea una variable de sessio amb les dades que li passem a la funcio, essent una la clau, i l'altre el valor.
     * @param string $clave
     * @param string $valor
     */
    public static function set($clave, $valor)
    {
        if(!empty($clave)){
        $_SESSION[$clave] = $valor;}
    }
    
    /**
     * Retorna el valor de la sessio amb la clau que indiquem a la funcio.
     * @param string $clave
     * @return string
     */
    public static function get($clave)
    {
        if(isset($_SESSION[$clave])){
        return $_SESSION[$clave];}
    }
    
    /**
     * Comprova que la variable de sessio amb aquesta clau estigui definida, si esta definida retorna un true.
     * @param string $clave
     * @return boolean
     */
    public static function isget($clave)
    {
        if(isset($_SESSION[$clave])){
        return true;}
    }
    
}