<?php

ini_set( 'display_errors', true );
date_default_timezone_set( 'Europe/London' );

/******** DATABASE SETTINGS ********/
define( "DB_DSN", "mysql:host=localhost;dbname=mysite" );
define( 'DB_USERNAME', 'test' );
define( 'DB_PASSWORD', 'test' );

/******** PROJECT STRUCTURE ********/
define( 'MODEL_PATH',       'Models/' );
define( 'VIEW_PATH',        'Views/'  );
define( 'CONTROLLER_PATH',  'Controllers/' );
define( 'LIBRARY_PATH',     'library/' );

/**
 * DECLARE AUTOLOADER
 */
spl_autoload_register( 'apiAutoload' );
function apiAutoload( $classname ) {
  if( preg_match( '/[a-zA-Z]+Controller$/', $classname )) {
    require_once CONTROLLER_PATH . $classname .'.php';
    return true;
  } elseif( preg_match( '/[a-zA-Z]+Model$/', $classname )) {
    require_once MODEL_PATH . $classname .'.php';
    return true;
  } elseif( preg_match( '/[a-zA-Z]+View$/', $classname )) {
    require_once VIEW_PATH . $classname .'.php';
    return true;
  } else {
    require_once LIBRARY_PATH . $classname . '.php';
    return true;
  }
  return false;
} // END AUTOLOADER

/**
 * DECLARE ERROR HANDLER
 */
function handleException( $exception ) {
  echo 'There has been a problem please try again';
  error_log( $exception->getMessage());
} // END handleException
set_exception_handler( 'handleException' );

?>
