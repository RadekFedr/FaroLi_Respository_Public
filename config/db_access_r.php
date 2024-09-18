<?php
//Creates read only access into DB for loading box data using functions/read_dbobject.php
$servername = "localhost";
$username_r = "Write_Web_Reader_Role_Name_Here";
$password_r = "Write_Web_Reader_Role_Password_Here";
$dbname = "faroli_repository";
$port = "5432";

try {
  $conn_r = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username_r, $password_r);
  $conn_r->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo '<div style="margin-left: 2vw;">DB is successfully connected.</div>';
} catch(PDOException $e) {
  echo '<div style="margin-left: 2vw;">Connection to DB failed: ' . $e->getMessage() . '</div>';
  die();
}
?>
