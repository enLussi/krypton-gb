<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;

class AdminDashboardController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Dashboard';

    $this->self_directory = basename(dirname(__DIR__)) . '/' . basename(__DIR__);

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/backoffice/js/dashboard.js';

  }

  public function index() {

    $config = json_decode(file_get_contents(ABS_PATH . '/config/admin/config.json'), true);
    
    if (isset($_POST['title-website'])) {
      $post = $_POST;
      $config['upkeep'] = isset($post['upkeep-checkbox']);
      $config['error_display'] = isset($post['error-checkbox']);
      $config['cookie_enabled'] = isset($post['cookie-checkbox']);
      $config['cookie_duration'] = $post['cookie-duration'];
      $config['contact'] = $post['email-contact'];
      $config['site_name'] = $post['title-website'];
      $config['site_description'] = $post['description-website'];
      $config['upkeep_message'] = $post['upkeep-message'];

      file_put_contents(ABS_PATH . '/config/admin/config.json', json_encode($config, JSON_PRETTY_PRINT));
    }

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'backoffice.html.dashboard', [
      'config' => $config
    ]);
    
  }
}