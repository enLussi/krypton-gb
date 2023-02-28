<?php

namespace APP\Entity;

use Core\Models\DatabaseRequest;

class Hideout {

  private string $name_code;

  private string $address;

  private string $type;

  private string $country;

  public function __construct($id)
  {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $hideout = $dbrequest->requestProcedure('get_hideout', [$id]);

    if(count($hideout) > 0){


      if(key_exists('name_code', $hideout[0]) && !is_null($hideout[0]['name_code'])) {
        $this->name_code = $hideout[0]['name_code'];
      }

      $this->address = $hideout[0]['address'];
      $this->type = $hideout[0]['label'];
      $this->country = $hideout[0]['country'];
    }

    
  }

  public static function hideoutByID(int $id) {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $hideout = $dbrequest->requestProcedure('get_hideout', [$id]);

    if (count($hideout) > 0){
      $instance = new self(
        $hideout[0]['row_id']
      );

      return $instance;
    }

    return false;
  }

  public static function newHideout(string $name_code, string $address, string $type, int $country) {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());
    
    $arguments = [
      $name_code, $address, $type, $country
    ];

    $contact = $dbrequest->requestProcedure('new_hideout', $arguments);

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

  /**
   * Get the value of address
   */ 
  public function getAddress()
  {
    return $this->address;
  }

  /**
   * Set the value of address
   *
   * @return  self
   */ 
  public function setAddress($address)
  {
    $this->address = $address;

    return $this;
  }

  /**
   * Get the value of type
   */ 
  public function getType()
  {
    return $this->type;
  }

  /**
   * Set the value of type
   *
   * @return  self
   */ 
  public function setType($type)
  {
    $this->type = $type;

    return $this;
  }

  /**
   * Get the value of country
   */ 
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * Set the value of country
   *
   * @return  self
   */ 
  public function setCountry($country)
  {
    $this->country = $country;

    return $this;
  }
}