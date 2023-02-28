<?php

namespace App\Controllers;

class ErrorNotFoundController extends PageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Not Found';

    $this->template = 'error';
  }

  public function index() {

    $this->InstancePage->render($this->viewPath, $this->template, 'agora.html.errornotfound');

  }
}