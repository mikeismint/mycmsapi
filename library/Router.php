<?php

class Router {

  private $requestVerb;
  private $requestURL;
  private $requestParams;

  private $routes = array();

  public function __construct () {
    $this->requestVerb = isset($_SERVER['REQUEST_METHOD']) ?
      $_SERVER['REQUEST_METHOD'] : 'GET';

    $this->requestURL = isset($_SERVER['PATH_INFO']) ?
      trim($_SERVER['PATH_INFO'], '/' ) : '/';
  }

  /**
   * Return all routes
   *
   * @return  array of all routes
   */
  public function getRoutes() {
    return $this->routes;
  }

  /**
   * Add a new route
   *
   * @param string  $verb     HTTP methods, seprated by |
   * @param string  $pattern  Regex pattern to match
   * @param string  $action   Controller and Method to call
   * @param string  $name     Name of route (Optional)
   */
  public function addRoute( $verb, $pattern, $action, $name='' ) {
    $this->routes[] = array( $verb, $pattern, $action, $name );
  }

  /**
   * Add multiple routes via array in form
   *
   *  $routes = array(
   *    array( $verb, $route, $action, $name ),
   *    array...
   *    );
   *
   * @param array  $routes  Array of routes to add
   */
  public function addRoutes ( $routes ) {
    if( !is_array( $routes )) {
      throw new Exception( 'Parameter must be an array' );
    }

    foreach( $routes as $route ) {
      call_user_func_array( array( $this, "addRoute" ), $route );
    }
  }

  public function go() {

    foreach( $this->routes as $route ) {

      list( $verb, $pattern, $action, $name ) = $route;
      $verbs = explode(  '|', $verb );
      $verbMatch = false;

      foreach( $verbs as $verb ) {
        if( strtoupper( $verb ) == $this->requestVerb ) {
          $verbMatch = true;
          break;
        }
      }

      if( !$verbMatch ) continue;

      if( preg_match( $pattern, $this->requestURL, $match )) {
        foreach( $match as $key => $value ) {
          if( is_numeric( $key )) unset( $match[$key]);
        }

        explode( '#', $action );
        list( $Controller, $method ) = explode( '#', $action );

        $controller = new $Controller();

        if( is_callable( array( $controller, $method ))) {
          call_user_func_array( array( $controller, $method ), $match );
          return true;
        } else {
          throw new Exception( "Can't call controller $controller or
                                action $action" );
        }
      }

    }
    return false;
  }

} // END CLASS Router

?>
