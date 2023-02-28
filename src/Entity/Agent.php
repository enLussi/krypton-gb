<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Agent extends Person{

  private string $identification_code;

  public function __construct(int $id)
  {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $agent = $dbrequest->requestProcedure('get_agent', [$id]);

    parent::__construct(
      $agent[0]['lastname'], 
      $agent[0]['firstname'], 
      $agent[0]['birthdate'],
      $agent[0]['nationality']);

    $this->identification_code = $agent[0]['code_id'];
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

    $agent = $dbrequest->requestProcedure('new_agent', $arguments);

  }

  /**
   * Get the value of identification_code
   */ 
  public function getIdentification_code()
  {
    return $this->identification_code;
  }

  /**
   * Set the value of identification_code
   *
   * @return  self
   */ 
  public function setIdentification_code($identification_code)
  {
    $this->identification_code = $identification_code;

    return $this;
  }
}