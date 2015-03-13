<?php

abstract class BaseModel {

  /** PROPERTIES ****************/
  public $id    = null; // int
  public $title = null; // string

  /**
   * Methods to be implemented in extending classes
   */
  /*abstract protected function getList ();
  abstract protected function getById( $id );
  abstract protected function getByTitle( $title );
  abstract protected function insert();
  abstract protected function update();
  abstract protected function delete(); */

  /**
   * Constructor for Model
   *
   * @param array $data  array containing initial values
   */
  protected function __construct( $data=array() ) {
    if (isset( $data['id'] ))     $this->id     = (int)$data['id'];
    if (isset( $data['title'] ))  $this->title  = $data['title'];
  } // END __construct

  /**
   * Connect to database
   *
   * @return PDO connection object
   */
  protected static function connectDB() {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    return $conn;
  }

  /**
   * Executes SQL query
   *
   * @param   $sql      String containing SQL query
   * @params  $params   Array containing variables to bind
   *
   * @return  $st       results of SQL query
   */
  protected static function execute( $sql, $params=array() ) {
    $conn = self::connectDB();

    $st = $conn->prepare( $sql );
    foreach( $params as $bind ) {
      $st->bindValue( $bind['place'], $bind['value'], $bind['type'] );
    }
    $st->execute();
    $conn = null;

    return $st;
  }

} // END CLASS

?>
