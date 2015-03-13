<?php

class Request {

  public $verb;
  public $url_elements;
  public $routes;

  public function __construct () {
    $this->verb = $_SERVER['REQUEST_METHOD'];
    $requestURI = explode( '/', rtrim($_SERVER['PATH_INFO'], '/') );
    $scriptName = explode( '/', $_SERVER['SCRIPT_NAME'] );

    //$requestURI = explode( '/', $_SERVER['REQUEST_URI'] );
    /* for( $i = 0; $i < sizeof($scriptName); $i++ ) {
      if( $requestURI[$i] == $scriptName[$i] ) {
        unset( $requestURI[$i]);
      }
    } */

    array_shift($requestURI);
    $this->url_elements  = array_values( $requestURI );
  }

} // END Class Request
?>
