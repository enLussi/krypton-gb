<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminHideoutController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/hideout.js';

  }

  public function index() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $hideout = [];
    
    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM hideout_type"
    );

    if(isset($_GET['hideout'])) {
      if(count($dbrequest->requestSpecific("SELECT * FROM hideout WHERE row_id =".$_GET['hideout'])) > 0){

        $hideout = $dbrequest->requestProcedure('get_hideout', [$_GET['hideout']])[0]; 
      } else {
        $this->script = '';

        AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.error', [
        'message' => 'L\'identifiant recherché ne correspond à aucune entrée de la base de donnée.'
        ]);
      }

    }


    DatabaseRequest::close($dbrequest);


    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.hideout', [
      'country' => $country,
      'type' => $type,
      'hideout' => $hideout
    ]);
    
  }
}