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

    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM speciality"
    );

    $status = $dbrequest->requestSpecific(
      "SELECT * FROM mission_status"
    );

    $target = $dbrequest->requestSpecific(
      "SELECT * FROM person 
      INNER JOIN (SELECT * FROM target) AS a ON row_id = a.target_id
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );
    
    DatabaseRequest::close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.mission', [
      "country" => $country,
      "type" => $type,
      "target" => $target,
      "status" => $status,
    ]);
    
  }
}