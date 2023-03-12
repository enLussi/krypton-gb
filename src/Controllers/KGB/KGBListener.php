<?php

namespace Core\Event;

class KGBListener {

  public function Event_modify($object) {

    [$element, $id] = $object;

    if(!is_string($element) || is_int($id)) {
      $log_message = "Something went wrong with var types during modify event !";
    }

    $log_message= 
    '[' 
    . $_SESSION['customer']['uid'] . ']['
    . date('j-m-y, G:i:s')
    . '][Action:modify'
    . ']: Modify a ' . $element . ' element with id ' . $id . PHP_EOL
    ;


    $log = fopen(ABS_PATH . '/log/event.log', 'a');
    fwrite($log, $log_message);
    fclose($log);
  }

  public function Event_remove($object) {

    [$element, $id] = $object;

    if(!is_string($element) || is_int($id)) {
      $log_message = "Something went wrong with var types during remove event !";
    }

    $log_message= 
    '[' 
    . $_SESSION['customer']['uid'] . ']['
    . date('j-m-y, G:i:s')
    . '][Action:modify'
    . ']: Remove a ' . $element . ' element with id ' . $id . PHP_EOL
    ;

    
    $log = fopen(ABS_PATH . '/log/event.log', 'a');
    fwrite($log, $log_message);
    fclose($log);
  }

  public function Event_create($object) {

    [$element, $id] = $object;

    if(!is_string($element) || is_int($id)) {
      $log_message = "Something went wrong with var types during create event !";
    }

    $log_message= 
    '[' 
    . $_SESSION['customer']['uid'] . ']['
    . date('j-m-y, G:i:s')
    . '][Action:modify'
    . ']: Create a ' . $element . ' element with id ' . $id . PHP_EOL
    ;

    
    $log = fopen(ABS_PATH . '/log/event.log', 'a');
    fwrite($log, $log_message);
    fclose($log);
  }

}