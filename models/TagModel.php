<?php

class TagModel extends BaseModel {

  /** PROPERTIES ****************
   * Inherited from parent class
   * public $id    = null; // int
   * public $title = null; // string
   */

  public function __construct( $data=array() ) {
    parent::__construct( $data );
  }

  public function getList() {
    $st = $this->getList( 'tags' );

    $result = array();
    while( $row = $st->fetch() ) {
      $Model = new TagModel( $row );
      $result[] = $Model;
    }

    return $result;
  }// END getList()

  public function getById( $id ) {
    $st = $this->getById( $id, 'tags' );

    $row = $st->fetch();
    $Model = new TagModel( $row );

    return $Model;
  } // END getById( $id )

  public function getByTitle( $search ) {
    $st = $this->getByTitle( $search, 'tags' );

    $result = array();
    while( $row = $st->fetch() ) {
      $Model = new TagModel( $row );
      $result[] = $Model;
    }

    return $result;
  } // END getByTitle( $search )

  public function insert() {
    $conn = $this->connectDB();

    $sql = "INSERT INTO tags ( id, title )
            VALUES ( :id, :title )";
    $st = $conn->prepare( $sql );
    $st->bindValue( ':id',    $this->id,    PDO::PARAM_INT );
    $st->bindValue( ':title', $this->title, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();

    $conn = null;
  } // END insert()

  public function update() {
    $conn = $this->connectDB();

    $sql = "UPDATE tags SET title=:title WHERE id=:id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ':id',    $this->id,    PDO::PARAM_INT );
    $st->bindValue( ':title', $this->title, PDO::PARAM_STR );
    $st->execute();

    $conn = null;
  } // END update()

  
  public function delete( $id ) {
    $this->delete( $id, 'tags' );
  }

}

?>
