<?php

function getPage(){
    return '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <metal name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/LoginStyle.css" />


    <title>Mezzy Labbage - Logga in</title>

    <!-- Bootstrap core CSS -->

  </head>

  <body>
    <div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Log in</h2>
        <input value="" name="username" type="text" class="form-control" placeholder="Anv�ndarnamn" required autofocus>
        <input value="" name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>
    </div> <!-- /container -->
  </body>
</html>';
}

function check(){

    if(isset($_SESSION["username"]))
    {
        return true;
    }
}