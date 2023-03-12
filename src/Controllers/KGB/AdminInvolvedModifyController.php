<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;
use Exception;

class AdminInvolvedModifyController extends AdminPageController
{

  private $post;

  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

  }

  public function index() {

    if(isset($_POST) && count($_POST) > 0) {

      $this->post = $_POST;
    
      if(isset($_POST['modify']) && intval($_POST['modify'])) {

        try {
          $this->modify();
        } catch (Exception $e) {
          AgoraController::getInstance()->issue_redirect(201);
        }
        

      } elseif(isset($_POST['remove']) && $_POST['remove'] == true ) {

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
    
  }

  private function modify() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $dbrequest->requestSpecific(
      "UPDATE person SET 
        lastname = '".addslashes($this->post['lastname'])."', 
        firstname = '".addslashes($this->post['firstname'])."', 
        birthdate = '".$this->post['birthdate']."', 
        country_id = ".intval($this->post['country']).", 
        name_code = '".addslashes($this->post['name_code'])."' 
      WHERE row_id = ".intval($this->post['id'])
    );

    if(count($dbrequest->requestSpecific("SELECT * FROM agent WHERE agent_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_agent_spe WHERE agent_id=".$this->post['id']
      );
      $dbrequest->requestSpecific(
        "DELETE FROM agent WHERE agent_id=".$this->post['id']
      );
    }
    if(count($dbrequest->requestSpecific("SELECT * FROM contact WHERE contact_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM contact WHERE contact_id =".$this->post['id']
      );
    }
    if(count($dbrequest->requestSpecific("SELECT * FROM target WHERE target_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM target WHERE target_id =".$this->post['id']
      );
    }

    switch($this->post['involved']) {
      case "1":
        $dbrequest->requestSpecific("INSERT INTO agent (agent_id) VALUES (".$this->post['id'].")");
        foreach($this->post['type'] as $type) {
          $dbrequest->requestProcedure(('assign_spe_to_agent'), [
            $this->post['id'],
            intval($type)
          ]);
        }
        break;
      case "2":
        $dbrequest->requestSpecific("INSERT INTO contact (contact_id) VALUES (".$this->post['id'].")");
        break;
      case "3":
        $dbrequest->requestSpecific("INSERT INTO target (target_id) VALUES (".$this->post['id'].")");
        break;
      default:
        break;
    }
    DatabaseRequest::close($dbrequest);
  }

  private function remove() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_person WHERE person_id=".$this->post['id']
    );

    if(count($dbrequest->requestSpecific("SELECT * FROM agent WHERE agent_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM assoc_agent_spe WHERE agent_id=".$this->post['id']
      );
      $dbrequest->requestSpecific(
        "DELETE FROM agent WHERE agent_id=".$this->post['id']
      );
    }
    if(count($dbrequest->requestSpecific("SELECT * FROM contact WHERE contact_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM contact WHERE contact_id =".$this->post['id']
      );
    }
    if(count($dbrequest->requestSpecific("SELECT * FROM target WHERE target_id =".$this->post['id'])) > 0) {
      $dbrequest->requestSpecific(
        "DELETE FROM target WHERE target_id =".$this->post['id']
      );
    }

    $dbrequest->requestSpecific("DELETE FROM person WHERE row_id = ".$this->post['id']);
    DatabaseRequest::close($dbrequest);
  }

  private function create () {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    switch($_POST['involved']) {
      case "1":
        $agent = $dbrequest->requestProcedure('new_agent', [
          "'".addslashes($this->post['lastname'])."'",
          "'".addslashes($this->post['firstname'])."'",
          "'".$this->post['birthdate']."'",
          intval($this->post['country']),
          "'".addslashes($this->post['name_code'])."'"
        ]);
        foreach($this->post['type'] as $type) {
          $dbrequest->requestProcedure(('assign_spe_to_agent'), [
            $agent[0]['out_param'],
            intval($type)
          ]);
        }
        break;
      case "2":
        $dbrequest->requestProcedure('new_contact', [
          $this->post['lastname'],
          $this->post['firstname'],
          $this->post['birthdate'],
          intval($this->post['country']),
          $this->post['name_code']
        ]);
        break;
      case "3":
        $dbrequest->requestProcedure('new_target', [
          $this->post['lastname'],
          $this->post['firstname'],
          $this->post['birthdate'],
          intval($this->post['country']),
          $this->post['name_code']
        ]);
        break;
      default:
        break;
    }
    DatabaseRequest::close($dbrequest);
  }
}