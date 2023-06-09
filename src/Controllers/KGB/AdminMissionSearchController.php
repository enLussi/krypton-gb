<?php

namespace App\Controllers;

use APP\Entity\Mission;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;
use Exception;

class AdminMissionSearchController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    // $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    if(isset($_POST['search'])){
      try {
        $this->search();
      } catch (Exception $e) {
        AgoraController::getInstance()->issue_redirect(205);
      } 
    } else {
      AgoraController::getInstance()->issue_redirect(204);
    }   

  }

  private function search() {
    header("Content-Type: application/json");

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $missions= [];
    if(isset($_POST['search'])){
      foreach(
        $dbrequest->requestSpecific
        ("SELECT row_id FROM mission 
        WHERE (title LIKE '".$_POST['search']."%') OR name_code LIKE '".$_POST['search']."%'") as $m) 
      {
        $missions = [...$missions, Mission::missionById($m['row_id'])->jsonSerialize()];
      }
    }

    echo  json_encode([
      'missions' => $missions, 
    ]);
    DatabaseRequest::close($dbrequest);
  }
}