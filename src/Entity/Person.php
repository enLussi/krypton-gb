<?php

namespace APP\Entity;

use DateTime;

class Person {

  private string $lastname;

  private string $firstname;

  private DateTime $birthdate;

  public function __construct(string $lastname, string $firstname, DateTime $birthdate)
  {
    $this->lastname = $lastname;
    $this->firstname = $firstname;
    $this->birthdate = $birthdate;
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
}