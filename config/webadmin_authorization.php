<?php
//Admin authorization - $input_name and $input_web(=password) acquired from admin login form on index page
function authorization($input_name, $input_web) {
  $admin_name = (string)"Write_app_admin_name_here";
  $password = password_hash("Write_app_admin_password_here", PASSWORD_DEFAULT);
  if ($input_name === $admin_name && password_verify($input_web, $password) === True) {
    return (bool)True;   
  } else {
    return (bool)False;
  }
}
?>