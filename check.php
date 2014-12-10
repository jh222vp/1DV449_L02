<?php
require_once('sec.php');

// Check if user is OK
function validUser()
{
// check tha POST parameters
    if(isset($_POST['username']) && $_POST['password']){
        $u = trim(strip_tags($_POST['username']));
        $p = trim(strip_tags($_POST['password']));
    }

    if(isset($u) && isset($p) && isUser($u, $p)) {

        $_SESSION["token"] = uniqid();
        $_SESSION['username'] = $u;
        return true;
    }
    else {
        return false;
    }
}