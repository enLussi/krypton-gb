<?php

use Core\Agora;

require_once dirname(__DIR__) . '/vendor/autoload.php';

return function($context) {
  return new Agora($context);
};
?>