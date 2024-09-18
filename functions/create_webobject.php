<?php
//Creates box_webobject (=data of box=db record), which is recorded into DB using functions/write_webobject.php 
if ($db_insert_button == "Submit into DB") {
  $url_web = filter_var(secure_input($_POST["url_web"]), FILTER_SANITIZE_URL) ?? Null;
  $favicon_url = secure_input($_POST["url_favicon"]) ?? Null;
  $title = secure_input($_POST["title"]) ?? Null;
  $descript = secure_input($_POST["descript"]) ?? Null;
  $keywords = secure_input($_POST["keywords"]) ?? Null;
  $insert_date = secure_input($_POST["insert_date"]) ?? Null;
  $checkbox = isset($_POST["checkbox"]) ? secure_input($_POST["checkbox"]) : $checkbox = 0;
  if (empty($checkbox)) $checkbox = "0";
  $web_object = new box_webobject($url_web, $favicon_url, $title, $descript, $keywords, $insert_date, $checkbox);
} else {
  $url_web = $favicon_url = $title = $descript = $keywords = $insert_date = $checkbox = Null;
}
?>