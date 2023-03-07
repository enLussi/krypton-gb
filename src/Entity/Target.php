<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Target extends Person{

  private function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $target = $dbrequest->requestProcedure('get_target', [$id]);

    parent::__construct(
      $id,
      $target[0]['lastname'], 
      $target[0]['firstname'], 
      $target[0]['birthdate'],  
      $target[0]['nationality'],
      $target[0]['name_code']);
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

    return self::targetByID($dbrequest->requestProcedure('new_target', $arguments)[0]['out_param']);

  }

  public function jsonSerialize() {
    return [
      'id' => $this->getID(),
      'lastname' => $this->getLastname(),
      'firstname' => $this->getFirstname(),
      'birthdate' => $this->getBirthdate(),
      'nationality' => $this->getNationality(),
      'name_code' => $this->getName_code(),
    ];
  }

}