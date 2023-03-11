<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;
use Exception;

class AdminHideoutModifyController extends AdminPageController
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

    
    
  }

  private function modify() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $dbrequest->requestSpecific(
      "UPDATE kgb.hideout 
      SET 
        name_code = '".addslashes($this->post['name_code'])."', 
        address = '".addslashes($this->post['address'])."', 
        type_id = ".intval($this->post['hideout-type']).",
        country_id = ".intval($this->post['country'])."
    WHERE row_id = ".intval($this->post['id']));

    DatabaseRequest::close($dbrequest);
  }

  private function remove() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $dbrequest->requestSpecific(
      "DELETE FROM assoc_mission_hideout WHERE hideout_id=".$this->post['id']
    );

    $dbrequest->requestSpecific("DELETE FROM hideout WHERE row_id = ".$this->post['id']);
    DatabaseRequest::close($dbrequest);
  }

  private function create() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $dbrequest->requestProcedure('new_hideout', [
      "'".addslashes($this->post['name_code'])."'",
      "'".addslashes($this->post['address'])."'",
      intval($this->post['hideout-type']),
      intval($this->post['country'])
    ]);
    DatabaseRequest::close($dbrequest);
  }
}