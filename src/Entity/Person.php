<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;
use DateTime;

abstract class Person {

  private int $ID;

  private string $lastname;

  private string $firstname;

  private string $birthdate;

  private string $nationality;

  protected function __construct(string $lastname, string $firstname, string $birthdate, string $nationality)
  {
    $this->lastname = $lastname;
    $this->firstname = $firstname;
    $this->birthdate = $birthdate;
    $this->nationality = $nationality;

  }

  /**
   * Get the value of lastname
   */ 
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @return  self
   */ 
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get the value of firstname
   */ 
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @return  self
   */ 
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of birthdate
   */ 
  public function getBirthdate()
  {
    return $this->birthdate;
  }

  /**
   * Set the value of birthdate
   *
   * @return  self
   */ 
  public function setBirthdate($birthdate)
  {
    $this->birthdate = $birthdate;

    return $this;
  }

  /**
   * Get the value of ID
   */ 
  public function getID()
  {
    return $this->ID;
  }

  /**
   * Set the value of ID
   *
   * @return  self
   */ 
  public function setID($ID)
  {
    $this->ID = $ID;

    return $this;
  }

  /**
   * Get the value of nationality
   */ 
  public function getNationality()
  {
    return $this->nationality;
  }

  /**
   * Set the value of nationality
   *
   * @return  self
   */ 
  public function setNationality($nationality)
  {
    $this->nationality = $nationality;

    return $this;
  }
}