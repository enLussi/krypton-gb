<?php

namespace Core\Event;

class AgoraListener
{

  public function redirect ($object) {

  }

  public function admin_login ($object) {
    
  }

  public function admin_logout ($object) {
    
  }

  public function load_plugin($object) {
    
  }

  public function load_page($object) {

  }

  public function load_admin($object) {
    
  }

  public function error($object) {
    $log_message = $object;

    $log = fopen(ABS_PATH . '/log/error.log', 'a');
    fwrite($log, $log_message);
    fclose($log);
  }

}