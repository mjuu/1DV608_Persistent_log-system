<?php
/**
 * Created by PhpStorm.
 * User: z3r00z
 * Date: 2016-10-23
 * Time: 19:12
 */
namespace controller;

class MasterController
{

    private $view;
    private $videoModel;
    private $logV;
    private $logCont;
    private $loginCont;
    private $loginView;

    /**
     * MasterController constructor.
     * @param \view\view $view
     * @param \model\videoModel $videoModel
     * @param LogController $logController
     * @param \view\LogContView $logContView
     * @param LoginController $loginController
     */
    public function __construct(\view\view $view, \model\videoModel $videoModel, \controller\LogController $logController, \view\LogContView $logContView, \controller\LoginController $loginController)
    {
        $this->view = $view;
        $this->videoModel = $videoModel;
        $this->logCont = $logController;
        $this->logV = $logContView;
        $this->loginCont = $loginController;
        $this->loginView = new \view\LoginView();

    }

    /**
     * This function makes the app work
     */
    public function doControl()
    {
        //If user want to add a video, add video to database
        if ($this->view->submitClicked()) {
            $this->view->addVideo();
        }
        //If user want to view logs, redirect to login page, if logged in, show log page.
        if ($this->view->viewLogBTNClicked()) {
            if ($this->loginView->loggedIN() == 1) {
                $this->logCont->doLogControll();
            }else {
                $this->loginCont->control();                //do login if not logged in
                if ($this->loginView->loggedIN() == 1) {    //if logged in redirect to log page
                    $this->logCont->doLogControll();
                }
            }
        }elseif($this->logV->getLogout()){                  //Do logout
            $this->logV->doLogout();
        }elseif($this->logV->ipSelectClicked() || $this->logV->sessionSelectClicked() //If user do any action on log page, send back to log page with updated view
            || $this->logV->timeItemClicked() || $this->logV->debugItemClicked()
        ){
            $this->logCont->doLogControll();
        }elseif ($this->view->nextVIDClicked()) {       //Show next video view
            $this->view->next();
        } elseif ($this->view->randomBTNClicked()) {    //Show random video view
            $this->view->random();
        } elseif ($this->view->addVIDBTNClicked()) {
            $this->view->addView();                     //Show add video view
        }elseif ($this->loginView->wantToRegisterURL()){
        $this->loginCont->registerControl();            //If user want to register, send to register view
        }else{
            $this->view->firstView();                   //Else show firstpage view
        }
    }


//        public function showLog(){
//            $this->logCont->show();
//
//        }





}