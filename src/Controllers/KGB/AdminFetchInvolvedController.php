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
    //header("Content-Type: application/json");

    $agent = $dbrequest->requestSpecific(
      "SELECT * FROM person 
      INNER JOIN (SELECT * FROM agent) AS a ON row_id = a.agent_id
      INNER JOIN (SELECT row_id as cid, noun, adjective FROM country) AS b ON country_id = b.cid"
    );

    // var_dump($agent);

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


















    // if (isset($_POST['country'])){

    //   $id_country = $_POST['country'];

    //   $missions_contact = $dbrequest->requestSpecific(
    //     "SELECT * FROM person 
    //     INNER JOIN (
    //       SELECT * FROM contact
    //       ) AS a ON row_id = a.contact_id
    //     INNER JOIN (
    //       SELECT row_id AS cid, adjective, noun FROM country
    //       ) AS b ON country_id = cid
    //     WHERE country_id = ".$id_country
    //   );

    //   $missions_hideout = $dbrequest->requestSpecific(
    //     "SELECT * FROM hideout 
    //     INNER JOIN (
    //       SELECT noun, row_id AS cid FROM country
    //       ) AS a ON country_id = a.cid 
    //     INNER JOIN (
    //       SELECT row_id AS hid, label FROM hideout_type 
    //       ) AS b ON type_id = b.hid
    //     WHERE country_id = ".$id_country
    //   );

    //   $missions = [ 
    //     'contacts' => $missions_contact,
    //     'hideouts' => $missions_hideout
    //   ];

    //   echo json_encode($missions);
    //   DatabaseRequest::close($dbrequest);
    //   exit();

    // }

    // if (isset($_POST['type']) && isset($_POST['target'])) {
    //   $id_type = $_POST['type'];
    //   $id_target = $_POST['target'];

    //   $country_target = $dbrequest->requestSpecific(
    //     "SELECT country_id FROM person 
    //     WHERE row_id = ".$id_target
    //   );

    //   if(count($country_target)>0) {
    //     $missions_agent = $dbrequest->requestSpecific(
    //       "SELECT * FROM kgb.person INNER JOIN (
    //         SELECT * FROM kgb.agent INNER JOIN (
    //         SELECT agent_id AS aid, spe_id FROM kgb.assoc_agent_spe
    //         ) AS b ON agent_id = b.aid
    //       ) AS a ON row_id = a.agent_id 
    //       LEFT JOIN kgb.country ON country_id = kgb.country.row_id
    //       WHERE (spe_id = ".$id_type.") AND (kgb.country.row_id != ".$country_target[0]['country_id'].")"
    //     );

    //     echo json_encode([
    //       'agents' => $missions_agent
    //       ]
    //     );
    //   }

    //   DatabaseRequest::close($dbrequest);
    //   exit();
      
    // }
    

    DatabaseRequest::close($dbrequest);
    
  }
}