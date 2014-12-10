<?php
require_once('settings.php');
require_once('sec.php');
require_once('dbConnect.php');
new get();

class get {

    public function __construct()
    {
        $mode = $this->fetch('mode');
        switch($mode)
        {
            case 'get':
                $this->getMessages();
                break;
            case 'post':
                $this->postMessage();
                break;
        }
    }

    public function postMessage(){
        $token = $this->fetch('token');
        $name = strip_tags($this->fetch('user'));
        $message = strip_tags($this->fetch('message'));
        if(empty($name) || empty($message)) {
            $this->output(false, "You must enter both a namne and a message");
            return false;
        }
        sec_session_start();

        if($_SESSION['token'] != $token) {
            session_write_close();
            http_response_code(403);
            return false;

        } else {
            $db = db();
            try {
                $q = "INSERT INTO messages (message, user) VALUES(?, ?)";
                $params = array($message,$name);
                $stm = $db->prepare($q);
                $stm->execute($params);
            } catch (PDOException $e) {
                return false;
            }
        }
    }

// get the specific message
    function getMessages() {

        $db = null;
        try
        {
            $db = new PDO(getConnectionString(), getDBUserName(), getDBPassword());
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOEception $e) {
            die("Del -> " .$e->getMessage());
        }

        $numberOfMessages = $this->fetch('numberOfMessages');
        $endtime = time() + 20;
        $lasttime = $this->fetch('lastTime');
        $curtime = null;

        while(time() <= $endtime){
            try
            {
                $query = "SELECT * FROM messages ORDER BY timestamp desc LIMIT 0, 30";
                $stm = $db->prepare($query);
                $stm->execute();
                $result = $stm->fetchAll();
            }
            catch (Exception $e)
            {

            }

            if($result){
                $curtime = strtotime($result[0]['timestamp']);
            }
            if(!empty($result) && $curtime != $lasttime)
            {
                $messages = array();

                $newMessages = count($result) - $numberOfMessages;
                for($i = 0; $i < $newMessages; $i++)
                {
                    $messages[] = $result[$i];
                }
                $this->output(true, '', array_reverse($messages), $curtime);
                break;
            }
            else
            {
                sleep(1);
            }
        }
    }

    public function fetch($name){
        $val = isset($_POST[$name]) ? $_POST[$name] : '';
        return $val;
    }

    public function output($result, $output, $message = null, $latest = null){
        echo json_encode((array(
            'result' => $result,
            'message' => $message,
            'output' => $output,
            'latest' => $latest
        )));
    }
}