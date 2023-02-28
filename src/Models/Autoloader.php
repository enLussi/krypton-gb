<?php

namespace Agora\Autoloader;

class Autoloader
{

  static function register() {
    spl_autoload_register(array(__CLASS__, 'controllers_autoload'));
  }

  static function controllers_autoload ($class_name) {

    $class_name = explode('\\', $class_name);
    $class_name = array_pop($class_name);

    $dirs = [
      ABS_PATH . '/config',
      ABS_PATH . '/src/Controllers',
      ABS_PATH . '/src/Entity',
      ABS_PATH . '/src/Models',
      ABS_PATH . '/src/Events',
    ];

    foreach ($dirs as $dir) {

      if( is_dir($dir)) {
        
        if($current_dir = opendir($dir)) {

          while($entry = readdir($current_dir)) {

            if (file_exists($dir . '/' . $entry . '/' . $class_name . '.php')) {
              require_once $dir . '/' . $entry . '/' . $class_name . '.php'; 
            } 

          }

        } else {

          if (file_exists($dir . $class_name . '.php')) {
            require_once $dir . $class_name . '.php'; 
          } 

        }

      }

    }

  }

}