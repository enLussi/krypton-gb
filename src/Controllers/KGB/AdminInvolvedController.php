<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminInvolvedController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

    $this->script = ABS_PATH . '/templates/KGB/js/involved.js';

  }

  public function index() {

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    if(isset($_POST) && count($_POST) > 0) {

      $post = $_POST;

      var_dump($post);

      switch($_POST['involved']) {
        case "1":
          $agent = $dbrequest->requestProcedure('new_agent', [
            "'".$post['lastname']."'",
            "'".$post['firstname']."'",
            "'".$post['birthday']."'",
            intval($post['country']),
            "'".$post['name_code']."'"
          ]);
          var_dump($agent);
          foreach($post['type'] as $type) {
            $dbrequest->requestProcedure(('assign_spe_to_agent'), [
              $agent[0]['out_param'],
              intval($type)
            ]);
          }
          break;
        case "2":
          $dbrequest->requestProcedure('new_contact', [
            $post['lastname'],
            $post['firstname'],
            $post['birthday'],
            intval($post['country']),
            $post['name_code']
          ]);
          break;
        case "3":
          $dbrequest->requestProcedure('new_target', [
            $post['lastname'],
            $post['firstname'],
            $post['birthday'],
            intval($post['country']),
            $post['name_code']
          ]);
          break;
        default:
          break;
      }

    }
    
    
    $country = $dbrequest->requestSpecific(
      "SELECT * FROM country"
    );

    $type = $dbrequest->requestSpecific(
      "SELECT * FROM speciality"
    );

    DatabaseRequest::close($dbrequest);

    AgoraController::getInstance()->render($this->viewPath, $this->template, 'KGB.html.involved', [
      'country' => $country,
      'type' => $type
    ]);
    
  }
}