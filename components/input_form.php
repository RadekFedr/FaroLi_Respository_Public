<?php
//Creates DB input form if admin is logged in, loads input fields form URL using functions/load_webobjetct_data.php
$url_web_suggest = isset($url_web_suggest) ? secure_input($url_web_suggest) : "";
$title_suggest = isset($title_suggest) ? secure_input($title_suggest) : "";
$icon_suggest = isset($icon_suggest) ? secure_input($icon_suggest) : "";
$meta_descript_suggest = isset($meta_descript_suggest) ? secure_input($meta_descript_suggest) : "";
$meta_keywords_suggest = isset($meta_keywords_suggest) ? secure_input($meta_keywords_suggest) : "";
$date_time_suggest = isset($date_time_suggest) ? secure_input($date_time_suggest) : "";

echo '<div id="Network" class="net" style="margin-top: 1rem;">
    <h5 style="margin: 0.05rem 1.5rem 0.2rem 0rem;">Input</h5>
  </div>

  <div>
    <form id="input_form" action="' . secure_input($_SERVER["PHP_SELF"]) . '" target="_self" method="POST">
      <label style="padding-left: 5px; font-size: 1.5rem; font-weight: bold;">Webpage:</label>
      <input type="url" name="url_web" value="' . $url_web_suggest . '" required autofocus style="width: 100%;">
      <fieldset>
        <legend>Database:</legend>
        <div class="form_detail">
          <label>Title:</label>
          <input type="text" name="title" value="' . $title_suggest . '">
          <label>Favicon url:</label>
          <input type="text" name="url_favicon" value="' . $icon_suggest . '">
        </div>
        <div class="form_detail">
          <label>Description:</label>
          <input type="text" name="descript" value="' . $meta_descript_suggest . '">
          <label>Keywords:</label>
          <input type="text" name="keywords" value="' . $meta_keywords_suggest . '"><br>
        </div>
        <div class="form_detail">
          <label>Date &#38; Time:</label>
          <input type="datetime-local" name="insert_date" value="' . $date_time_suggest . '">
          <label for="vehicle1"> Read/Unread</label>
          <input type="checkbox" name="checkbox" value="1">
        </div>
      </fieldset>
      <input type="submit" name="load_data" value="Load data"  class="button_style">
      <input type="submit" name="db_insert" value="Submit into DB" class="button_style">
    </form>
  </div>';
?>