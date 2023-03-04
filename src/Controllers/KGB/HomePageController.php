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
      $mission_agent = $dbrequest->requestSpecific(
        "SELECT * FROM person 
        INNER JOIN (
          SELECT * FROM assoc_mission_person
          ) AS a ON row_id = a.person_id 
        INNER JOIN (
          SELECT * FROM agent
          ) AS b ON person_id = b.agent_id
        INNER JOIN (
          SELECT noun, adjective, row_id AS cid FROM country
          ) AS c ON country_id = c.cid
        INNER JOIN (
          SELECT agent_id AS aid, spe_id FROM assoc_agent_spe
          ) AS d ON agent_id = d.aid
        INNER JOIN (
          SELECT row_id AS srid, spe_name FROM speciality
          ) AS e ON spe_id = e.srid
          WHERE mission_id =".$id_mission);

      $mission_spec_agents = [];
      foreach($mission_agent as $m)(
        $mission_spec_agents = [...$mission_spec_agents, $dbrequest->requestSpecific(
          "SELECT * FROM assoc_agent_spe
          INNER JOIN (
            SELECT row_id AS srid, spe_name FROM speciality
            ) AS e ON spe_id = e.srid
          WHERE agent_id =".$m['agent_id'])]
      );


      if ( count($mission) < 1) {

        AgoraController::getInstance()->notfound_redirect();

      }

      $this->title = 'Mission ' . $id_mission;
      $this->name = 'mission';

      AgoraController::getInstance()->render($this->viewPath, $this->template, 'web.html.'.$this->name.'_index', [
        'mission' => $mission,
        'mission_agent' => $mission_agent,
        'mission_spec_agents' => $mission_spec_agents
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
      'missions_status' => $missions_status,
    ]);

  }
  
}