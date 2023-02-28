<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Target extends Person{

  private string $name_code;

  private function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $target = $dbrequest->requestProcedure('get_target', [$id]);

    parent::__construct(
      $target[0]['lastname'], 
      $target[0]['firstname'], 
      $target[0]['birthdate'], 
      $target[0]['nationality']);

    $this->name_code = $target[0]['name_code'];
  }

  public static function targetByID(int $id) {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $target = $dbrequest->requestProcedure('get_target', [$id]);

    if (count($target) > 0){
      $instance = new self(
        $target[0]['target_id']
      );

      return $instance;
    }

    return false;
  }

  public static function newTarget(string $lastname, string $firstname, string $birthdate, int $country, string $name_code) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $arguments = [
      $lastname, $firstname, $birthdate, $country, $name_code
    ];

    $contact = $dbrequest->requestProcedure('new_target', $arguments);

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