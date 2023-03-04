<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminHideoutController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/hideout.js';

  }

  public function index() {
    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    if(isset($_POST) && count($_POST) > 0) {

      $post = $_POST;

      var_dump($post);

    }
    
    
    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM hideout_type"
    );

    DatabaseRequest::close($dbrequest);


    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.hideout', [
      'country' => $country,
      'type' => $type
    ]);
    
  }
}