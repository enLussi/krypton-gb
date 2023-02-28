<?php

class Setup_config {

  private array $db_config;

  public function __construct() {

    $agora = json_decode(file_get_contents(ABS_PATH . "/config/admin/agora.json"), true);
    $config = json_decode(file_get_contents(ABS_PATH . "/config/admin/config.json"), true);

    foreach($agora as $key => $var){

      $_ENV[$key] = $var;

    }

    $_SERVER['upkeep'] = $config['upkeep'];
    $_SERVER['cookie_enabled'] = $config['cookie_enabled'];
    $_SERVER['cookie_duration'] = $config['cookie_duration'];

    /**
     * Set error display ini_set
     */
    if($config['error_display']) {

      ini_set('display_errors', 'on');

    } else {

      ini_set('display_errors', 'off');

    }

    ini_set("session.gc_maxlifetime", $config['cookie_duration']);
    ini_set("session.cookie_lifetime", $config['cookie_duration']);
    
    $db_params = explode('/', $_ENV['DATABASE_VAR']);

    $this->db_config = [
      'host' => $db_params[0],
      'name' => $db_params[1],
      'user' => $db_params[2],
      'pass' => $db_params[3]
    ];
    
  }

  public function getDBConfig() {
    return $this->db_config;
  }
}

?>