<?php
/**
 * Description of Config
 *  Registry de les configuracions
 * @author Alex
 */
class Config {
    private $data=array();
    
    static $instance;
    public static $database=array();
    
    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance=new self();
            return self::$instance;
        }
        else{ return self::$instance;            
        }
    }
    
   /**
   *  defineix la variable $data com un array.
   */
    private function __construct() {
        $this->data=array();
    }
   
   /**
   *  donat una clau i un valor, crea a l'array associatiu dades amb aquests valors
   * @return boolean
   */
  function __set($key, $var) {
    $this->data[$key] = $var;
    return true;
  }

  /**
   *  retorna el valor de l'array dades amb la clau especificada, si no existeix, retorna null
   * @param string $key
   * @return string
   */
  function __get($key) {
    if (isset($this->data[$key]) == false) {
      return null;
    }
    return $this->data[$key];
  }

  /**
   *  Treu un par clau/valor de l'array.
   */
  function __unset($data) {
    unset($this->data[$key]);
  }
  
   /**
   *  retorna les dades, en un array
   */
    public function getData(){
        return $this->data;
    }
    
    /**
    *  agafa les claus i els valors de l'array, i ho fica a altre array
     * @param array $arr_json conte les dades del fitxer Json
     * @param array $data es un array associatiu amb les dades de $arr_json
    */
    function JSON(){
        $arr_json=json_decode(file_get_contents(APP.'Config.json'));
        foreach ($arr_json as $key=>$value) {
            $this->data[$key] = $value;
        }
    }
}
