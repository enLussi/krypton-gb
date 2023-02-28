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

    parent::__construct($agent[0]['lastname'], $agent[0]['firstname'], DateTime::createFromFormat('Y-m-d', $agent[0]['birthdate']));

    $this->identification_code = $agent[0]['code_id'];
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