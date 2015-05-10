<?php namespace CMS\Library;
/**
 * Router - My first attempt at a PHP router.
 *
 * Heavily influenced by dannyvankooten/AltoRouter
 *
 * @author    Mike Wilson
 */

class Router {

  private $requestVerb;
  private $requestURL;

  private $routes = array();

  /**
   * Create new instance of Router
   *
   * Gets HTTP verb and URL from Global $_SERVER variable
   */ 
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

  /**
   * Execute router.
   * 
   * @return  boolean   True if a route is executed
   *                    False if no routes are found
   */
  public function go() {

    foreach( $this->routes as $route ) {

      list( $verb, $pattern, $action, $name ) = $route;

      $verbs = explode(  '|', $verb );
      $verbMatch = false;

      // First checks for matching verb
      foreach( $verbs as $verb ) {
        if( strtoupper( $verb ) == $this->requestVerb ) {
          $verbMatch = true;
          break;
        }
      }

      // Skip rest of function if verb doesn't match
      if( !$verbMatch ) continue;

      if( preg_match( $pattern, $this->requestURL, $match )) {

        // Remove non-named keys from matches
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
