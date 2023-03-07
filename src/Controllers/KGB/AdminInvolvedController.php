<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminInvolvedController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/involved.js';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $involved = [];

    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM speciality"
    );

    if(isset($_GET['agent']) && $_GET['agent'] > 0) {

      $involved = $dbrequest->requestProcedure('get_agent', [$_GET['agent']])[0];
      $specialities = [];

      foreach($dbrequest->requestProcedure('get_spe_of_agent', [$_GET['agent']]) as $spe) {
        array_push($specialities, $spe['spe_id']);
      }
      $involved = [...$involved, 'specialities' => $specialities];

    }
    if(isset($_GET['contact']) && $_GET['contact'] > 0) {

      $involved = $dbrequest->requestProcedure('get_contact', [$_GET['contact']])[0];

    }
    if(isset($_GET['target']) && $_GET['target'] > 0) {

      $involved = $dbrequest->requestProcedure('get_target', [$_GET['target']])[0];

    }

    DatabaseRequest::close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.involved', [
      'country' => $country,
      'type' => $type,
      'involved' => $involved
    ]);
    
  }
}