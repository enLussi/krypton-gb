<?php

namespace App\Controllers;

class ErrorForbiddenController extends PageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Forbidden';

    $this->template = 'error';
  }

  public function index() {

    $this->InstancePage->render($this->viewPath, $this->template, 'agora.html.errorforbidden');

  }
}