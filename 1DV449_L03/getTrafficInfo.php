<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 2014-12-11
 * Time: 11:45
 */

require_once("./Requests.php");

Requests::register_autoloader();

//BOrtkommenterad för att minska requesten till SR i onödan.
//$request = Requests::get("http://api.sr.se/api/v2/traffic/messages?format=json&indent=true&size=100");

//file_put_contents("cache.json", $request->body);

echo file_get_contents("cache.json");