<?php

class PageController extends BaseController {

  /**
   * Properties
   *
   * $viewType  Inherited from BaseController
   */

  public function __construct( $setView="Json" ) {
    parent::__construct( $setView );
  }

  /**
   * Gets list of pages
   *
   * @return  array in format
   *
   *    [ID] => [Title]
   */
  public function getList() {
    $pages = PageModel::getList();

    foreach( $pages as $page ) {
      $result[$page->id] = $page->title;
    }

    $this->renderView( $result );
  }

  private function renderView ( $result ) {
    $viewModel = ucfirst( $this->viewType ) . 'View';
    $view = new $viewModel();
    $view->render( $result );
  }
}

?>
