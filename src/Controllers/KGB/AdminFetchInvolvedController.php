<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminFetchInvolvedController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/mission.js';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    header("Content-Type: application/json");

    $agent = $dbrequest->requestSpecific(
      "SELECT * FROM person 
      INNER JOIN (SELECT * FROM agent) AS a ON row_id = a.agent_id
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );

    foreach ( $agent as $id => $a ) {

      $spe_by_agent = $dbrequest->requestSpecific(
        "SELECT spe_id FROM assoc_agent_spe WHERE agent_id = " . $a['row_id']
      );
      
      $spe_id = [];
      
      foreach($spe_by_agent as $spe) {
        $spe_id = [...$spe_id, $spe['spe_id']];
      }

      $agent[$id] = [...$agent[$id], 'spe' => $spe_id];
    }

    $contact = $dbrequest->requestSpecific(
      "SELECT * FROM person 
      INNER JOIN (SELECT * FROM contact) AS a ON row_id = a.contact_id
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );

    $target = $dbrequest->requestSpecific(
      "SELECT * FROM person 
      INNER JOIN (SELECT * FROM target) AS a ON row_id = a.target_id
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );

    $hideout = $dbrequest->requestSpecific(
      "SELECT * FROM hideout
      INNER JOIN (SELECT label, row_id AS hid FROM hideout_type) AS a ON row_id = a.hid
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );

    echo json_encode([
      'agent' => $agent,
      'contact' => $contact,
      'target' => $target,
      'hideout' => $hideout
    ]);
    
    DatabaseRequest::close($dbrequest);
    
  }
}