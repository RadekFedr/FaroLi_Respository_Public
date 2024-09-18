<?php
//Web scraper
/* Loads URL, title, link to favicon, description and keywords into input field of input_form.php
Communicates with functions/absolute_url.php for favicon link */
if ($db_load_button == "Load data") {
  $url_web = secure_input($_POST["url_web"]) ?? Null;
  $url_web_suggest = $url_web ?? Null;
    
  preg_match("/<title>(.+)<\/title>/siU", file_get_contents($url_web), $title_lines);
  $title_suggest = $title_lines[1] ?? "Title missing";
  preg_match("/<link.*rel.*icon.*href.*[\", \']{1}(.+)[\", \']{1}.*>/siU", file_get_contents($url_web), $favicon_url);
  if (isset($favicon_url[1])) {
    $icon_suggest = $favicon_url[1];
    if ($icon_suggest==$url_web) {
    $icon_suggest = "assets/images/Delwar018.png";
    }
    // Check if favicon URL is relative
    preg_match("/^http/i", $icon_suggest, $http_found);
    if (!isset($http_found[0])) {
        // If the favicon URL is relative absolute_url creates absolute URL
        $icon_suggest = absolute_url($url_web, $icon_suggest);
    }
  } else {
    $icon_suggest = "assets/images/Delwar018.png";  // Default icon missing image
  }

  $meta_tags = get_meta_tags($url_web) ?? Null;
  $meta_descript_suggest = $meta_tags['description'] ?? "Missing";
  $meta_keywords_suggest = $meta_tags['keywords'] ?? "Missing";

  $date_time_suggest = date("Y-m-d H:i:s") ?? Null;
} else {
  $url_web = $url_web_suggest = $title_suggest = $icon_suggest = $meta_tags = $meta_descript_suggest = $meta_keywords_suggest = $date_time_suggest = Null;
}
?>