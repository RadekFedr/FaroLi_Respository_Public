<?php
//Records inputs from components/input_form.php (web_object data) into repository table in DB
//Communicates with components/input_form.php and models/box_webobject.php
$db_insert_button = secure_input($_POST["db_insert"]);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $db_insert_button == "Submit into DB") {
  try {
    $conn_rw = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username_rw, $password_rw);
    $conn_rw->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //Prepared insert query
    $sql_insert = $conn_rw->prepare("INSERT INTO repository (url_web, icon_url, title, descript, keywords, insert_date, checkbox) 
    VALUES (:url_web, :icon_url, :title, :descript, :keywords, :insert_datetime, :checkbox);");
    $sql_insert->bindParam(':url_web', $web_object->url_web_w);
    $sql_insert->bindParam(':icon_url', $web_object->favicon_url_w);
    $sql_insert->bindParam(':title', $web_object->title_w);
    $sql_insert->bindParam(':descript', $web_object->descript_w);
    $sql_insert->bindParam(':keywords', $web_object->keywords_w);
    $sql_insert->bindParam(':insert_datetime', $web_object->insert_date_w);
    $sql_insert->bindParam(':checkbox', $web_object->checkbox_w);

    $sql_insert->execute();
    echo '<div style="margin-left: 2vw;">New web recorded into database.</div>';
  } catch(PDOException $e) {
    echo '<div style="margin-left: 2vw;">' . $sql_w . '<br>' . $e->getMessage() . '</div>';
  }
  $conn_rw = Null;
} 
?>