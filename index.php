<?php
session_start(); 
define ("ROOT", str_replace("\\", "/", __DIR__)."/");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>FaroLi™ Repository</title>
  <meta charset="UTF-8">
  <!--FAVICON-->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico"> 
  <!--Link to CSS-->
  <link rel="stylesheet" href="assets/styles/main.css">  
  <!--Responsive scaling-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  
  <!-- SEO -->
  <meta name="application-name" content="FaroLi™">
  <meta name="description" content="Repository of AI, machine learning, interesting web pages and GIT tools.">
  <meta name="keywords" content="FaroLi, repository, AI, artificial intelligence, machine learning, computer vision, GIS, GIT">
  <meta name="author" content="Radek Fedr">

  <link rel="author" target="_blank" href="https://www.linkedin.com/in/radek-fedr">
  <link rel="license" target="_blank" href="index.php#Terms">
</head>

<!--BODY-->
<body>
  <!-- Interactive arrow aside returns to top of page-->
  <a class="returntop" href="#Top" target="_self">&#11105;<br>Top</a>

  <!-- HEADER BAR -->
  <section id="Top">
  <header>
    <div class="head1">
      <a href="https://github.com/RadekFedr" target="_blank">
        <img src="assets/images/Feather.png" alt="PiiRko" style="width: 5rem; rotate: -45deg;">
      </a>
    </div>
  
    <div class="head2"><h1 style="margin: 0;"><a href="index.php">FaroLi</a></h1></div>
    
  <?php
  //Secures and cleans all input data
  require_once (ROOT."functions/secure_inputs.php");

  //Admin access buttons
  $log_in =
    '<div class="log">
      <a class="logbutton" href="'.secure_input($_SERVER["PHP_SELF"]).'?LogButton=1" target="_self">Log <br>in</a>
    </div>';
 
  $log_out =
    '<div class="log">
       <a class="logbutton" href="'.secure_input($_SERVER["PHP_SELF"]).'?LogButton=0" target="_self">Log <br>out</a>
     </div>';

  //Admin access form
  $admin_log = 
    '<div class="admin_log">
       <form action="'.secure_input($_SERVER["PHP_SELF"]).'" method="POST" autocomplete="off">
         <label for="user_name">Admin name:</label>
         <input type="text" id="user_name" name="admin_web" required><br>
         <label for="admin_psw">Password:</label>
         <input type="password" id="admin_psw" name="psw_web" required><br>
         <input type="submit" class="log_form" value="Log in">
       </form>  
     </div>';

  $admin_log_wrong =
    '<div class="admin_log" style="line-height: 1rem;">
       <span style="color: red;">Wrong name <br>or password!</span>
       <form action="'.secure_input($_SERVER["PHP_SELF"]).'" method="POST" autocomplete="off">
         <label for="user_name">Admin name:</label>
         <input type="text" id="user_name" name="admin_web" required><br>
         <label for="admin_psw">Password:</label>
         <input type="password" id="admin_psw" name="psw_web" required><br>
         <input type="submit" class="log_form" value="Log in">
       </form>  
     </div>';

  //ADMIN ACCESS LOGIC - uses functions in "functions" folder and webadmin_autorization in "config" folder
  //Loads "admin_log" form or logs admin out => "Log_in" button, destroyes session
  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['LogButton'])) {
    $login_menu = (int) secure_input($_GET['LogButton']) ?? Null;
    switch ($login_menu) {
      case 1:    
      echo $admin_log;
      break;
      case 0:
      session_unset();
      session_destroy();
      echo $log_in;
      break;
    }
  }
  
  //Loads authorization for admin account 
  require_once (ROOT."config/webadmin_authorization.php");

  //Authorizes Admin from session => log_out button; - admin_name and password is saved in session
  if (isset($_SESSION["keep_admin"]) && isset($_SESSION["keep_psw"])) {
   $check_log = authorization($_SESSION["keep_admin"], $_SESSION["keep_psw"]) ?? Null;
   if ($check_log === True) {
     echo $log_out;
   } else {
     echo $log_in;
   }
  }
  
  //Authorizes Admin => log_out button + admin_name and password is saved in session
  if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_SESSION["keep_admin"]) || !isset($_SESSION["keep_psw"])) && (isset($_POST["admin_web"]) || isset($_POST["psw_web"]))) {
    $admin_web = secure_input($_POST["admin_web"]) ?? Null;
    $psw_web = str_replace("&quot;", "", secure_input($_POST["psw_web"])) ?? Null;
    $check_log = authorization($admin_web, $psw_web);
    if ($check_log === True) {
      echo $log_out;
      $_SESSION["keep_admin"] = $admin_web;
      $_SESSION["keep_psw"] = $psw_web;
    } elseif ($check_log === False){
        echo $admin_log_wrong;
    } else {
        echo $log_in;
    }
  } elseif (!isset($_GET['LogButton']) && (!isset($_SESSION["keep_admin"]) || !isset($_SESSION["keep_psw"]))) {
    echo $log_in;  
  }
  ?>
  </header>

