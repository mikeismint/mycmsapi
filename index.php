<?php

// Require setting, include autoloader
require_once( '/library/settings.php' );

$router = new Router();

// Declare routes
$router->addroutes( array(
  /**
   * GET routes
   */
  
  // Get all posts
  array( 'GET', '/^posts(\/all)*$/', 'PostController#getAll' ),
 
  // Get limited number of posts bu page
  array( 'GET', '/^posts\/(?P<page>\w+)(\/ls\/(?P<num>\d+))*$/', 'PostController#getPageList' ),

  //Get post by id
  array( 'GET', '/^posts\/id\/(?P<id>\d+)$/', 'PostController#getById' ),

  // Get post by title
  array( 'GET', '/^posts\/title\/(?P<title>\w+)$/', 'PostController#getByTitle' ),

  // Get list of pages
  array( 'GET', '/^pages$/', 'PageController#getList' ),

  /*
   * POST routes
   */

  // PUT routes
  // DELETE routes
));

$router->go();

exit;

?>
