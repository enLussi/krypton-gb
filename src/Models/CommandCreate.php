<?php

namespace Agora\Console;

// php bin/console 
class CommandCreate extends Command
{


  public function execute($argument = "", $option = "") {

    $this->argument = $argument;
    $this->option = $option;
    
    switch ($argument) {
      case "page":
        $this->createPage();
        break;
      default:
        echo "Wrong argument";
        break;
    }
  }

  private function prompt_page() {

    $processing = true;

    $default_name = "default";
    $style = false;
    $script = false;
    $editable = false;

    echo "\n\e[92mQuel nom voulez-vous utiliser pour le controller et ses fichiers relatifs ?\e[39m [ \e[94m".$default_name."\e[39m ]:"
    . PHP_EOL;

    do  {
      $name = readline('> ');
      
      if (strlen($name) === 0) { $name = $default_name; }
      if (strlen($name) <= 3) {
        echo $name;
        echo "\e[91mTaille du nom trop court, veuillez saisir un nom plus long.\e[39m" . PHP_EOL;
        $name = "";
        continue;
      }

      $Cname = ucfirst($name) . "PageController";

      $template_path = TEMPLATES_PATH . "/web/html/";
      $controller_path = CONTROLLERS_PATH;

      $index_file = $template_path . strtolower($name) . "_index.php";
      $content_file = $template_path . strtolower($name) . "_content.json";
      $controller_file = $controller_path . ucfirst($name) . "PageController.php";

      if(file_exists($index_file) || file_exists($content_file) || file_exists($controller_file)) {
        echo "\e[91mLe nom de fichier '". ucfirst($name) . "' est déjà utilisé.\e[39m" . PHP_EOL;
        $name = "";
        continue;
      } else {

        echo "\n\e[92mQuel titre de référencement voulez-vous donner à la page ?\e[39m [ \e[94m".ucfirst($name)."\e[39m ]:" . PHP_EOL;
        $title = readline('> ');
        if (strlen($title) === 0) { $title = ucfirst($name); }

        
        echo "\n\e[92mVoulez-vous ajouter un fichier de style CSS? yes/no \e[39m[ \e[94m".($style?"yes":"no")."\e[39m ]:" . PHP_EOL;
        $response = readline('> ');
        if (strtolower($response) == 'yes' || strtolower($response) == 'no') { $style = strtolower($response) === 'yes'? true: false; }

        
        echo "\n\e[92mVoulez-vous ajouter un fichier de script JS? yes/no \e[39m[ \e[94m".($script?"yes":"no")."\e[39m ]:" . PHP_EOL;
        $response = readline('> ');
        if (strtolower($response) == 'yes' ||strtolower($response) == 'no') { $script = strtolower($response) === 'yes'? true: false; }

        
        echo "\n\e[92mVoulez-vous que le contenu soit editable (AdminEditionController)? yes/no \e[39m[ \e[94m".($editable?"yes":"no")."\e[39m ]:" . PHP_EOL;
        $response = readline('> ');
        if (strtolower($response) == 'yes' || strtolower($response) == 'no') { $editable = strtolower($response) === 'yes'? true: false; }

        $processing = false;
      }
    } while ($processing);

    return [$name, $Cname, $title, $script, $style, $editable];

  }

  private function generate_page_file($file_path, $file_content) {
    if ($view = fopen($file_path, "w")) {
      if(fwrite($view, $file_content) === false) {
        echo "\n\e[91mImpossible d'écrire dans le fichier HTML (".$file_path.")\e[39m" . PHP_EOL;

        $this->aborted_prompt;
        exit;
      }
      echo "\n\e[92mCreated:\e[39m $file_path " . PHP_EOL;

      fclose($view);
    } else {

      echo "\n\e[91mImpossible d'ouvrir le fichier ($file_path)\e[39m" . PHP_EOL;

      $this->aborted_prompt;
      exit;

    }
  }

  private function createPage() {

    $result = $this->prompt_page();

    $content = 
'<main>
  <section>
    <p id="content"><?= $parameters[\'content\']?></p>
  </section>
</main>';

    $this->generate_page_file(TEMPLATES_PATH . "/web/html/$result[0]_index.php", $content);

    $content = 
'{
  "content":"Page '.ucfirst($result[0]).'"
}';

    $this->generate_page_file(TEMPLATES_PATH . "/web/html/$result[0]_content.json", $content);

    $this->generate_page_file(TEMPLATES_PATH . "/web/css/$result[0].css", "");
    $this->generate_page_file(TEMPLATES_PATH . "/web/js/$result[0].js", "");

    $content = 
'<?php
  
namespace App\Controllers;
  
class '. $result[1] . ' extends PageController
{

  public function __construct(){
    parent::__construct();

    $this->title = "'. $result[2] .'";
    $this->name = "'.$result[0].'";

    $this->style = ABS_PATH . "/templates/web/css/'.$result[0].'.css";

    $this->content = json_decode(file_get_contents(ABS_PATH . "/templates" . "/web/html/'.$result[0].'_content.json"), true);
    
  }

  public function index() {

    $this->InstancePage->render($this->viewPath, $this->template, "web.html.'.$result[0].'_index", $this->content);

    $this->validateCustomersData();

  }

  public function edit() {

    return $this->InstancePage->display($this->viewPath, "web.html.'.$result[0].'_index", $this->content);

  }

}';

    $this->generate_page_file(ABS_PATH . "/src/Controllers/$result[1].php", $content);


    $routes = json_decode(file_get_contents(ABS_PATH . '/config/routes/routes.json'), true);

    $routes[$result[0]] = [
      "path"=> "/$result[0]",
      "admin"=> false,
      "controller" => "App\\Controllers\\$result[1]",
      "edit" => $result[5] 
    ];

    file_put_contents(ABS_PATH . '/config/routes/routes.json', json_encode($routes, JSON_PRETTY_PRINT));

    echo "\n\e[92mUpdated: routes = /$result[0]" . PHP_EOL;

    echo $this->success_prompt;
    
  }
}

?>