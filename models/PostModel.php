<?php

class PostModel extends BaseModel {

  /**
   * Properties inherited from BaseModel
   * public $id    = null;      // int
   * public $title = null;      // string
   */
  public $pubDate   = null;     // Publication Date
  public $content   = null;     // Main Content
  public $summary   = null;     // content summary
  public $image     = null;     // path/to/header_image
  public $page      = null;     // page the post belongs to
  public $tags      = array();  // all tags attached to post

  public function __construct( $data=array() ) {
    parent::__construct( $data );
    if (isset( $data['pubDate'] ))     $this->pubDate     = $data['pubDate'];
    if (isset( $data['summary'] ))     $this->summary     = $data['summary'];
    if (isset( $data['content'] ))     $this->content     = $data['content'];
    if (isset( $data['image'] ))       $this->image       = $data['image'];
    if (isset( $data['page'] ))        $this->page        = $data['page'];
    if (isset( $data['tags'] ))        $this->tags        = $data['tags'];
  }

  /**
   * Get list of posts
   *
   * @param $numrows  number of rows to return
   * @param $page     select posts for this page
   *
   * @return    array of PostModel objects
   */
  public static function getList( $page=null, $numrows=100000) {
    $result = array();
    $params = array([
      "place" => ":page", "value" => $page, "type"  => PDO::PARAM_STR,
      ]);

    $sql = "SELECT posts.*
            FROM posts ";

    if( isset($page) ) {
     $sql .= "INNER JOIN pages ON pages.title = :page
              INNER JOIN postpages ON postpages.pageid = pages.id
              WHERE postpages.postid = posts.id ";
    }

    $sql .= "ORDER BY pubdate DESC
             LIMIT $numrows";
    $st = self::execute( $sql, $params );

    while( $row = $st->fetch() ) {
      $Model = new PostModel( $row );
      $Model->fetchTags();
      $Model->fetchPage();
      $result[] = $Model;
    }

    return $result;
  } // END getList( $numrows, $category )

  /**
   * Returns post object referenced by $id
   *
   * @param $id   id of post to get
   *
   * @return object of type PostModel
   */
  public static function getById( $id ) {
    $data = array();
    $params = array([
      "place" => ":id", "value" => $id, "type"  => PDO::PARAM_INT,
    ]);

    $sql = "SELECT *
            FROM posts
            WHERE id=:id";
    $st = self::execute( $sql, $params );
    $data = $st->fetch();

    $Model = new PostModel($data);
    $Model->fetchTags();
    $Model->fetchPage();
    return $Model;
  } // END getById( $id )

  /**
   * Gets array of all posts whose title contains $title
   *
   * @param $title    string to search for
   * @param $numrows  mac number of objects to return
   *
   * @return  Array of PostModel objects
   */
  public static function getByTitle( $title, $numrows=100000 ) {
    $result = array();
    $params = array([
      "place" => ":title", "value" => "%".$title."%", "type"  => PDO::PARAM_STR,
    ]);

    $sql = "SELECT *
            FROM posts
            WHERE title LIKE :title
            ORDER BY pubdate
            LIMIT $numrows";
    $st = self::execute( $sql, $params );

    while( $row = $st->fetch() ) {
      $Model = new PostModel( $row );
      $Model->fetchTags();
      $Model->fetchPage();
      $result[] = $Model;
    }

    return $result;
  } // END getByTitle( $title )

  /**
   * Gets all tags attached to this post and assigns them to $this->tags
   *
   * @return  void
   */
  private function fetchTags() {
    $params = array([
      "place" => ":id", "value" => $this->id, "type"  => PDO::PARAM_INT,
      ]);

    $sql = "SELECT tags.title
            FROM tags, posttags
            WHERE tags.id = posttags.tagid
            AND posttags.postid = :id";
    $postTags = self::execute( $sql, $params );

    while( $row = $postTags->fetch() ) {
      $this->tags[] = $row['title'];
    }

  } // END fetchTags()

  /**
   * Gets page name post belongs to and assigns it to $this->page
   *
   * @return  void
   */
  private function fetchPage() {
    $params = array([
      "place" => ":id", "value" => $this->id, "type"  => PDO::PARAM_INT,
      ]);

    $sql = "SELECT pages.title
            FROM pages, postpages
            WHERE pages.id = postpages.pageid
            AND postpages.postid = :id";
    $postPage = self::execute( $sql, $params );
    $this->page = $postPage->fetch()['title'];
  } // END fetchPage()

} // END CLASS PostModel
?>
