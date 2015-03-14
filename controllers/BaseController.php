<?php

abstract class BaseController {

  protected $viewType;

  protected function __construct( $setView="Json" ) {
    $this->viewType = $setView;
  }

}
?>
