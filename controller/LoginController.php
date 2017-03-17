<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 2015-11-20
 * Time: 18:47
 */
namespace controller;

use model\LogModel;
use view\LogContView;

class LoginController{

    private $view;
    private $loginView;
    private $loginDal;
    private $logController;

    /**
     * LoginController constructor.
     * @param \view\view $view
     * @param \view\LoginView $lv
     * @param \model\DBConn $ld
     */
    public function __construct( \view\view $view ,\view\LoginView $lv, \model\DBConn $ld)
    {
        $this->view = $view;
        $this->loginView = $lv;
        $this->loginDal= $ld;
        $this->logController = new \controller\LogController($this->view, new LogContView(), new LogModel());
    }

    /**
     * Control login functions
     */
    public function control(){
        //Show login page
       $this->loginView->render();
        if($this->loginView->loggedIN()==1){
            $this->logController->doLogControll();
        }
            //if user want to login, do login
        if($this->loginView->wantToLogin() == true){
            $this->loginView->login();
            if($this->loginView->loggedIN()==1){ //If logged in, refresh the page
                $this->loginView->refresh();
            }
        }
    }

    /**
     * Do register controls
     */
    public function registerControl(){
        //Checks user input
        $this->loginView->doRegister();
        //User want to register
        if($this->loginView->wantToRegister() == true){
            //do register
               if($this->loginView->checkName() == true){
                   $this->loginView->register();
               }
        }
    }
}