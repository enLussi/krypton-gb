<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;

class AdminHideoutController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    // $this->script = ABS_PATH . '/templates/backoffice/js/dashboard.js';

  }

  public function index() {
    

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.dashboard', [
    ]);
    
  }
}