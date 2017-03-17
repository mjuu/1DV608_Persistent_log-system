<?php
/**
 * Created by PhpStorm.
 * User: z3r00z
 * Date: 2017-03-01
 * Time: 13:25
 */

namespace controller;

class LogController
{
    private $view;
    private $logView;
    private $logModel;

    /**
     * LogController constructor.
     * @param \view\view $view
     * @param \view\LogContView $logContView
     * @param \model\LogModel $logModel
     */
    public function __construct(\view\view $view, \view\LogContView $logContView, \model\LogModel $logModel)
    {
        $this->view = $view;
        $this->logView = $logContView;
        $this->logModel = $logModel;

    }

    /**
     * Checks if any links is clicked in the log page
     */
    public function doLogControll()
    {

        if ($this->logView->ipSelectClicked()) {
            $this->logModel->renderView();
        } elseif ($this->logView->sessionSelectClicked()) {
            $this->logModel->renderView();
        } elseif ($this->logView->timeItemClicked()) {
            $this->logModel->renderView();
        } elseif ($this->logView->debugItemClicked()) {
            $this->logModel->renderView();
        } else {
            $this->logModel->renderView();
        }
    }

    public function show(){
        $this->logModel->renderView();

    }

}