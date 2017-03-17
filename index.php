<?php
/**
 * Created by PhpStorm.
 * User: Benji
 * Date: 2016-09-02
 * Time: 13:41
 */

require_once("view/view.php");
require_once ("view/LogContView.php");
require_once ("controller/MasterController.php");
require_once ("controller/LogController.php");
require_once ('controller/LoginController.php');
require_once ('model/LogModel.php');
require_once ("model/videoModel.php");
require_once("model/DBConn.php");
require_once("conf/conf_logger.php"); //Setting for local testing
require_once ("model/LogCollection.php");
require_once("view/LoginView.php");
//require_once("/var/conf/conf_logger.php"); //Setting for online testing

session_start();
$lv = new \view\LoginView();
$videoModel = new model\videoModel();
$view = new view\view($videoModel);
$db = new model\DBConn();
$logCollection = new logger\LogCollection();
$logContView = new \view\LogContView();

$loginController = new controller\LoginController($view,$lv,$db);
$logModel = new model\LogModel();

$logCont = new controller\LogController($view,$logContView, $logModel);
$masterController = new controller\MasterController($view, $videoModel, $logCont, $logContView, $loginController);

$masterController->doControl();

