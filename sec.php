<?php

require_once('settings.php');

function sec_session_start() {
    $session_name = 'sec_session_id'; // Set a custom session name
    $secure = false; // Set to true if using https.
    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params(3600, $cookieParams["path"], $cookieParams["domain"], $secure, false);
    $httponly = true; // This stops javascript being able to access the session id.
    session_name($session_name); // Sets the session name to the one set above.
    session_start();
    session_regenerate_id(); // regenerated the session, delete the old one.
}

function isUser($u, $p) {
    $db = null;

    try {
        $db = new PDO(getConnectionString(), getDBUserName(), getDBPassword());
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOEception $e) {
        die("Del -> " .$e->getMessage());
    }
    $q = "SELECT password FROM users WHERE username = ?";
    $s = array($u);

    $result;
    $stm;
    try {
        $stm = $db->prepare($q);
        $stm->execute($s);
        $result = $stm->fetch();


        if($result) {
            $hej = $result["password"];
            if(password_verify($p, $hej)){
                return true;
            }
        }
        return false;
    }
    catch(PDOException $e) {
        echo("Error creating query: " .$e->getMessage());
        return false;
    }
}

function getUser($user) {
    $db = null;

    try {
        $db = new PDO("sqlite:db.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOEception $e) {
        die("Del -> " .$e->getMessage());
    }
    $q = "SELECT * FROM users WHERE username = '$user'";

    $result;
    $stm;
    try {
        $stm = $db->prepare($q);
        $stm->execute();
        $result = $stm->fetchAll();
    }
    catch(PDOException $e) {
        echo("Error creating query: " .$e->getMessage());
        return false;
    }

    return $result;
}
