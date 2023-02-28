<?php

namespace Agora\Console;

class ConsoleController 
{

  private $commands = [];

  public function __construct() {
    $this->commands = [
      'say',
      'create',
    ];
  }

  public function executeCommand ($command, $argument = "", $option = "") {

    if(in_array($command, $this->commands)) {

      $class = "Command".ucfirst(strtolower($command));
      $class = "Agora\\Console\\".$class ;

      $exec = new $class;
      $exec->execute($argument, $option);

    } else {

      echo "Unknown Command : ". strtolower($command);

    }

  }
}

?>