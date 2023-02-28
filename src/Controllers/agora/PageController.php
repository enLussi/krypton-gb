<?php

namespace App\Controllers;

use Core\Controllers\AgoraController;

abstract class PageController 
{

  protected $template = 'default';
  protected $viewPath;

  protected $InstancePage;

  protected $title = '';
  protected $name = '';
  protected $sub_name = '';
  protected $style = '';
  protected $script = '';

  protected $self_directory;

  protected $follow_page_for_stats = array();

  protected $customers_data;

  protected $content = [];

  protected $admin_navigation;
  protected $admin_navlink = array();

  public function __construct() {

    $this->InstancePage = AgoraController::getInstance();

    $this->viewPath = TEMPLATES_PATH;

    $this->customers_data = json_decode(file_get_contents(ABS_PATH . "/data/Customers/customers_".date("my").".json"), true);

    $this->admin_navigation = TEMPLATES_PATH . '/backoffice/html/navigation-admin.php';

    $this->InstancePage->getEventDispatcher()->dispatch('load_page');
    
  }

  abstract public function index();

  /**
   * Get the value of name
   */ 
  public function getName()
  {
    return $this->name;
  }

  /**
   * Get the value of title
   */ 
  public function getTitle()
  {
    return $this->title;
  }

  public function getStyle() 
  {
    return $this->style;
  }
  
  public function getScript() 
  {
    return $this->script;
  }

}
