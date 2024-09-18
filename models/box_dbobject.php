<?php
//Creates object of objects from loaded rows (records) from repository table of DB
class box_dbobjects {
  public $rows; 
  public function __construct($rows) {
    $this->rows = (array) $rows;
  }
}
?>