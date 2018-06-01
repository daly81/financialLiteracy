<?php

  include '../connect.php';
  include 'password.php';
  
  $con = db_connect(); 
  $res = new stdClass();
  
  $email = $_POST['reg_email'];
  $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name']; 
  
  $stm = $con->prepare('
      INSERT INTO user (email, password, first_name, last_name)
      VALUES (:email, :password, :first_name, :last_name);'
  );
  $res->success = $stm->execute(array(
    ':email' => $email,
    ':password' => $password,
    ':first_name' => $firstName,
    ':last_name' => $lastName
  ));
  
  echo json_encode($res);  

?>
