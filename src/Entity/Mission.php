<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Mission {

  private int $id;

  private string $title;

  private string $description;

  private string $name_code;

  private string $country;

  private $agents = [];
  private $contacts = [];
  private $targets = [];

  private string $type;

  private string $status;

  private $hideouts = [];

  private string $start_date;

  private string $end_date;

  private function __construct(int $id, string $title, string $description, string $name_code, int $country, $agents, $contacts, 
   $targets, int $type, int $status, $hideouts, string $start_date, string $end_date)
  {
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->name_code = $name_code;
    $this->country = $country;
    $this->agents = $agents;
    $this->contacts = $contacts;
    $this->targets = $targets;
    $this->type = $type;
    $this->status = $status;
    $this->hideouts = $hideouts;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
  }

  public static function missionById(int $id) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $mission = $dbrequest->requestProcedure('get_mission', [$id]);

    if(count($mission) === 1) {

      $agents = $dbrequest->requestSpecific('
        SELECT row_id FROM person 
        INNER JOIN (
          SELECT agent_id FROM agent
          ) AS a ON row_id = agent_id
        INNER JOIN (
          SELECT mission_id, person_id FROM assoc_mission_person
          ) AS b ON row_id = person_id
        WHERE mission_id = '.$mission[0]['row_id']
      );
      $agent_array = [];
      foreach($agents as $agent) {
        $agent_array = [...$agent_array, Agent::agentByID($agent['row_id']) ];
      }

      $contacts = $dbrequest->requestSpecific('
        SELECT row_id FROM person 
        INNER JOIN (
          SELECT contact_id FROM contact
          ) AS a ON row_id = contact_id
        INNER JOIN (
          SELECT mission_id, person_id FROM assoc_mission_person
          ) AS b ON row_id = person_id
        WHERE mission_id = '.$mission[0]['row_id']
      );
      $contact_array = [];
      foreach($contacts as $contact) {
        $contact_array = [...$contact_array, Contact::contactByID($contact['row_id'])];
      }

      $targets = $dbrequest->requestSpecific('
        SELECT row_id FROM person 
        INNER JOIN (
          SELECT target_id FROM target
          ) AS a ON row_id = target_id
        INNER JOIN (
          SELECT mission_id, person_id FROM assoc_mission_person
          ) AS b ON row_id = person_id
        WHERE mission_id = '.$mission[0]['row_id']
      );
      $target_array = [];
      foreach($targets as $target) {
        $target_array = [...$target_array, Target::targetByID($target['row_id']) ];
      }

      $hideouts = $dbrequest->requestSpecific('
        SELECT row_id FROM hideout WHERE country_id = '.$mission[0]['country_id']
      );
      $hideout_array = [];
      foreach($hideouts as $hideout) {
        $hideout_array = [...$hideout_array, Hideout::hideoutByID($hideout['row_id'])];
      }

      $instance = new self(
        $id,
        $mission[0]['title'],
        $mission[0]['descript'],
        $mission[0]['name_code'],
        $mission[0]['country_id'],
        $agent_array,
        $contact_array,
        $target_array,
        $mission[0]['mission_type_id'],
        $mission[0]['mission_status_id'],
        $hideout_array,
        $mission[0]['start_date'],
        $mission[0]['end_date'],
      );
      DatabaseRequest::close($dbrequest);
      return $instance;
    }

    return false;
  }

  public static function newMission(string $title, string $description, string $name_code, int $country, array $agents, array $contacts, 
  array $targets, int $type, string $start_date, string $end_date, int $status) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    

    foreach( $contacts as $contact ) {
      $contact_data = $dbrequest->requestProcedure('get_contact', [$contact]);
      if ($country === $contact_data[0]['country_id']) {
        return "Le contact doit faire partie du pays où se déroule la mission.";
      }
    }
    
    $arguments = [
      $title, $description, $name_code, $country, $type, $start_date, $end_date, $status
    ];

    $mission = $dbrequest->requestProcedure('new_mission', $arguments);
    
    $persons = [...$agents, ...$contacts, ...$targets];

    foreach ($persons as $person) {

      $dbrequest->requestProcedure('assign_to_mission', [$person, $mission[0]['id']]);
    }

    return self::missionById($mission[0]['id']);

  }


  /**
   * Get the value of title
   */ 
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */ 
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of name_code
   */ 
  public function getName_code()
  {
    return $this->name_code;
  }

  /**
   * Set the value of name_code
   *
   * @return  self
   */ 
  public function setName_code($name_code)
  {
    $this->name_code = $name_code;

    return $this;
  }

  /**
   * Get the value of type
   */ 
  public function getType()
  {
    return $this->type;
  }

  /**
   * Set the value of type
   *
   * @return  self
   */ 
  public function setType($type)
  {
    $this->type = $type;

    return $this;
  }

  /**
   * Get the value of status
   */ 
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   *
   * @return  self
   */ 
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of start_date
   */ 
  public function getStart_date()
  {
    return $this->start_date;
  }

  /**
   * Set the value of start_date
   *
   * @return  self
   */ 
  public function setStart_date($start_date)
  {
    $this->start_date = $start_date;

    return $this;
  }

  /**
   * Get the value of end_date
   */ 
  public function getEnd_date()
  {
    return $this->end_date;
  }

  /**
   * Set the value of end_date
   *
   * @return  self
   */ 
  public function setEnd_date($end_date)
  {
    $this->end_date = $end_date;

    return $this;
  }

  /**
   * Get the value of country
   */ 
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * Set the value of country
   *
   * @return  self
   */ 
  public function setCountry($country)
  {
    $this->country = $country;

    return $this;
  }

  /**
   * Get the value of agents
   */ 
  public function getAgents()
  {
    return $this->agents;
  }

  /**
   * Set the value of agents
   *
   * @return  self
   */ 
  public function setAgents($agents)
  {
    $this->agents = $agents;

    return $this;
  }

  /**
   * Get the value of contacts
   */ 
  public function getContacts()
  {
    return $this->contacts;
  }

  /**
   * Set the value of contacts
   *
   * @return  self
   */ 
  public function setContacts($contacts)
  {
    $this->contacts = $contacts;

    return $this;
  }

  /**
   * Get the value of targets
   */ 
  public function getTargets()
  {
    return $this->targets;
  }

  /**
   * Set the value of targets
   *
   * @return  self
   */ 
  public function setTargets($targets)
  {
    $this->targets = $targets;

    return $this;
  }

  /**
   * Get the value of hideouts
   */ 
  public function getHideouts()
  {
    return $this->hideouts;
  }

  /**
   * Set the value of hideouts
   *
   * @return  self
   */ 
  public function setHideouts($hideouts)
  {
    $this->hideouts = $hideouts;

    return $this;
  }


  /**
   * Get the value of id
   */ 
  public function getID()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setID($id)
  {
    $this->id = $id;

    return $this;
  }
}