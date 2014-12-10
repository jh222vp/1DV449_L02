<?php
function getMessPage()
{
    return '
<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
    <link rel="shortcut icon" href="pic/favicon.png">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
	<style type="text/css">
	</style>
    
	<title>Messy Labbage</title>
  </head>
	  
	  	<body background="http://www.lockley.net/backgds/big_leo_minor.jpg">        

        <div id="container">
            
            <div id="messageboard">
                <input class="btn btn-danger" type="button" id="buttonLogout" value="logout" name="logout"/>

                <div id="messagearea"></div>
                
                <p id="numberOfMess">Antal meddelanden: <span id="nrOfMessages">0</span></p>
                Name:<br /> <input id="inputName" type="text" name="name" /><br />
                Message: <br />
                <textarea name="mess" id="inputText" cols="55" rows="6"></textarea>
                <input class="btn btn-primary" type="button" id="buttonSend" value="Write your message" />
				<input class="hidden" id="token" value="'.$_SESSION["token"]. '"
                <span class="clear">&nbsp;</span>

            </div>
        </div>

			<script src="js/bootstrap.js"></script>
            <script type="text/javascript" src="js/polling.js"></script>
            <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
            <script src="js/Message.js"></script>
            <script src="js/MessageBoard.js"></script>
	</body>
	</html>';
}