<?php


namespace App\Controllers;

use Core\Controllers\AgoraController;

class AdminLogoutController extends AdminPageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Admin Logout';

    $this->template = 'admin';
  }

  public function index() {


    AgoraController::getInstance()->getEventDispatcher()->dispatch('admin_logout', $_SESSION['user']);

    unset($_SESSION['admin_access']);
    unset($_SESSION['user']);

    $this->InstancePage->header_redirect('/');
  
  }

}