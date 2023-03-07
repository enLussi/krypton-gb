<?php

namespace App\Controllers;

use APP\Entity\Agent;
use APP\Entity\Contact;
use APP\Entity\Target;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminInvolvedSearchController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

  }

  public function index() {

    header("Content-Type: application/json");

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $targets= [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT * FROM kgb.target) AS a ON row_id = a.target_id 
      WHERE name_code LIKE '".$_POST['search']."%'") as $t) 
    {
      $targets = [...$targets, Target::targetByID($t['row_id'])->jsonSerialize()];
    }

    $agents = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT * FROM agent) AS a ON row_id = a.agent_id 
      WHERE name_code LIKE '".$_POST['search']."%'") as $a) 
    {
      $agents = [...$agents, Agent::agentByID($a['row_id'])->jsonSerialize()];
    }

    $contacts = [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM person INNER JOIN (SELECT * FROM contact) AS a ON row_id = a.contact_id 
      WHERE name_code LIKE '".$_POST['search']."%'") as $c) 
    {
      $contacts = [...$contacts, Contact::contactByID($c['row_id'])->jsonSerialize()];
    }

    echo  json_encode([
      'agents' => $agents, 
      'contacts' => $contacts, 
      'targets' => $targets
    ]);

    DatabaseRequest::close($dbrequest);
    
  }
}