<!-- NAVIGATION BAR -->  
  <nav>
    <ul class="menu">
        <a href="#Repository" target="_self"><li>Repository</li></a>
        <a href="#Network" target="_self"><li>Network</li></a>
    </ul>
  </nav>

<!-- INPUT FORM -->  
<?php
/* Admin is authorized ($check_log=True) => loads input form, read/write connection into DB is established
if load_data button of input form is activated, web scraper loads data into fields of input form based on input URL
if submit button is activated, webobject model(boxes=saved links, description...etc. in repository) is saved into Postgres DB */
$check_log = !isset($check_log) ? (bool) $check_log = False : (bool) secure_input($check_log);  
if ($check_log === True) {
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["load_data"])) {
    $db_load_button = secure_input($_POST["load_data"]) ?? Null;
      include_once (ROOT."functions/absolute_url.php");
      include_once (ROOT."functions/load_webobject_data.php");
  } else {
    $db_load_button = Null;
  }
  include_once (ROOT."components/input_form.php");
  include_once (ROOT."config/db_access_rw.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["db_insert"])) {
    $db_insert_button = secure_input($_POST["db_insert"]) ?? Null;
    include_once (ROOT."models/box_webobject.php");
    include_once (ROOT."functions/create_webobject.php");
    include_once (ROOT."functions/write_webobject.php");
  } else {
    $db_insert_button = Null;
  }  
}
?>


<!-- MAIN SECTION -->
<div id="Repository" class="headline">
    <h3>Repository</h3>
