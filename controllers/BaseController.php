<?php

abstract class BaseController {

  protected $viewType;

  /**
   * Default constructor
   *
   * @param $setView  Requested format for return value defaults to Json
   */
  protected function __construct( $setView="Json" ) {
    $this->viewType = $setView;
  }

  /**
   * Passes results to View class as per $viewType
   *
   * @param $result   Date to be returned
   */
  protected function renderView ( $result ) {
    $viewModel = ucfirst( $this->viewType ) . 'View';
    $view = new $viewModel();
    $view->render( $result );
  }
}
?>
