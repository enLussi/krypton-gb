<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminMissionModifyController extends AdminPageController
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
    var_dump($post);
    if(isset($_POST['modify']) && intval($_POST['modify'])) {
      $dbrequest->requestSpecific(
        "UPDATE mission SET title = '".$post['title-mission']."', descript='".addslashes($post['description-mission'])."', 
        name_code ='".$post['name_code']."', mission_status_id = ".intval($post['status']).", 
        start_date = '".$post['start']."', end_date = '".$post['end']."', mission_type_id = ".intval($post['type'][0]).", 
        country_id = ".intval($post['country'])." WHERE row_id = ".intval($post['id'])
      );
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_mission_person WHERE mission_id=".$post['id']
      );
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_mission_hideout WHERE mission_id=".$post['id']
      );

      foreach($post['agent'] as $involved) {
        $dbrequest->requestProcedure('assign_to_mission', [
          $involved,
          intval($post['id'])
        ]);
      }
      
      foreach($post['contact'] as $involved) {
        $dbrequest->requestProcedure('assign_to_mission', [
          $involved,
          intval($post['id'])
        ]);
      }
      foreach($post['target'] as $involved) {
        $dbrequest->requestProcedure('assign_to_mission', [
          $involved,
          intval($post['id'])
        ]);
      }

      if(isset($post['hideout'])) {
        foreach($post['hideout'] as $hideout) {
          $dbrequest->requestProcedure('hideout_to_mission', [
            $hideout,
            intval($post['id'])
          ]);
        }
      }

    } elseif(isset($_POST['remove']) && $_POST['remove'] == true) {
      
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_mission_person WHERE mission_id=".$post['id']
      );
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_mission_hideout WHERE mission_id=".$post['id']
      );
      $dbrequest->requestSpecific(
        "DELETE FROM mission WHERE row_id = ".intval($post['id'])
      );


    } else {

      $mission_id = $dbrequest->requestProcedure('new_mission', [
        "'".$post['title-mission']."'", 
        "'".$post['description-mission']."'", 
        "'".$post['name_code']."'", 
        intval($post['country']), 
        intval($post['type'][0]), 
        "'".$post['start']."'", 
        "'".$post['end']."'",
        intval($post['status']),
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

      if(isset($post['hideout'])) {
        foreach($post['hideout'] as $hideout) {
          $dbrequest->requestProcedure('hideout_to_mission', [
            $hideout,
            $mission_id[0]['id']
          ]);
        }
      }

    }

    

    DatabaseRequest::close($dbrequest);
    exit;
  }
}