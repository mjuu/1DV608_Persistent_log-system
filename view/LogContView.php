<?php
/**
 * Created by PhpStorm.
 * User: z3r00z
 * Date: 2017-02-22
 * Time: 15:38
 */
namespace view;

use model\LogModel;

class LogContView
{

    public static $showIP = 'showIP=';
    public static $showSession = 'showSession=';
    public static $showDebugTime = 'showDebugTime=';
    public static $selectedID = 'id=';
    private static $logout = "logout";


    /**
     * Show the correct view depending on the $data value.
     * @param $data
     */
    public function newView($data)
    {
        //HTML START
        $ret = '<!DOCTYPE html>
<html>
<body>
<h1 id="top">Log Viewer v.02</h1>';

        //first view of IPs
        $ret .= $this->logoutBTN().$this->homeBTN().'
             <h2>Select IP</h2><br>' . $this->getIPfromDB();
        //Dont show sessions if no IP is chosen
        if ($data === 1) {
            $ret .= '<h2>Select Session</h2>' . $this->getSessionfromDB();
        }
        //Show TimeItems
        if ($data === 2) {
            $ret .= '<h2>Select Session</h2>' . $this->getSessionfromDB(). '
             <h2>Select time</h2><br>' . $this->getTime();
        }
        //Show all data
        if ($data === 3) {
            $ret .= '<h2>Select Session</h2>' . $this->getSessionfromDB() . '
             <h2>Select time</h2><br>' . $this->getTime() . '<br>
             <h2>DATA:</h2><a id="data" href="#bottom"><h1><p align="center"> Down</p></h1></a>
' . $this->getData();
        }
        //HTML END
        $ret .= '
<a id="bottom" href="#top"><h1><p align="center"> Top</p></h1></a>
</body>
</html>';
        echo $ret;
    }

    /**
     * Fix to access logModel
     * @return LogModel
     */
    public function getLogModel()
    {
        return new LogModel();
    }

    /**
     * Fetch IP addresses from database
     * @return string
     */
    public function getIPfromDB()
    {
        $IPfromDB = $this->getLogModel()->getIPfromDB();
        $result = "";
        foreach ($IPfromDB as $n => $value) {
            $result .= '<a href="?' . self::$showIP . $value . '">' . "$value" . '</a><br>';
        }
        return $result;
    }

    /**
     * Fetch Sessions from database
     * @return string
     */
    public function getSessionfromDB()
    {
        $sessionFromDB = $this->getLogModel()->getSessionFromDB();
        $result = "";

        foreach ($sessionFromDB as $n => $value) {
            $result .= '<a href="?' . self::$showSession . $value . '">' . "$value" . '</a><br>';
        }
        return $result;
    }

    /**
     * Fetch debugTime from database
     * @return string
     */
    public function getTime()
    {
        $timeItemFromDB = $this->getLogModel()->getTimeItemFromDB();
        $result = "";

        foreach ($timeItemFromDB as $n => $value) {
            $result .= '<a href="?' . self::$showDebugTime . $value['time_id'] . '?' . self::$selectedID . $value['id'] . '">' . $value['time_id'] . '</a><br>';
        }
        return $result;
    }

    /**
     * Fetch debug data from database
     * @return string
     */
    public function getData()
    {
        loggHeader("Accessing data from database");
        loggThis("Data access",null, true);
        $this->logModel()->logToDB();
        $dataFromDB = $this->getLogModel()->getDataFromDB();
        $result = "";
        foreach ($dataFromDB as $n => $value) {
            $result .= $value;
        }
        return $result;
    }

    /**
     * Checks if clicked
     * returns true if clicked
     * @return bool
     */
    public function ipSelectClicked()
    {
        if ((isset($_GET['showIP'])) === true) {
            return true;
        }
    }

    /**
     * Checks if clicked
     * returns true if clicked
     * @return bool
     */
    public function sessionSelectClicked()
    {
        if ((isset($_GET['showSession'])) === true) {
            return true;
        }
    }

    /**
     * Checks if clicked
     * returns true if clicked
     * @return bool
     */
    public function timeItemClicked()
    {
        if ((isset($_GET['showDebugTime'])) === true) {
            return true;
        }
    }

    /**
     * Checks if clicked
     * returns true if clicked
     * @return bool
     */
    public function debugItemClicked()
    {
        if ((isset($_GET['showDebugItem'])) === true) {
            return true;
        }
    }

    /**
     * Do logout.
     * Destroys the sessions and then redirecting the user to the main page.
     */
    public function doLogout(){
        loggThis("Logout user");
        $this->logModel()->logToDB();
        session_destroy();
        return header("Location: ?");
    }

    /**
     * Show logout button
     * @return string
     */
    public function logoutBTN(){
        return "<a href='?" . self::$logout. "'> Sign out</a>";
    }

    /**
     * Show 'Back to start' button
     * @return string
     */
    public function homeBTN(){
        return "<a href='?'> Back to Start</a>";
    }

    /**
     * Returns true/false if user want to logout
     * @return bool
     */
    public function getLogout(){
        return isset($_GET[self::$logout]);
    }
}