<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminMissionController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $dbrequest->close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.mission', [
    ]);
    
  }
}