<?php

 //Get a connection to the database
function db_connect(){
  $db_uid = 'root';
  $db_pwd = '';
  // $db_uid = 'flea';
  // $db_pwd = '121murray';
  $connString = 'mysql:host=localhost;dbname=flea;charset=utf8';

  $pdo = new PDO($connString, $db_uid, $db_pwd);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $pdo;
}

//Called in the event of a database error
function db_error($err){
  //TODO Something useful with this
}


class Query{

  //Get the password to match an email address for login
  const GET_LOGIN_DETAILS = '
    SELECT user_id, password
    FROM user
    WHERE email = :email;
  ';
  const CHECK_EMAIL_FOR_MATCH = 'SELECT * FROM user WHERE email = :email';

  const GET_USER_INFO = 'SELECT * FROM user WHERE user_id = :user_id';

  const ADD_LINK = "INSERT INTO links(link, direct)VALUES(:link, :direct)";

  const GET_LINKS = "SELECT * FROM links ORDER BY link ASC";

  const REMOVE_KEY_WORD = "DELETE FROM links WHERE link_id = :linkID";

  const GET_USER_SCORE = 'SELECT percent FROM quiz WHERE user_id = :user_id && quiz_id = :quiz_number';

  const SAVE_BANK_BREAKER = 'INSERT INTO bank_breaker(user_id, mod_one_score)VALUES(:user_id, :mod_one_score)';

  const UPDATE_BANK_BREAKER = 'UPDATE bank_breaker SET mod_one_score = :mod_one_score WHERE user_id = :user_id';

  const CHECK_HIGH_SCORE = 'SELECT mod_one_score FROM bank_breaker WHERE user_id = :user_id';
}
