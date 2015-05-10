<?php namespace Chest\Views;

class JsonView {

  public function render( $data ) {
    header( 'Content-Type: application/json; charset=utf-8' );
    echo( json_encode( $data ));
  }

} // END CLASS JsonView

?>
