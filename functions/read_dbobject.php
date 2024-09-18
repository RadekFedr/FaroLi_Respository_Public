<?php
//Reads records for index.php part BOXES/RECORDS LOADED FROM DB
//Communicates with ORDERING MENU and PAGINATION ($no_pages) part on index.php
//Definition of object box_dbobjects in models/box_dbobject.php
try {
  $conn_r = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username_r, $password_r);
  $conn_r->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //Count number of records in DB for pagination on index.php
  $sql_db_items = $conn_r->query('SELECT COUNT(box_id) FROM repository');
  $sql_db_items = $sql_db_items->fetch(PDO::FETCH_ASSOC);
  $no_pages = (int) ceil($sql_db_items["count"]/20);
  //echo $sql_db_items["count"];

  //Ordering - Prepared insert query according ordering options
  switch ($selected_option) {
    case 'new_old':
      $ordering_sql = 'insert_date DESC';
      break;
    case 'old_new':
      $ordering_sql = 'insert_date ASC';
      break;
    case 'alphabetically':
      $ordering_sql = 'title ASC';
      break;
    default:
      $ordering_sql = 'insert_date DESC';
  }
  
  //Pagination
  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['page'])) {
  $current_page = (int) secure_input($_GET['page']);
  $_SESSION["page_set"] = (int) $current_page;
  } elseif (isset($_SESSION["page_set"])) {
    $current_page = (int) $_SESSION["page_set"]; 
  } else {
    $current_page = (int) 1;
  }
  $db_position = (int) ($current_page*20)-20;
  
  //Reads data from "repository" table of DB
  $sql_read = $conn_r->prepare('SELECT url_web, icon_url, title, descript, keywords, insert_date FROM repository ORDER BY '. $ordering_sql .' LIMIT 20 OFFSET '. $db_position .';');
  //echo var_dump($sql_read);
  $sql_read->execute();
  
  //Sets the resulting array to associative box_dbobjects (object of objects)
  $result = $sql_read->setFetchMode(PDO::FETCH_ASSOC);
  $fetched_rows = new box_dbobjects($sql_read->fetchAll());
  $conn_r = Null;   
} catch(PDOException $e) {
  echo '<div style="margin-left: 2vw;">' . $sql_read . '<br>' . $e->getMessage() . '</div>';
  $conn_r = Null;
}
?>