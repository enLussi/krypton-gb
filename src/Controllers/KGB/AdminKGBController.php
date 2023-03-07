<?php

namespace App\Controllers;

use APP\Entity\Agent;
use APP\Entity\Contact;
use APP\Entity\Hideout;
use APP\Entity\Mission;
use APP\Entity\Target;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminKGBController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->style = ABS_PATH . '/templates/web/css/home.css';
    $this->script = ABS_PATH . '/templates/KGB/js/dashboard.js';

  }

  public function index() {
    
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $targets= [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT target_id AS row_id FROM kgb.target") as $t) 
    {
      $targets = [...$targets, Target::targetByID($t['row_id'])];
    }

    $agents = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT agent_id AS row_id FROM agent") as $a) 
    {
      $agents = [...$agents, Agent::agentByID($a['row_id'])];
    }

    $contacts = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT contact_id AS row_id FROM contact") as $c) 
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

    $missions = [];
    foreach ($dbrequest->requestSpecific('SELECT row_id FROM mission') as $mission) {
      $missions = [...$missions, Mission::missionById($mission['row_id'])];
    }

    $country = $dbrequest->requestSpecific("SELECT * FROM country");
    $status = $dbrequest->requestSpecific("SELECT * FROM mission_status");

    DatabaseRequest::close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.dashboard', [
      'agents' => $agents,
      'contacts' => $contacts,
      'targets' => $targets,
      'hideouts' => $hideouts,
      'missions' => $missions,
      'country' => $country,
      'status' => $status,
    ]);
    
  }
}