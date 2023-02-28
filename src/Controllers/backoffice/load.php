<?php

$this->event->addListener('admin_login', function ($object) {
    $user_system = substr(
      $_SERVER['HTTP_USER_AGENT'], 
      ($p = strpos($_SERVER['HTTP_USER_AGENT'], 
      '(')+1), strrpos($_SERVER['HTTP_USER_AGENT'], ')')-$p)
    ;

    $user_software = explode(' ', $_SERVER['HTTP_USER_AGENT']);

    $log_message = 
      '[' 
      . $_SESSION['customer']['uid'] . ']['
      . date('j-m-y, G:i:s') 
      . '][IP:' . $_SERVER['REMOTE_ADDR'] 
      . '][Action:Login_to_Back_Office]['
      . $user_system
      .']: Logged in as ' . $object[0] . ' on ' . $user_software[0] . PHP_EOL;

    $log = fopen(ABS_PATH . '/log/event.log', 'a');
    fwrite($log, $log_message);
    fclose($log);

    $_SESSION['user'] = $object[0];
    $_SESSION['admin_access'] = "access";
  }
);

$this->event->addListener('admin_logout', function ($object) {

  $user_system = substr(
    $_SERVER['HTTP_USER_AGENT'], 
    ($p = strpos($_SERVER['HTTP_USER_AGENT'], 
    '(')+1), strrpos($_SERVER['HTTP_USER_AGENT'], ')')-$p)
  ;

  $user_software = explode(' ', $_SERVER['HTTP_USER_AGENT']);

  $log_message = 
  '[' 
  . $_SESSION['customer']['uid'] . ']['
  . date('j-m-y, G:i:s') 
  . '][IP:' . $_SERVER['REMOTE_ADDR'] 
  . '][Action:Logout_to_Back_Office]['
  . $user_system
  .']:' . $object . ' logged out on ' . $user_software[0] . PHP_EOL;

  $log = fopen(ABS_PATH . '/log/event.log', 'a');
  fwrite($log, $log_message);
  fclose($log);

  }
);

$this->event->addListener('load_plugin', function ($path) {

  if (file_exists($path . '/context.json')) {

    $file = json_decode(file_get_contents($path . '/context.json'), true);

    $links = $file['navigation'];
    
    foreach($links as $link){
      AdminNavigation::getInstance()->addAdminNavigationLink($link['link'], $link['display'], $link['collapser']);
    }
    
  } else {

  }
  
});

$this->event->addListener('load_admin', function () {

  if (!isset($_SESSION['admin_access']) || $_SESSION['admin_access'] !== 'access') {

    $this->InstancePage->forbidden_redirect();
    exit();

  }

});

$this->addRoutes([
  "admin"=> [
    "path"=> "/admin",
    "admin"=> false,
    "controller"=> "App\\Controllers\\AdminLoginController"
  ],
  "dashboard"=> [
    "path"=> "/admin/dashboard",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminDashboardController"
  ],
  "logout"=> [
    "path"=> "/admin/logout",
    "admin"=> true,
    "controller"=> "App\\Controllers\\AdminLogoutController"
  ],
]);