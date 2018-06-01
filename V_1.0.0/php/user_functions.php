<?php
  include '../connect.php';
  include 'password.php'; 
  $res = new stdClass();
  
  function login($email, $pass_attempt){
    global $res;
    $con = db_connect();
    $stm = $con->prepare(Query::GET_LOGIN_DETAILS);
    $stm->execute(array(
      ':email' => $email
    ));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    
    if(password_verify($pass_attempt, $result['password'])){
      session_start();
      $_SESSION['logged_in'] = true;
      $_SESSION['user_id']  = $result['user_id'];
      $res->success = true;
    }else{
      $res->success = false;
      $_SESSION['logged_in'] = false;
      session_write_close();
    }
    
  }
  //CHECK DATABASE FOR ANY EMAIL MATCHES
  function checkRegEmail($email_attempt){
    global $res;
    $con = db_connect();
    $stm = $con->prepare(Query::CHECK_EMAIL_FOR_MATCH);
    $stm->execute(array(
      ':email' => $email_attempt
    ));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    
    if ($email_attempt == $result['email']){
      $res->success = false;
    } else {
      $res->success = true; 
    }
  }
  
  function logout(){
    global $res;
    session_start();
    session_destroy();
    $res->success = true;
  }
  //======================================================================================================
  function logged_in(){
    global $res;
    session_start(); 
    if(!isset($_SESSION['logged_in'])){
      $res->success = false;
    } else {
      $res->success = true; 
    }
    session_write_close(); 
  }
  //======================================================================================================
  function getUserInfo(){
    global $res;
    $con = db_connect();
    session_start();
    
    $stm = $con->prepare(Query::GET_USER_INFO);
    $stm->execute(array(
      ':user_id' => $_SESSION['user_id'] 
    )); 
    $res = $stm->fetch(PDO::FETCH_ASSOC);
    
    session_write_close(); 
  }
  //=========================================ADDING AND LINKING KEY WORDS TO SITE========================================
  function add_link($link, $direct){
    global $res;
    $con = db_connect();
    $stm = $con->prepare(Query::ADD_LINK);
    $stm->execute(array(
      ':link' => $link,
      ':direct' => $direct
    ));
    
    if($stm){
      $res->success = true; 
    }else{
      $res->success = false; 
    }
    
  };
  
  //Getting key words and links in an array 
  function get_links(){
    global $res;
    $con = db_connect();
    $stm = $con->prepare(Query::GET_LINKS);
    $stm->execute();
    $res = array();
    while($row = $stm->fetch()){
        array_push($res, $row);
    } 
  };
  //deleting key words from database
  function removeKeyWord($keyWordID){
    $con = db_connect();
    $stm = $con->prepare(Query::REMOVE_KEY_WORD);
    $stm->execute(array(
      ':linkID' => $keyWordID
    ));
  }




?>