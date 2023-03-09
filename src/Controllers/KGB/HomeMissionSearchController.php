<?php

namespace App\Controllers;

use APP\Entity\Mission;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class HomeMissionSearchController extends PageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

  }

  public function index() {

    header("Content-Type: application/json");

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $req = "SELECT row_id FROM mission ".(($_POST['status'] > 0 || $_POST['type'] > 0 || $_POST['search'] !== "") ? " WHERE " : "")
    .($_POST['search'] !== "" ? "(name_code LIKE '".$_POST['search']."%')". (($_POST['status'] > 0 || $_POST['type'] > 0) ? " AND " : "") : "")
    .($_POST['status'] > 0 ? "mission_status_id = ".$_POST['status'].($_POST['type'] > 0 ? " AND " : "")  : "")
    .($_POST['type'] > 0 ? "mission_type_id = ".$_POST['type'] : "");

    $missions= [];
    foreach(
      $dbrequest->requestSpecific($req) as $m) 
    {
      $missions = [...$missions, Mission::missionById($m['row_id'])->jsonSerialize()];
    }
    $missions_types = $dbrequest->requestSpecific("SELECT * FROM speciality");
    $missions_status = $dbrequest->requestSpecific("SELECT * FROM mission_status");
    $mission_country = $dbrequest->requestSpecific("SELECT * FROM country");

    echo  json_encode([
      'missions' => $missions, 
      'type' => $missions_types,
      'status' => $missions_status,
      'country' => $mission_country,
    ]);
    DatabaseRequest::close($dbrequest);
    exit;
  }
}