<?php

namespace Core\Event;

class EventDispatcher
{
  public $listeners = [];

  public function dispatch($name, $object = null) {
    foreach($this->listeners[$name] as $listener) {

      is_null($listener['listener']) ? 
        $listener['method']($object) : $listener['listener']->{$listener['method']}($object);
    }
  }

  public function addListener(string $name, $method, $listener = null, $argument = null, string $plugin = "") {

    if (array_key_exists($name, $this->listeners)){
      $this->listeners[$name] = [...$this->listeners[$name], [
        'listener' => $listener,
        'method' => $method,
        'argument' => $argument,
      ]];
    } else {
      $this->listeners[$name][] = [
        'listener' => $listener,
        'method' => $method,
        'argument' => $argument,
      ];
    }

  }
}