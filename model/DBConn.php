<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2016-08-18
 * Time: 23:26
 */
namespace model;

require_once("Logger.php");
require_once ("view/LogView.php");
class DBConn{

    public $loggedIn = true;
    public $notLoggedIn = -1;
    private $pdo;

    /**
     * LoginDAL constructor.
     */
    public function __construct(){

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' .DB_LOGGER_DB_NAME;
        try {
            $this->pdo = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            exit('Connection error LOGIN');
        }
    }

    public function loginDB(){

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' .DB_LOGIN_NAME;
        try {
            $this->pdo = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            exit('Connection error LOGIN');
        }
    }
    /**
     * Function for login.
     * Checks username and password.
     * If user enter correct credentials a session will be set to "loggedIn".
     * If username or password don't match a error code will be set.
     * @param $username
     * @param $pass
     */
    public function doLogin($username, $pass){

        $this->loginDB();

        $sql = "SELECT username FROM ".DB_LOGIN_TABLE." WHERE username = :usernameInput";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':usernameInput',$username);
        $query->execute();
        $result1 = $query->fetchColumn();

        $sql = "SELECT password FROM ".DB_LOGIN_TABLE." WHERE password = :passwordInput";
        $query = $this->pdo->prepare($sql);

        $query->bindParam(':passwordInput',$pass);
        $query->execute();
        $result2 = $query->fetchColumn();

        if($result1 != false & $result2 !=false){
            if($username === $result1) {
                $_SESSION['loggedIn'] = $this->loggedIn;
            }
        }else{
            $_SESSION['NotLoggedIn'] =$this->notLoggedIn;
        }
    }

    /**
     * Check if user exist in the database.
     * @param $username
     * @return mixed
     */
    public function checkUserExist($username){
        $this->loginDB();

        $sql = "SELECT * FROM ".DB_LOGIN_TABLE." WHERE username = :usernameInput";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':usernameInput',$username);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);

    }

    /**
     * Checks if username is available
     * Returns true if username exist else returns false.
     * @param $user
     * @return bool
     */
    public function usernameAvailable($user){
        $this->loginDB();

        $username1 = $this->checkUserExist($user);
        if($username1['username'] === $user){
            return false;
        }
        return true;
    }

    /**
     * Register a new user
     * @param $username
     * @param $password
     * @return bool
     */
    public function doRegisterNewUser($username, $password){
        $this->loginDB();

        $sql = "INSERT INTO " . DB_LOGIN_TABLE . "(user_id,username,password) VALUES('' ,:username,:password)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        return $query->execute();

    }

    public function addVideo($video){

        $sql = "INSERT INTO " . DB_DEFAULTVIDEO_TABLE . "(id,video_id) VALUES('' ,:video)";
        $query = $this->pdo->prepare($sql);
        try{
            foreach($video as $value){
                $query->bindParam(':video', $value);
                $query->execute();
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getVideos(){
        $sql = "SELECT " . DB_DEFAULTVIDEO_VIDEO_ID . " FROM " .DB_DEFAULTVIDEO_TABLE;
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_COLUMN);
        return $result;
    }

    public function getLogControlData($session_ID,$id,$time){

        $sql = "SELECT data_id FROM logg WHERE id='$id' AND session_id='$session_ID' AND time_id='$time'";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function getLogTimeItems($ip,$session_id){
        //SELECT time_id FROM logg WHERE ip='127.0.0.1' AND session_id='9ejcpdhkqfgr3nfbi3765at190'

        $sql = "SELECT time_id,id FROM logg WHERE ip='$ip' AND session_id='$session_id'";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }

    public function getIP(){
        $sql = "SELECT DISTINCT ip FROM logg ORDER BY ip";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getSESSIONS($ip)
    {
        $sql = "SELECT DISTINCT session_id FROM logg WHERE ip='$ip'";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function logToDB($dataToDump){
       // var_dump($dataToDump);
        $sessionID = session_id();
        $sql = "INSERT INTO " . DB_LOGGER_TABLE . "(id,ip,session_id,data_id) VALUES('' ,:ip,:session_id,:data_id)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        $query->bindParam(':session_id', $sessionID);
        $query->bindParam(':data_id', $dataToDump);
        return $query->execute();
    }

}