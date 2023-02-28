<?php

namespace Core;

use Core\Controllers\AgoraController;

class Agora {

  private $settings;
  public $post;

  public function __construct($settings) {

    $this->settings = $settings;

    $_SERVER['runtime'] = $this;
    
    $this->load(); 
    
  }

  public function route_exists (array $routes, string $path) {

    foreach($routes as $key => $route) {
      if ( $route['path'] === $path) return $key;
    }
  
    return false;
  
  }

  public function getSettings () {
    return $this->settings;
  }

  private function load() {
    session_start();
  
    $origine = explode('?', $_SERVER['REQUEST_URI'])[0];
  
    $routes = json_decode(file_get_contents(ABS_PATH . '/config/routes/routes.json'), true);
  
    $APP = AgoraController::getInstance();
  
    $key = $this->route_exists($APP->getRoutes(), $origine);

  
    if ($key !== false) {
  
      $APP->redirect($origine);
  
    } else {
  
      $APP->notfound_redirect();
  
    }
  }

}
