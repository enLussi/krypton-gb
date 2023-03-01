<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminFetchInvolvedByCountryController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    if (isset($_POST['country'])){

      $id_country = $_POST['country'];

      $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

      header("Content-Type: application/json");
  
      $missions_agent = $dbrequest->requestSpecific(
        "SELECT * FROM person INNER JOIN (SELECT * FROM agent) AS a ON row_id = a.agent_id WHERE country_id = ".$id_country
      );
      echo json_encode($missions_agent);

    }


    
  }
}