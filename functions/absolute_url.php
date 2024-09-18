<?php 
//For proper loading FAVICON from URL - Creates absolute url path in case od relative favicon link on web page
//Sends $absolute_path into functions/load_webobject_data.php web scraper function
function absolute_url($base, $relative) {
    // Parses base URL and convert to absolute path
    $parsed_base = parse_url($base);

    // If relative URL starts with "/", uses the base scheme and host
    if (substr($relative, 0, 1) == "/") {
        return $parsed_base["scheme"] . "://" . $parsed_base["host"] . $relative;
    }

    // Removes the file name of the base URL
    $path = $parsed_base["path"];
    $path = preg_replace("/\/[^\/]*$/", "", $path);

    // If go to parent folder (../) in the relative path
    while (preg_match("/^\.\.\//", $relative)) {
        $path = preg_replace("/\/[^\/]*$/", "", $path);
        $relative = preg_replace("/^\.\.\//", "", $relative);
    }

    // Combines paths
    $absolute_path = $path . "/" . $relative;
    return $parsed_base["scheme"] . "://" . $parsed_base["host"] . $absolute_path;
}
?>