/<?php

class PageModel extends BaseModel {

  /** PROPERTIES ****************
   * Inherited from parent class
   * public $id    = null; // int
   * public $title = null; // string
   */

  public function __construct( $data=array() ) {
    parent::__construct( $data );
  }

  public static function getList () {
    $sql = "SELECT * 
            FROM pages
            ORDER BY id";
    $st = self::execute( $sql );

    $result = array();
    while( $row = $st->fetch() ) {
      $Model = new PageModel( $row );
      $result[] = $Model;
    }

    return $result;
  }// END getList()

  public static function getById( $id ) {
    $sql = "SELECT * FROM pages WHERE id=:id";
    $params = array(
      [ "place" => ":id", "value" => $id, "type"  => PDO::PARAM_INT, ]
    );

    $st = self::execute( $sql, $params );

    $row = $st->fetch();
    $Model = new PageModel( $row );

    return $Model;
  } // END getById( $id )

  public static function getByTitle( $title ) {
    $sql = "SELECT * FROM pages WHERE title LIKE :title";
    $params = array([ 
      "place" => ":title", 
      "value" => "%".$title."%",
      "type" => PDO::PARAM_STR, 
    ]);

    $st = self::execute( $sql, $params );

    $result = array();
    while( $row = $st->fetch() ) {
      $Model = new PageModel( $row );
      $result[] = $Model;
    }

    return $result;
  } // END getByTitle( $search )

 /* public function insert() {
    $conn = parent::connectDB();

    $sql = "INSERT INTO pages ( id, title )
            VALUES ( :id, :title )";
    $st = $conn->prepare( $sql );
    $st->bindValue( ':id',    $this->id,    PDO::PARAM_INT );
    $st->bindValue( ':title', $this->title, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();

    $conn = null;
  } // END insert()

  public function update() {
    $conn = parent::connectDB();

    $sql = "UPDATE pages SET title=:title WHERE id=:id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ':id',    $this->id,    PDO::PARAM_INT );
    $st->bindValue( ':title', $this->title, PDO::PARAM_STR );
    $st->execute();

    $conn = null;
  } // END update()

  public function delete( $id ) {
    $this->delete( $id, 'pages' );
  }
 */
}

?>
