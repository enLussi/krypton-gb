<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Agent extends Person{

  private $specialities = [];

  public function __construct(int $id)
  {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $agent = $dbrequest->requestProcedure('get_agent', [$id]);

    foreach($dbrequest->requestProcedure('get_spe_of_agent', [$id]) as $spe) {
      array_push($this->specialities, $spe['spe_id']);
    }

    parent::__construct(
      $id,
      $agent[0]['lastname'], 
      $agent[0]['firstname'], 
      $agent[0]['birthdate'],
      $agent[0]['nationality'],
      $agent[0]['name_code']);
  }

  public static function agentByID(int $id) {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $agent = $dbrequest->requestProcedure('get_agent', [$id]);

    if (count($agent) > 0){
      $instance = new self(
        $agent[0]['agent_id']
      );

      return $instance;
    }

    return false;
  }

  public static function newAgent(string $lastname, string $firstname, string $birthdate, int $country, string $name_code, int $speciality) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $arguments = [
      $lastname, $firstname, $birthdate, $country, $name_code, $speciality
    ];

    return self::agentByID($dbrequest->requestProcedure('new_agent', $arguments)[0]['out_param']);

  }

  /**
   * Get the value of specialities
   */ 
  public function getSpecialities()
  {
    return $this->specialities;
  }

  /**
   * Set the value of specialities
   *
   * @return  self
   */ 
  public function setSpecialities($specialities)
  {
    $this->specialities = $specialities;

    return $this;
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getID(),
      'lastname' => $this->getLastname(),
      'firstname' => $this->getFirstname(),
      'birthdate' => $this->getBirthdate(),
      'nationality' => $this->getNationality(),
      'name_code' => $this->getName_code(),
      'specialities' => $this->getSpecialities(),
    ];
  }
}