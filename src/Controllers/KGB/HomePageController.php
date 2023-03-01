<?php

namespace App\Controllers;

use APP\Entity\Agent;
use APP\Entity\Contact;
use APP\Entity\Hideout;
use APP\Entity\Mission;
use APP\Entity\Target;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;
use Setup_config;

class HomePageController extends PageController
{

  public function __construct(){
    parent::__construct();

    $this->title = 'Home Page';
    $this->name = 'home';
    
    $this->style = ABS_PATH . '/templates/web/css/home.css';
    
  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $id_mission = 0;

    if (isset($_GET['mission'])) {

      $id_mission = intval($_GET['mission']);

    }

    if (is_int($id_mission) && $id_mission !== 0) {

      $mission = $dbrequest->requestProcedure('get_mission', [$id_mission]);

      if ( count($mission) < 1) {

        AgoraController::getInstance()->notfound_redirect();

      }

      $this->title = 'Mission ' . $id_mission;
      $this->name = 'mission';

      AgoraController::getInstance()->render($this->viewPath, $this->template, 'web.html.'.$this->name.'_index', [
        'mission' => $mission,
      ]);
      $dbrequest->close($dbrequest);
      exit();

    } 

    $missions = $dbrequest->requestSpecific("SELECT * FROM mission");
    $missions_types = $dbrequest->requestSpecific("SELECT * FROM speciality");
    $missions_country = $dbrequest->requestSpecific("SELECT * FROM country");
    $missions_status = $dbrequest->requestSpecific("SELECT * FROM mission_status");

    $dbrequest->close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'web.html.'.$this->name.'_index', [
      'missions' => $missions,
      'missions_types' => $missions_types,
      'missions_country' => $missions_country,
      'missions_status' => $missions_status
    ]);

  }
  
}