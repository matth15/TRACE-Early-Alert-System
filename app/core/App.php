<?php

class App
{


  private $controller = "Home";
  private $method = "index";
  private $params;

  /**
   * 
   * 
   * 
   */
  private function splitURL()
  {
    $URL = $_SERVER['REQUEST_URI'];
    $URL = explode("/", filter_var(trim($URL, "/")), FILTER_SANITIZE_URL);
    return $URL;
  }
  /**
   * 
   * 
   * 
   */
  public function run()
  {
    $URL = $this->splitURL();
    
    // Controller
    $parseURL = parse_url($URL[0]);

    $URL[0] = $parseURL['path'];
    $filename = "app/controller/" . ucfirst($URL[0]) . ".php";

    //var_dump(print_r($filename));

    if (!empty($URL[0])) {
      if (file_exists($filename)) {
        require $filename;
        $this->controller = ucfirst($URL[0]);
        unset($URL[0]);
      } else {
        $filename = "app/controller/_404.php";
        require $filename;
        $this->controller = "_404";
      }
    } else {

      $filename = "app/controller/Home.php";
      require $filename;
      $this->controller = "Home";
    }

    $controller = new $this->controller;
    //Method  

    if (!empty($URL[1])) {
      $methodName = $URL[1];
      if (method_exists($controller, $URL[1])) {
        $this->method = $methodName;
        unset($URL[1]);
      } else {
        $filename = "app/controller/_404.php";
        require $filename;
        $this->controller = "_404";
        $controller = new $this->controller;
        $this->method = "index";  // or another default method for 404
      }
    }
    

    // Params
    $this->params = (count($URL) > 0) ? $URL : ["home"];

    call_user_func_array([$controller, $this->method], $this->params);
   
  }
}