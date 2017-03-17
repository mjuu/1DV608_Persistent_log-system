<?php
/**
 * Created by PhpStorm.
 * User: z3r00z
 * Date: 2017-03-15
 * Time: 14:02
 */
namespace model;

class LogModel
{
    public $dbcon;
    private $logCollection;
    public $logView;
    public $ipArr = [];
    public $standardView;
    public $id;

    /**
     * LogModel constructor.
     */
    public function __construct()
    {
        $this->dbcon = new \model\DBConn();
        $this->logCollection = new \logger\LogCollection();
        $this->logView = new \view\LogContView();
        $this->standardView = new \view\view(new videoModel());

    }

    /**
     * Shows the correct view depending on what the user clicked on
     */
    public function renderView()
    {
        if ($this->standardView->viewLogBTNClicked()) {
            $this->logView->newView(0);
        } elseif ($this->logView->ipSelectClicked()) {
            $this->setSelectedIPinSession();
            $this->logView->newView(1);
        } elseif ($this->logView->sessionSelectClicked()) {
            $this->setSelectedSESSIONinSession();
            $this->logView->newView(2);
        } elseif ($this->logView->timeItemClicked()) {
            $this->setSelectedDebugTimeinSession();
            $this->logView->newView(3);
        } else {

        }
    }

    /**
     * Set the selected IP to session
     */
    public function setSelectedIPinSession()
    {
        $_SESSION['selIP'] = $_GET['showIP'];
    }

    /**
     * Set the selected Session to session
     */
    public function setSelectedSESSIONinSession()
    {
        $_SESSION['selSession'] = $_GET['showSession'];

    }

    /**
     * Set the selected debugItem to session
     * and extract id of the debugItem
     */
    public function setSelectedDebugTimeinSession()
    {
        $data = $_GET['showDebugTime'];
        $this->id = substr($data, strpos($data, "=") + 1);
        $_SESSION['selTime'] = $_GET['showDebugTime'];
        $_SESSION['selID'] = $this->id;

    }

    /**
     * Get a array of logged IPs from Database
     * @return array
     */
    public function getIPfromDB()
    {
        return $this->ipArr = $this->dbcon->getIP();
    }

    /**
     * Get a array of Session from the selected IP,
     * from the Database
     * @return array
     */
    public function getSessionFromDB()
    {
        return $this->dbcon->getSESSIONS($_SESSION['selIP']);
    }

    /**
     * Get the time when a debugItem was logged
     * @return array
     */
    public function getTimeItemFromDB()
    {
        return $this->dbcon->getLogTimeItems($_SESSION['selIP'], $_SESSION['selSession']);
    }

    /**
     * Get log data from Database
     * @return array
     */
    public function getDataFromDB()
    {
        return $this->dbcon->getLogControlData($_SESSION['selSession'],$_SESSION['selID'],$_SESSION['selTime']);
    }

    /**
     * Other methods call this function to save the log to Database
     */
    public function logToDB(){
        $dataToDump = $this->returnLog();
        $this->dbcon->logToDB($dataToDump);
    }

    /**
     * Get the debugData
     * @param bool $doDumpSuperGlobals
     * @return string
     */
    public function returnLog($doDumpSuperGlobals = true){
        global $logCollection;
        $logView = new \logger\LogView($logCollection);
        return $logView->getDebugData($doDumpSuperGlobals); //changed to return instead of echoing

    }
}