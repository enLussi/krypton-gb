<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

class Contact extends Person{

  private string $name_code;

  public function __construct(int $id)
  {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $contact = $dbrequest->requestProcedure('get_contact', [$id]);

    parent::__construct($contact[0]['lastname'], $contact[0]['firstname'], DateTime::createFromFormat('Y-m-d', $contact[0]['birthdate']));

    $this->name_code = $contact[0]['name_code'];
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