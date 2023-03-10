<?php

namespace App\Controllers;

class ErrorIssueController extends PageController
{

  private int $error_code;

  public function __construct(int $error_code){
    parent::__construct();

    $this->error_code = $error_code;

    $this->title = 'Not Found';

    $this->template = 'error';
  }

  public function index() {

    $this->InstancePage->render($this->viewPath, $this->template, 'agora.html.errorissue', [
      'error_code' => $this->error_code,
    ]);

  }
}
?>