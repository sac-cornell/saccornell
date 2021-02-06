<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}

// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.

//open db
$db = open_or_init_sqlite_db('secure/sac.sqlite', 'secure/init.sql');

//Cite: Lab 8 login
define('SESSION_COOKIE_DURATION', 60 * 30 * 1); //30 minutes
$session_messages = array();

//returns current user record or null
function log_in($un, $pw)
{
  global $db;
  global $current_user;
  global $session_messages;
  //verify username exists in DB
  if (isset($un) && isset($pw)) {
    $sql = "SELECT * FROM users WHERE un = :un;";
    $params = array(':un' => $un);
    $accounts = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($accounts) {
      $account = $accounts[0];
      //verify pw against its hash value, then create session
      if (password_verify($pw, $account['pw'])) {
        $session = session_create_id();
        $sql = "INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);";
        $params = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        //if saved to DB, send cookie and set/return current user
        if ($result) {
          setcookie("session", $session, time() + SESSION_COOKIE_DURATION);
          $current_user = $account;
          return $current_user;
        } else {
          array_push($session_messages, "Log in failure");
        }
      } else {
        array_push($session_messages, "Invalid username or password");
      }
    } else {
      array_push($session_messages, "Invalid username or password");
    }
  } else {
    array_push($session_message, "No username or password set");
  }
  $current_user = NULL;
  return NULL;
}


//returns a user record given a primary key id
function find_user($user_id)
{
  global $db;
  $sql = "SELECT * FROM users WHERE id = :user_id;";
  $params = array(':user_id' => $user_id);
  $users = exec_sql_query($db, $sql, $params)->fetchAll();
  if ($users) {
    return $users[0];
  }
  return NULL;
}

//helper function [find_session($sess) returns the current session if it is set ]
function find_session($session)
{
  global $db;
  if (isset($session)) {
    $sql = "SELECT * FROM sessions WHERE session = :session;";
    $params = array(':session' => $session);
    $sessions = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($sessions) {
      return $sessions[0];
    }
  }
  return NULL;
}


/*helper function [session_login()] returns the current user if session is
started and if current user is logged in */
function session_login()
{
  global $db;
  global $current_user;
  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];
    $s_record = find_session($session);
    if (isset($s_record)) {
      $current_user = find_user($s_record['user_id']);
      setcookie("session", $session, time() + SESSION_COOKIE_DURATION);
      return $current_user;
    }
  }
  $current_user = NULL;
  return NULL;
}

//[is_user_logged_in] returns a bool if [$current_user] has been set
function is_user_logged_in()
{
  global $current_user;
  return ($current_user != NULL);
}

//[is_admin_logged_in] returns a bool if [$current_user] has been set and is the admin
function is_admin_logged_in()
{
  global $current_user;
  return ($current_user != NULL && $current_user['un'] == 'admin');
}

//terminates session and current user is NULL
function log_out()
{
  global $current_user;
  setcookie('session', '', time() - SESSION_COOKIE_DURATION);
  $current_user = NULL;
}


//checks if form for login is filled out
if (isset($_POST['login']) && isset($_POST['un']) && isset($_POST['pw'])) {
  $username = trim($_POST['un']);
  $password = trim($_POST['pw']);
  log_in($username, $password);
} else {
  session_login();
}


//log off if user logged in and logout request is made
if (isset($current_user) && isset($_GET['logout']) || isset($_POST['logout'])) {
  log_out();
}
