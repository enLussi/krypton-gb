<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminSendNewMissionController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    // $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $post = $_POST;

    

    $mission_id = $dbrequest->requestProcedure('new_mission', [
      "'".$post['title-mission']."'", 
      "'".$post['description-mission']."'", 
      "'".$post['name_code']."'", 
      2, 
      1, 
      "'".$post['start']."'", 
      "'".$post['end']."'"
    ]);

    foreach($post['agent'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }
    
    foreach($post['contact'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }
    foreach($post['target'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }

    DatabaseRequest::close($dbrequest);
    
  }
}