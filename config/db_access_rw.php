<?php
//Creates read/write webadmin access into DB for saving box data using functions/write_webobject.php
$servername = "127.0.0.1";
$username_rw = "Write_Web_Admin_Role_Name_Here";
$password_rw = "Write_Web_Admin_Role_Password_Here";
$dbname = "faroli_repository";
$port = "5432";

try {
  $conn_rw = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username_rw, $password_rw);
  $conn_rw->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo '<div style="margin-left: 2vw;">DB is successfully connected.</div>';
} catch(PDOException $e) {
  echo '<div style="margin-left: 2vw;">Connection to DB failed: ' . $e->getMessage() . '</div>';
  die();
}
?>
