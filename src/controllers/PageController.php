<?php namespace Chest\Controllers;

use Chest\Models\PageModel;

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

    $this->renderView( $pages );
  }
}

?>
