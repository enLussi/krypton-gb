<?php

namespace Core\Controllers;

use AdminNavigation;
use App\Controllers\AdminLoginController;
use App\Controllers\AdminBlogPageController;
use App\Controllers\ErrorForbiddenController;
use App\Controllers\ErrorIssueController;
use App\Controllers\ErrorNotFoundController;
use App\Controllers\ErrorUpkeepController;
use App\Controllers\PageController;
use Core\Event\EventDispatcher;
use Core\Event\AgoraListener;
use Core\Agora;

class AgoraController
{

  public Agora $agora;

  protected string $UID = "0";

  protected PageController $controller;

  private static AgoraController $instance;

  private EventDispatcher $event;

  private $event_list = array();

  private $new_customer = [
    "time"=> 0
  ];

  private $routes = array();

  /**
   * Global data values where we can store everything we want
   */
  private $data = array();

  private function __construct(){

    $this->agora = $_SERVER['runtime'];

    $this->event = new EventDispatcher();

    $this->agora_event();

    $this->plugin_load();
    $this->loadRoutes();

    $this->set_cookie_uid();

  }
  private function __clone(){}

  public static function getInstance(): self {

    if(!isset(static::$instance)) {

      self::$instance = new AgoraController();

    }

    return self::$instance;

  }

  public function render($viewPath, $template, $view, $parameters = []) {
    ob_start();
    require_once $viewPath . '/' . str_replace('.', '/', $view) . '.php';
    $content = ob_get_clean();
    require_once $viewPath . '/' . $template . '.php';
  }

  public function display($viewPath, $view, $parameters = []) {
    ob_start();
    require_once $viewPath . '/' . str_replace('.', '/', $view) . '.php';
    $content = ob_get_clean();

    return $content;
  } 

  public function redirect($path) {
  
    $search = array_search($path, array_column($this->routes, 'path'));

    $class = $this->routes[array_keys($this->routes)[$search]]['controller'];

    if (!$_SERVER['upkeep'] || isset($_SESSION['admin_access']) && $_SESSION['admin_access'] === "access" || $path === "/admin") {

      $this->controller = new $class();

      $this->controller->index();

      $this->event->dispatch('redirect', $this->controller);


    } else {

      $this->maintenance_redirect(); 
      
    }

  }

  public function header_redirect($path) {

    header("Location: ".$path, true, 301);
    exit();

  }

  public function notfound_redirect() {

    $this->controller = new ErrorNotFoundController();
    $this->controller->index();

  }

  public function forbidden_redirect() {

    $this->controller = new ErrorForbiddenController();
    $this->controller->index();

  }

  public function issue_redirect(int $code_error = 0) {
    $this->controller = new ErrorIssueController($code_error);
    $this->controller->index();
  }

  public function maintenance_redirect() {

    $this->controller = new ErrorUpkeepController();
    $this->controller->index();

  }

  public function set_cookie_uid() {

    /**
     * Set cookie uid, set by first-party so no need to require consent from visitors
     */

    $uid = 0;
    
    if(!isset($_COOKIE['agora_id'])) {

      //Create the uid with random number
      $uid = dechex(random_int(100000,999999) . date('my'));
  
      setcookie('agora_id', $uid, time()+($_SERVER['cookie_duration']), "/");
    } else {

      $uid = $_COOKIE['agora_id'];

    }

    if(!isset($_SESSION['admin_access'])) {


      $this->new_customer['time'] = time();

      // -----------------------------------------
      //  Création d'une ligne Clients dans la BDD
      // (à changer de json à bdd)
      // -----------------------------------------
      if (!isset($_SESSION['customer'])) {
        
        $_SESSION['customer'] = [...$this->new_customer, 'uid' => $uid];

      } 


      // ----------------------------------------

    }

    $this->UID = $uid;

    // Set cookies that needs consent from visitors here
    if($_SERVER['cookie_enabled']) {

    }
      
  }


  /**
   * Get the value of UID
   */ 
  public function getUID()
  {
    return $this->UID;
  }

  public function getTitle() {

    return $this->controller->getTitle();

  }

  public function getStyle() {

    return $this->controller->getStyle();

  }

  public function getScript() {

    return $this->controller->getScript();

  }

  public function getEventDispatcher() {
    return $this->event;
  }

  public function getController() {
    return $this->controller;
  }

  public function setController(PageController $controller) {
    $this->controller = $controller;
  }

  public function getRoutes(){
    return $this->routes;
  }

  public function addRoutes(array $routes) {

    if (is_array($routes)){
      foreach($routes as $key => $route) {
        
        $this->routes = [...$this->routes, $key => $route];
      }
    } else {
      //$this->routes = [...$this->routes, $routes];
    }
    
  }

  public function getData() {
    return $this->data;
  }

  public function addData(array $data, string $key) {
    $this->data = [...$this->data, $key => $data];
  }

  private function loadRoutes(){
    $routes = json_decode(file_get_contents(ABS_PATH . '/config/routes/routes.json'), true);

    $this->addRoutes($routes);
  }

  public function agora_event() {

    $this->event->addListener('redirect', 'redirect', new AgoraListener);
    $this->event->addListener('admin_login', 'admin_login', new AgoraListener);
    $this->event->addListener('admin_logout', 'admin_logout', new AgoraListener);
    $this->event->addListener('load_plugin', 'load_plugin', new AgoraListener);
    $this->event->addListener('load_page', 'load_page', new AgoraListener);
    $this->event->addListener('load_admin', 'load_admin', new AgoraListener);

  }


  private function plugin_load(){

    $plugins = array_diff(scandir(CONTROLLERS_PATH), array('..', '.'));

    $anti_infinite = 0;

    while (count($plugins) > 0 ) {

      $can_be_load = true;


      $anti_infinite += 1;
      if ($anti_infinite > 100) {
        break;
      }

      $plugin = $plugins[array_key_first($plugins)];

      if (is_dir( CONTROLLERS_PATH . '/' . $plugin)) {

        $this->event->dispatch('load_plugin', CONTROLLERS_PATH . '/' . $plugin);

        if (file_exists(CONTROLLERS_PATH . '/' . $plugin . '/load.php')){

          $context= [];

          if (file_exists(CONTROLLERS_PATH . '/' . $plugin . '/context.json')) {
            $context = json_decode(file_get_contents(CONTROLLERS_PATH . '/' . $plugin . '/context.json'), true);
          }

          if(array_key_exists('dependencies', $context)) {
            $dependencies = $context['dependencies'];

            foreach($dependencies as $dep) {
              if (!in_array( $dep, $this->event_list )) {
                array_push($plugins, array_shift($plugins));
                $can_be_load = false;
              }
            }
          }


          if ($can_be_load) {
            require_once CONTROLLERS_PATH . '/' . $plugin . '/load.php'; 
            array_push($this->event_list, $plugin);
            
          }

        }

        if ($can_be_load) {
          array_shift($plugins);
        }

      }

    }

  }

}