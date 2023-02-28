<?php

namespace Agora\Console;

abstract class Command
{
  protected $argument = "";
  protected $option = "";

  protected $success_prompt = 
  "\n \e[42m\e[32m           \e[39m\e[49m\n " . 
  "\e[42m\e[32m           \e[39m\e[49m\n " . 
  "\e[42m  \e[97mSuccess\e[39m  \e[49m\n " . 
  "\e[42m\e[32m           \e[39m\e[49m\n " .
  "\e[42m\e[32m           \e[39m\e[49m\n ";

  protected $aborted_prompt = 
  "\n \e[101m\e[32m           \e[39m\e[49m\n " . 
  "\e[101m\e[32m           \e[39m\e[49m\n " . 
  "\e[101m  \e[97mAborted\e[39m  \e[49m\n " . 
  "\e[101m\e[32m           \e[39m\e[49m\n " .
  "\e[101m\e[32m           \e[39m\e[49m\n ";

  abstract public function execute($argument, $option);
}

?>