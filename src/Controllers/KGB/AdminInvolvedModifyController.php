<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminInvolvedModifyController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    if(isset($_POST) && count($_POST) > 0) {

      $post = $_POST;
      
      var_dump($post);
      if(isset($_POST['modify']) && intval($_POST['modify'])) {
        $dbrequest->requestSpecific(
          "UPDATE person SET lastname = '".$post['lastname']."', firstname = '".$post['firstname']."', birthdate = '".$post['birthdate']."', country_id = ".intval($post['country']).", name_code = '".$post['name_code']."' WHERE row_id = ".intval($post['id'])
        );

      } elseif(isset($_POST['remove']) && $_POST['remove'] == true ) {

        $dbrequest->requestSpecific(
          "DELETE FROM assoc_mission_person WHERE person_id=".$post['id']
        );

        if(count($dbrequest->requestSpecific("SELECT * FROM agent WHERE agent_id =".$post['id'])) > 0) {
          $dbrequest->requestSpecific(
            "DELETE FROM assoc_agent_spe WHERE agent_id=".$post['id']
          );
          $dbrequest->requestSpecific(
            "DELETE FROM agent WHERE agent_id=".$post['id']
          );
        }
        if(count($dbrequest->requestSpecific("SELECT * FROM contact WHERE contact_id =".$post['id'])) > 0) {
          $dbrequest->requestSpecific(
            "DELETE FROM contact WHERE contact_id =".$post['id']
          );
        }
        if(count($dbrequest->requestSpecific("SELECT * FROM target WHERE target_id =".$post['id'])) > 0) {
          $dbrequest->requestSpecific(
            "DELETE FROM kgb.target WHERE target_id =".$post['id']
          );
        }

        $dbrequest->requestSpecific("DELETE FROM person WHERE row_id = ".$post['id']);

      } else {

        switch($_POST['involved']) {
          case "1":
            $agent = $dbrequest->requestProcedure('new_agent', [
              "'".$post['lastname']."'",
              "'".$post['firstname']."'",
              "'".$post['birthdate']."'",
              intval($post['country']),
              "'".$post['name_code']."'"
            ]);
            foreach($post['type'] as $type) {
              $dbrequest->requestProcedure(('assign_spe_to_agent'), [
                $agent[0]['out_param'],
                intval($type)
              ]);
            }
            break;
          case "2":
            $dbrequest->requestProcedure('new_contact', [
              $post['lastname'],
              $post['firstname'],
              $post['birthdate'],
              intval($post['country']),
              $post['name_code']
            ]);
            break;
          case "3":
            $dbrequest->requestProcedure('new_target', [
              $post['lastname'],
              $post['firstname'],
              $post['birthdate'],
              intval($post['country']),
              $post['name_code']
            ]);
            break;
          default:
            break;
        }
      }

      

    } 

    DatabaseRequest::close($dbrequest);
    
  }
}