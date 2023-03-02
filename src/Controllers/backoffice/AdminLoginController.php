<?php


namespace App\Controllers;

use Core\Controllers\AgoraController;
use Core\Models\DatabaseRequest;

class AdminLoginController extends PageController
{
  public function __construct(){
    parent::__construct();

    $this->title = 'Admin Login';

    $this->template = 'admin';

  }

  public function index() {

    $params = $this->identification();

    if ($params || (isset($_SESSION['admin_access']) && $_SESSION['admin_access'] === "access")) {
      $this->InstancePage->header_redirect('/admin/kgb');
    } else {
      $this->InstancePage->render($this->viewPath, $this->template, 'backoffice.html.login', [$params]);
    }
  
  }

  public function identification() {

    $ids = $_POST;

    if(isset($ids['idAdmin']) && isset($ids['pass'])){

      $dbRequest = new DatabaseRequest($_SERVER['runtime']->getSettings()->getDBConfig());

      if($dbRequest->is_ready()) {

        $user = $dbRequest->requireFromDataBase(['mail', 'pass_word', 'lastname', 'firstname'], 'users', 'mail', $ids['idAdmin']);

        $first_result = $user[0];

        if(
          (password_verify($ids['pass'], $first_result['pass_word']) || 
          sha1(md5($ids['pass'])) == $first_result['pass_word'] || 
          md5($ids['pass']) == $first_result['pass_word']) &&
          ($ids['idAdmin'] === $first_result['mail'])) {

          $username = $first_result['firstname'] . ' ' . $first_result['lastname'];
          $this->InstancePage->getEventDispatcher()->dispatch('admin_login', [$username]);

          return true;
        }

      }

      unset($dbRequest);

      return false;
    }

  }

  protected function login_redirect() {

    AgoraController::getInstance()->setController(new AdminLoginController());
    AgoraController::getInstance()->getController()->index();
  
  }
}