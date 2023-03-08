<?php

namespace App\Controllers;

use APP\Entity\Hideout;
use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminHideoutSearchController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'KGB';

    $this->template = 'admin';

  }

  public function index() {
    header("Content-Type: application/json");

    $dbrequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

    $hideouts= [];
    foreach(
      $dbrequest->requestSpecific
      ("SELECT row_id FROM hideout 
      WHERE name_code LIKE '".$_POST['search']."%'") as $h) 
    {
      $hideouts = [...$hideouts, Hideout::hideoutByID($h['row_id'])->jsonSerialize()];
    }

    echo  json_encode([
      'hideouts' => $hideouts, 
    ]);
    DatabaseRequest::close($dbrequest);
    exit;
  }
}