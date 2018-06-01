<?php
include 'user_functions.php';


$action = null;
if(isset($_POST['action'])){
  $action = $_POST['action'];
}

switch($action){
  case 'login':
    login($_POST['email'], $_POST['password']);
    break;
  case 'logout':
    logout();
    break;
  case 'checkLoginState':
    logged_in();
    break;
  case 'checkEmailMatch':
    checkRegEmail($_POST['email']);
    break;
  case 'get_user_info':
    getUserInfo();
    break;
  case 'add_link':
    add_link($_POST['link'], $_POST['direct']);
    break;
  case 'get_links':
    get_links();
    break;
  case 'removeWord':
    removeKeyWord($_POST['link_id']);
    break; 
}
echo json_encode($res);
?>
