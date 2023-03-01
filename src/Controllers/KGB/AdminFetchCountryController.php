<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminFetchCountryController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {



    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    header("Content-Type: application/json");

    $missions_country = $dbrequest->requestSpecific("SELECT * FROM country");
    echo json_encode($missions_country);
    
  }
}