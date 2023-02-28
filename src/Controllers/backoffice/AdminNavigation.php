<?php


class AdminNavigation {

  private $admin_navlink = array();

  private $admin_navigation;

  private static AdminNavigation $instance;

  private function __clone(){}
  private function __construct(){

    $this->admin_navigation = TEMPLATES_PATH . '/backoffice/html/navigation-admin.php';
    $this->addAdminNavigationLink("dashboard", "Paramètres", "Dashboard");

  }

  public static function getInstance(): self {

    if(!isset(static::$instance)) {

      self::$instance = new AdminNavigation();

    }

    return self::$instance;

  }

  public function getAdminNavigation()
  {
    return $this->admin_navigation;
  }

  public function addAdminNavigationLink( $linkName, $displayName, $collapserName ) {

    array_push($this->admin_navlink, [[
      'link' => $linkName, 
      'display' => $displayName, 
      'collapser' => $collapserName
    ]]);
  }

  public function getAdminNavigationLink() {

     $menu_array = $this->admin_navlink;

      $new_array = array();

      foreach($menu_array as $menus) {
        foreach($menus as $menu) {
          
          if(!array_key_exists($menu['collapser'], $new_array)){
            $new_array[$menu['collapser']] = array();
          }
          array_push($new_array[$menu['collapser']], ['link' => $menu['link'], 'display' => $menu['display']]);

        }
      }

      return $new_array; 

  }

}

?>