<?php

namespace APP\Entity;

use DateTime;

class User {

  private string $lastname;

  private string $firstname;

  private string $mail;

  private string $password;

  private DateTime $creation_date;

  public function __construct(string $lastname, string $firstname, string $mail, string $password, DateTime $creation_date)
  {
    $this->lastname = $lastname;
    $this->firstname = $firstname;
    $this->mail = $mail;
    $this->password = $password;
    $this->creation_date = $creation_date;
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
   * Get the value of mail
   */ 
  public function getMail()
  {
    return $this->mail;
  }

  /**
   * Set the value of mail
   *
   * @return  self
   */ 
  public function setMail($mail)
  {
    $this->mail = $mail;

    return $this;
  }

  /**
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of creation_date
   */ 
  public function getCreation_date()
  {
    return $this->creation_date;
  }

  /**
   * Set the value of creation_date
   *
   * @return  self
   */ 
  public function setCreation_date($creation_date)
  {
    $this->creation_date = $creation_date;

    return $this;
  }
}