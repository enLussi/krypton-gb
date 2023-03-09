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
    $this->script = TEMPLATES_PATH . '/web/js/home.js';
    
  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $id_mission = 0;

    if (isset($_GET['mission'])) {

      $id_mission = intval($_GET['mission']);

    }

    if (is_int($id_mission) && $id_mission !== 0) {

      $mission = Mission::missionByID($id_mission);

      if ( !$mission) {

        AgoraController::getInstance()->notfound_redirect();

      }

      $this->title = 'Mission ' . $id_mission;
      $this->name = 'mission';
      $this->script = '';
      $this->style = ABS_PATH . '/templates/web/css/mission.css';

      AgoraController::getInstance()->render($this->viewPath, $this->template, 'web.html.'.$this->name.'_index', [
        'mission' => $mission,
        // 'mission_agent' => $mission_agent,
        // 'mission_spec_agents' => $mission_spec_agents
      ]);
      $dbrequest->close($dbrequest);
      exit();

    } 
    $missions= [];
    foreach(
      $dbrequest->requestSpecific('SELECT row_id FROM mission') as $m) 
    {
      $missions = [...$missions, Mission::missionByID($m['row_id'])];
    }

    $missions_types = $dbrequest->requestSpecific("SELECT * FROM speciality");
    $missions_status = $dbrequest->requestSpecific("SELECT * FROM mission_status");
    $mission_country = $dbrequest->requestSpecific("SELECT * FROM country");


    $dbrequest->close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'web.html.'.$this->name.'_index', [
      'missions' => $missions,
      'missions_types' => $missions_types,
      'missions_status' => $missions_status,
      'missions_country' => $mission_country,
    ]);

  }
  
}