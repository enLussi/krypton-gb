<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Target extends Person{

  private string $name_code;

  public function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $target = $dbrequest->requestProcedure('get_target', [$id]);

    parent::__construct($target[0]['lastname'], $target[0]['firstname'], DateTime::createFromFormat('Y-m-d', $target[0]['birthdate']));

    $this->name_code = $target[0]['name_code'];
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
}