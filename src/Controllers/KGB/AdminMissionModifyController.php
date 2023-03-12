<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;
use Exception;

class AdminMissionModifyController extends AdminPageController
{

  private $post;

  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    // $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    
    
    if(isset($_POST) && count($_POST) > 0){

      $this->post = $_POST;

      if(isset($this->post['modify']) && intval($this->post['modify'])) {

        try {
          $this->modify();
        } catch (Exception $e) {
          AgoraController::getInstance()->issue_redirect(201);
        }

      } elseif(isset($_POST['remove']) && $_POST['remove'] == true) {
        
        try {
          $this->remove();
        } catch (Exception $e) {
          AgoraController::getInstance()->issue_redirect(202);
        }
  
  
      } else {
  
        try {
          $this->create();
        } catch (Exception $e) {
          AgoraController::getInstance()->issue_redirect(203);
        }
  
      }

    } else {

      AgoraController::getInstance()->issue_redirect(204);

    }


    exit;
  }


  private function modify() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $dbrequest->requestSpecific(
      "UPDATE mission SET title = '".addslashes($this->post['title-mission'])."', descript='".addslashes($this->post['description-mission'])."', 
      name_code ='".addslashes($this->post['name_code'])."', mission_status_id = ".intval($this->post['status']).", 
      start_date = '".$this->post['start']."', end_date = '".$this->post['end']."', mission_type_id = ".intval($this->post['type'][0]).", 
      country_id = ".intval($this->post['country'])." WHERE row_id = ".intval($this->post['id'])
    );
    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_person WHERE mission_id=".$this->post['id']
    );
    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_hideout WHERE mission_id=".$this->post['id']
    );

    foreach($this->post['agent'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        intval($this->post['id'])
      ]);
    }
    
    foreach($this->post['contact'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        intval($this->post['id'])
      ]);
    }
    foreach($this->post['target'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        intval($this->post['id'])
      ]);
    }

    if(isset($this->post['hideout'])) {
      foreach($this->post['hideout'] as $hideout) {
        $dbrequest->requestProcedure('hideout_to_mission', [
          $hideout,
          intval($this->post['id'])
        ]);
      }
    }
    AgoraController::getInstance()->getEventDispatcher()->dispatch('modify', ['mission', intval($this->post['id'])]);
    DatabaseRequest::close($dbrequest);
  }

  private function remove() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_person WHERE mission_id=".$this->post['id']
    );
    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_hideout WHERE mission_id=".$this->post['id']
    );
    $dbrequest->requestSpecific(
      "DELETE FROM mission WHERE row_id = ".intval($this->post['id'])
    );
    AgoraController::getInstance()->getEventDispatcher()->dispatch('remove', ['mission', intval($this->post['id'])]);
    DatabaseRequest::close($dbrequest);
  }

  private function create() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $mission_id = $dbrequest->requestProcedure('new_mission', [
      "'".addslashes($this->post['title-mission'])."'", 
      "'".addslashes($this->post['description-mission'])."'", 
      "'".addslashes($this->post['name_code'])."'", 
      intval($this->post['country']), 
      intval($this->post['type'][0]), 
      "'".$this->post['start']."'", 
      "'".$this->post['end']."'",
      intval($this->post['status']),
    ]);

    foreach($this->post['agent'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }
    
    foreach($this->post['contact'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }
    foreach($this->post['target'] as $involved) {
      $dbrequest->requestProcedure('assign_to_mission', [
        $involved,
        $mission_id[0]['id']
      ]);
    }

    if(isset($this->post['hideout'])) {
      foreach($this->post['hideout'] as $hideout) {
        $dbrequest->requestProcedure('hideout_to_mission', [
          $hideout,
          $mission_id[0]['id']
        ]);
      }
    }
    AgoraController::getInstance()->getEventDispatcher()->dispatch('create', ['mission', intval($mission_id[0]['id'])]);
    DatabaseRequest::close($dbrequest);
  }
}