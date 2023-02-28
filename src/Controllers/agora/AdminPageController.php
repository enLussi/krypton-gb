<?php

namespace App\Controllers;

abstract class AdminPageController extends PageController
{

  public function __construct(){
    parent::__construct();

    $this->InstancePage->getEventDispatcher()->dispatch('load_admin');

  }

  abstract public function index();
}