<?php 

// Require setting
require_once( './src/settings.php' );

// Require Composer autoloader
require_once( './vendor/autoload.php' );

$router = new \Fruit\Fruit();

// Declare routes
$router->addroutes( array(
  /**
   * GET routes
   */

  // Get all posts
  array( 'GET', '/^posts(\/all)*$/', 'Chest\Controllers\PostController#getAll' ),

  // Get limited number of posts bu page
  array( 'GET', '/^posts\/(?P<page>\w+)(\/ls\/(?P<num>\d+))*$/', 'Chest\Controllers\PostController#getPageList' ),

  //Get post by id
  array( 'GET', '/^posts\/id\/(?P<id>\d+)$/', 'Chest\Controllers\PostController#getById' ),

  // Get post by title
  array( 'GET', '/^posts\/title\/(?P<title>\w+)$/', 'Chest\Controllers\PostController#getByTitle' ),

  // Get list of pages
  array( 'GET', '/^pages$/', 'Chest\Controllers\PageController#getList' ),

  /*
   * POST routes
   */

  // PUT routes
  // DELETE routes
));

$router->go();

exit;

?>
