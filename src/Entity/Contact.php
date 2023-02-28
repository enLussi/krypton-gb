<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Contact extends Person{

  private string $name_code;

  private function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $contact = $dbrequest->requestProcedure('get_contact', [$id]);

    parent::__construct(
      $contact[0]['lastname'], 
      $contact[0]['firstname'],  
      $contact[0]['birthdate'], 
      $contact[0]['nationality']);

    $this->name_code = $contact[0]['name_code'];
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

    $contact = $dbrequest->requestProcedure('new_contact', $arguments);

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