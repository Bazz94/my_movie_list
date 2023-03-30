<?php 
class Movie {
  private $id;
  private $title;
  private $date;
  private $poster;

  function __construct($id, $title, $date, $poster) {
    $this->id = $id;
    $this->title = $title;
    $this->date = $date;
    $this->poster = $poster;
  }
  
  function to_string() {
    return $this->title . ' (' . $this->date . ')';
  }

  function getPoster() {
    return '../movie_posters/' . $this->poster;
  }
}
?>