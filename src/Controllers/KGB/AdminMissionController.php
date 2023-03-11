<?php

namespace App\Controllers;

use APP\Entity\Agent;
use APP\Entity\Contact;
use APP\Entity\Hideout;
use APP\Entity\Mission;
use APP\Entity\Target;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminMissionController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {
    

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    $mission = [];

    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM speciality"
    );

    $status = $dbrequest->requestSpecific(
      "SELECT * FROM mission_status"
    );

    $targets= [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT target_id FROM target) AS a ON row_id = a.target_id") as $t) 
    {
      $targets = [...$targets, Target::targetByID($t['row_id'])];
    }

    $agents = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT agent_id FROM agent) AS a ON row_id = a.agent_id") as $a) 
    {
      $agents = [...$agents, Agent::agentByID($a['row_id'])];
    }

    $contacts = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT contact_id FROM contact) AS a ON row_id = a.contact_id") as $c) 
    {
      $contacts = [...$contacts, Contact::contactByID($c['row_id'])];
    }


    $hideouts = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM hideout") as $h) 
    {
      $hideouts = [...$hideouts, Hideout::hideoutByID($h['row_id'])];
    }

    if(isset($_GET['mission']) && $_GET['mission'] > 0) {
      if(count($dbrequest->requestSpecific("SELECT * FROM mission WHERE row_id =".$_GET['mission'])) > 0){
        $mission = [...$mission, Mission::missionById($_GET['mission'])];

        if( $mission === false) {
          AgoraController::getInstance()->notfound_redirect();
          exit();
        }

        $involved_selected = $dbrequest->requestSpecific("SELECT * FROM assoc_mission_person WHERE mission_id =".$_GET['mission']);
        $hideout_selected = $dbrequest->requestSpecific("SELECT * FROM assoc_mission_hideout WHERE mission_id =".$_GET['mission']);

        AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.mission', [
          "country" => $country,
          "type" => $type,
          "targets" => $targets,
          "status" => $status,
          'agents' => $agents,
          'contacts' => $contacts,
          'hideouts' => $hideouts,
          'mission' => $mission,
          'involved-selected' => $involved_selected,
          'hideout-selected' => $hideout_selected,
        ]);

        DatabaseRequest::close($dbrequest);
        exit();
      } else {
        $this->script = '';
    
          AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.error', [
          'message' => 'L\'identifiant recherché ne correspond à aucune entrée de la base de donnée.'
        ]);
      }

    }

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.mission', [
      "country" => $country,
      "type" => $type,
      "targets" => $targets,
      "status" => $status,
      'agents' => $agents,
      'contacts' => $contacts,
      'hideouts' => $hideouts,
      'mission' => $mission,
    ]);
    DatabaseRequest::close($dbrequest);
  }
}