<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Contact extends Person{

  private function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $contact = $dbrequest->requestProcedure('get_contact', [$id]);

    parent::__construct(
      $id,
      $contact[0]['lastname'], 
      $contact[0]['firstname'],  
      $contact[0]['birthdate'], 
      $contact[0]['nationality'],
      $contact[0]['name_code']);
  }

  public static function contactByID(int $id) {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $contact = $dbrequest->requestProcedure('get_contact', [$id]);

    if (count($contact) > 0){
      $instance = new self(
        $contact[0]['contact_id']
      );

      return $instance;
    }

    return false;
  }

  public static function newContact(string $lastname, string $firstname, string $birthdate, int $country, 
    string $name_code) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $arguments = [
      $lastname, $firstname, $birthdate, $country, $name_code
    ];

    return self::contactByID($dbrequest->requestProcedure('new_contact', $arguments)[0]['out_param']);

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