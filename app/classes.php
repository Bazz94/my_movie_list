<?php 
class Movie {
  public $id;
  public $title;
  public $date;

  function __construct($id, $title, $date) {
    $this->id = $id;
    $this->title = $title;
    $this->date = $date;
  }
  
  function to_string() {
    return $this->title . ' (' . $this->date . ')';
  }
}
?>