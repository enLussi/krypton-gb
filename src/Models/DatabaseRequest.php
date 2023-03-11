<?php

namespace Core\Models;

use Core\Controllers\AgoraController;
use Exception;
use PDO;
use PDOException;

class DatabaseRequest
{

  private $db_host;
  private $db_name;
  private $db_user;
  private $db_pass;

  private $db_ready = false;

  public function __construct(array $DB)
  {
    $this->db_host = $DB['host'];
    $this->db_name = $DB['name'];
    $this->db_user = $DB['user'];
    $this->db_pass = $DB['pass'];

    if($this->db_available() && $this->canConnectToDatabase()) {

      $this->db_ready = true;

    }
  }

  private function db_available(): bool {

    if(
      (strlen($this->db_host) !== 0) &&
      (strlen($this->db_user) !== 0) &&
      (strlen($this->db_pass) !== 0) &&
      (strlen($this->db_name) !== 0)
    ) {
  
      return true;
  
    } else {
  
      return false;
  
    }
  
  }

  private function canConnectToDatabase() {

    if ($this->db_available()) {
      try {

        $dsn = 'mysql:host='.$this->db_host.';dbname='.$this->db_name.';';

        $pdo = new PDO($dsn, $this->db_user, $this->db_pass);

      } catch (PDOException $e) {
        AgoraController::getInstance()->issue_redirect(101);
        return false;
      }
    
      return true;
    } 

  }

  public function is_ready() {
    return $this->db_ready;
  }

  public function get_PDO() {

    try {
 
      $dsn = 'mysql:host='.$this->db_host.';dbname='.$this->db_name.';';

      return new PDO($dsn, $this->db_user, $this->db_pass);

    } catch (PDOException $e) {
      AgoraController::getInstance()->issue_redirect(101);
      return false;
    }

  }

  /**
   * return an array of result from a selected database
   * return an integer on error
   * 
   * @var $array for the all section 
   * @var $table to search in table specified
   * @var $id after where clause
   * @var $ref to compare with
   * 
   * deprecated
   */
  public function requireFromDataBase(array $array, string $table, string $id, string $ref){

    $pdo = $this->get_PDO();

    if ($pdo) {

      $selection = implode(",", $array);

      $request = "SELECT ".$selection." FROM ".$table." WHERE ".$id." = '".$ref."'";
  
      $query = $pdo->query($request, PDO::FETCH_ASSOC);
      $result = $query->fetchAll();
  
      return $result;

    }

    return false;
    
  }

  public function requestProcedure(string $procedure, array $arguments = []) {

    $pdo = $this->get_PDO();

    if ($pdo) {


      foreach ($arguments as $argument) {
        $argument .= strval($argument);
      }

      $s = implode(', ', $arguments);

      $request = "CALL " . $procedure . "(" . $s .")";

      $query = $pdo->query($request, PDO::FETCH_ASSOC);
      $result = $query->fetchAll();

      return $result;

    }

    return false;
  
  }

  public function requestSpecific(string $command) {
    

    try {
      $pdo = $this->get_PDO();

      if ($pdo) {

        $query = $pdo->query($command, PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

        return $result;

      }
    } catch (Exception $e) {
      AgoraController::getInstance()->issue_redirect(102);
    }

  }
  
  public static function close (DatabaseRequest &$dbRequest) {

    $dbRequest = NULL;

  }

  /**
   * Get the value of db_ready
   */ 
  public function getDb_ready()
  {
    return $this->db_ready;
  }
}



?>