</div>


  <main>
    <!-- ORDERING MENU -->
    <?php
    $options = (array) [
      "new_old" => "new &#11106; old",
      "old_new" => "old &#11106; new",
      "alphabetically" => "alphabetically"
    ];

    /* Chooses $selected_option and sends ordering value to functions/read_db_object.php, 
    stores selected ordering into session,
    shows 2 non-selected options in submenu */
    if (isset($_GET["order"])) {
      $selected_option = secure_input($_GET["order"]);
      $_SESSION["order_option"] = $selected_option;
    } elseif (isset($_SESSION["order_option"])) {
      $selected_option = $_SESSION["order_option"];
    } else {
      $selected_option = "new_old";
    }
    $selected_text = $options[$selected_option];
    ?>

    <form method="GET" action="<?php secure_input($_SERVER["PHP_SELF"]); ?>">
    <button type="submit" name="order" value="<?php echo $selected_option; ?>" class="order_btn">
        Ordering: <?php echo $selected_text; ?> &#11205;
    </button>
    <div class="order_content">
        <?php foreach ($options as $key => $value): ?>
            <?php if ($key != $selected_option): ?>
                <button type="submit" name="order" value="<?php echo $key; ?>" class="order_link"><?php echo $value; ?></button><br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    </form>  
    
    <!-- BOXES/RECORDS LOADED FROM DB -->
    <div class="repo">
    <?php
    //Establishes read access to DB, loads saved boxes/data in DB and creates tiles on index page 
    require_once (ROOT."config/db_access_r.php");
    require_once (ROOT."models/box_dbobject.php");
    require_once (ROOT."functions/read_dbobject.php");
    
    $web_pages = (array) array_column($fetched_rows->rows, "url_web");
    if (!empty($web_pages)) {
      foreach ($fetched_rows->rows as $objects) {
        $box_url = (string) $objects["url_web"];
        $box_icon_url = (string) $objects["icon_url"];     
        $box_title = (string) $objects["title"];
        $box_desc = (string) $objects["descript"];
        $box_key = (string) $objects["keywords"];
        $page_status = get_headers($objects["url_web"]);
        if (!$page_status || strpos( $page_status[0], "404")) {
          echo "<a href='" . $box_url . "' target='_blank' class='image_box', style='border: 1px solid var(--decocolred);'> 
      <img class='frontpage' src='" . $box_icon_url . "' alt='Page'>
      <div class='box_description'><b>Description:</b> " . substr($box_desc, 0, 90) . "</div>
      <div class='box_keywords'><b>Keywords:</b> " . substr($box_key, 0, 90) . "</div>
      <div class='box_title'>" . substr($box_title, 0, 40) . "</div>
      </a>";
        } else {
          echo "<a href='" . $box_url . "' target='_blank' class='image_box'> 
      <img class='frontpage' src='" . $box_icon_url . "' alt='Page'>
      <div class='box_description'><b>Description:</b> " . substr($box_desc, 0, 90) . "</div>
      <div class='box_keywords'><b>Keywords:</b> " . substr($box_key, 0, 90) . "</div>
      <div class='box_title'>" . substr($box_title, 0, 40) . "</div>
      </a>";
        }
      }  
    } else {
      $box_url = secure_input($_SERVER["PHP_SELF"]);
      $box_icon_url = "assets/images/Delwar018.png";
      $box_title = (string)"Empty DB";
      $box_desc = (string) "Empty DB or no DB connection";
      $box_key = (string) "Empty DB or no DB connection";
      echo "<a href='" . $box_url . "' target='_blank' class='image_box', style='border: 1px solid var(--decocolred);'> 
      <img class='frontpage' src='" . $box_icon_url . "' alt='Page'>
      <div class='box_description'><b>Description:</b> " . substr($box_desc, 0, 90) . "</div>
      <div class='box_keywords'><b>Keywords:</b> " . substr($box_key, 0, 90) . "</div>
      <div class='box_title'>" . substr($box_title, 0, 40) . "</div>
      </a>";
    }    
    ?>
    </div>

  <!-- PAGINATION -->
  <div class="pagination">
    <?php
    //Pagination logic, sends $current_page value to functions/read_db_object.php;
    $count = (int) 1;
    $page_back = $current_page > 1 ? $page_back = $current_page-1 : $page_back = 1;
    echo '<a href="'.secure_input($_SERVER["PHP_SELF"]).'?page='.$page_back.'">&laquo;</a>';
    do {
      if ($count<$current_page-2) {
        $page_now = "hidden_page";
      } elseif ($count==$current_page) {
        $page_now = "now_page";
      } elseif ($count>$current_page+2) {
        $page_now = "hidden_page";
      } else {
        $page_now = ""; 
      }
      echo '<a href="'.secure_input($_SERVER["PHP_SELF"]).'?page='.$count.'" class="'.$page_now.'">' . $count . '</a>';
      $count++;
    } while ($count <= $no_pages);
    $page_forward = $current_page < $no_pages ? $page_forward = $current_page+1 : $page_forward = $current_page;
    echo '<a href="'.secure_input($_SERVER["PHP_SELF"]).'?page='.$page_forward.'">&raquo;</a>';
    ?>
  </div>
  </main>
 
 
<!-- CLUSTER NETWORK -->  
  <div class="spacer">
    <svg class="spacer_left" height="1rem" width="85%">
          <rect x="0" y="0" width="85%" height="1rem" />
          <rect x="83.75%" y="0" rx="0.5rem" width="2.5%" height="1rem" />
          Sorry, your browser does not support inline SVG
    </svg>
    
    <div id="Network" class="net">
      <h5 style="margin: 0.05rem 0rem 0.2rem 0rem;">Network</h5>
    </div>
  </div>
  <!-- Interactive network.html (in root folder) is created after manual run of lib/scripts/Network.py script -->
  <div class="repocontainer">
  <iframe src="network.html" title="Repository network" class="network"></iframe>
  </div>


<!-- FOOT -->  
  <footer>
    <div class="left">&#169;<?php echo date("Y") . " Radek Fedr" ?></div>
    <div class="right"><a href="#Terms" target="_self">Terms & conditions</a></div>
  </footer>
  <!-- Terms & Conditions & Acknowledgement -->
  <div id="Terms">
      <b>Terms of Use:</b><br />
      The application is solely for demonstrating the author's skills and is not intended for public use. Links, titles, keywords, and descriptions are stored only within the application.
      The author thanks Annie Spratt and Tyler Maddigan for the photos provided from Unsplash.com.</p>
      <b>License:</b><br />
      &#169; Radek Fedr <?php echo date("Y")?>
  </div>
  </section>


<!-- LIGHTHOUSE ASIDE -->
  <aside>
    <img src="assets/images/tyler-maddigan-dWnz_rdQBOU-unsplash.png" alt="LightHouse" style="width: 100%;">
  </aside>
</body>
</html>