<?php

namespace App\Controllers;

class ErrorUpkeepController extends PageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Site under Maintenance';

    $this->template = 'error';
  }

  public function index() {

    $config = json_decode(file_get_contents(ABS_PATH . '/config/admin/config.json'), true);

    $this->InstancePage->render($this->viewPath, $this->template, 'agora.html.upkeep', [
      'message' => $config['upkeep_message']
    ]);

  }
}