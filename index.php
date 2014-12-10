<?php

require_once('Login.php');
require_once('mess.php');
require_once('check.php');
sec_session_start();

if(isset($_GET["action"]))
{
    if($_GET["action"] == "logout")
    session_destroy();
}

if(check()){
    echo getMessPage();
}
else if(validUser())
{
    echo getMessPage();
}
else{
    echo getPage();
}