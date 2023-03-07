<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminHideoutModifyController extends AdminPageController
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
          "UPDATE kgb.hideout 
          SET 
            name_code = '".$post['name_code']."', 
            address = '".$post['address']."', 
            type_id = ".intval($post['hideout-type']).",
            country_id = ".intval($post['country'])."
          WHERE row_id = ".intval($post['id']));
      } elseif(isset($_POST['remove']) && $_POST['remove'] == true) {

        $dbrequest->requestSpecific(
          "DELETE FROM assoc_mission_hideout WHERE hideout_id=".$post['id']
        );

        $dbrequest->requestSpecific("DELETE FROM hideout WHERE row_id = ".$post['id']);

      } else {
        $dbrequest->requestProcedure('new_hideout', [
          "'".$post['name_code']."'",
          "'".$post['address']."'",
          intval($post['hideout-type']),
          intval($post['country'])
        ]);
      }
      DatabaseRequest::close($dbrequest);
      exit();

    }

    
    
  }
}