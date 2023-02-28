<?php

namespace Agora\Console;

class CommandSay extends Command
{
  public function execute($argument = "", $option = []) {

    $this->argument = $argument;
    $this->option = $option;

    echo $this->argument;
  }
}

?>