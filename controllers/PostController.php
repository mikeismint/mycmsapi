<?php

class PostController extends BaseController {

  /**
   * Properties
   *
   * $viewType  Inherited from BaseController
   */
  
  public function __construct( $setView="Json" ) {
    parent::__construct( $setView );
  }

  /**
   * Gets all posts
   *
   * @return  void
   */
  public function getAll () {
    $result = PostModel::getList();

    $this->renderView($result);
  }

  /**
   * Gets post by ID
   *
   * @param   $id         ID for requested post
   *
   * @return  void
   */
  public function getById ( $id ) {
    $result = PostModel::getById( $id );

    $this->renderView($result);
  }

  /**
   * Gets posts for required page
   *
   * @param   $page       name of required page
   * @param   $numrows    Number of results to return
   *
   * @return  void
   */
  public function getPageList ( $page, $numrows=1000000 ) {
    if ( strcmp( ucfirst( $page ), "All" ) == 0) {
      $page = null;
    }
    $result = PostModel::getList( $page, $numrows );

    $this->renderView($result);
  }

  /**
   * Gets post by Title
   *
   * @param   $title      String to search for
   *
   * @return  void
   */
  public function getByTitle ( $title ) {
    $result = PostModel::getByTitle( $title );
    
    $this->renderView($result);
  }

  private function renderView ( $result ) {
    $viewModel = ucfirst( $this->viewType ) . 'View';
    $view = new $viewModel();
    $view->render( $result );
  }

} // END CLASS PostController

?>
