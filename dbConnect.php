<?php
require_once('settings.php');

function db(){
    try {
        $db = new PDO(getConnectionString(), getDBUserName(), getDBPassword());
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOEception $e) {
        return false;
    }
    return $db;
}