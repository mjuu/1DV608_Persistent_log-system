<?php
/**
 * Created by PhpStorm.
 * User: Benji
 * Date: 2016-09-02
 * Time: 13:51
 */
namespace view;

class view{

    private static $nextVid = 'view::NextVid';
    private static $addVid = 'view::AddVid';
    private static $RandomVid = 'view:Random';
    public $videoModel;
    private static $ytURL = 'view::ytURL';
    private static $submit = "view::add";
    private static $logViewBTN = 'view::logC';

    /**
     * view constructor.
     * @param \model\videoModel $videoModel
     */
    public function __construct( \model\videoModel $videoModel){
        $this->videoModel = $videoModel;
        $this->videoModel->setArray();
    }

    /**
     * Fix to access LogModel
     * @return \model\LogModel
     */
    public function logModel(){
        return new \model\LogModel();
    }

    /**
     * Show 'random' view
     */
    public function random(){
        $this->videoView($this->videoModel->randomVid());
    }

    /**
     * Show 'next' view
     */
    public function next(){
        $this->videoView($this->videoModel->nextVid());
    }

    /**
     * Show 'add video' view
     */
    public function addVideo(){
        $this->videoModel->extractVideoID($this->getYTURL());
    }

    /**
     * This is the first view that is shown to the user
     */
    public function firstView(){
        loggHeader('First page view from user');        //log

        echo '

<!doctype html>
<html>
	<head>
	    <title>Mjuu.se</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="red">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>
	<body>
	<div id="wrapper"> 
	
	<div id="video">
		<iframe src="https://www.youtube.com/embed/6cOgFWCaeEI?t=6&autoplay=0&controls=0&autohide=1&wmode=transparent&hd=1"></iframe>
	</div>
	<aside class="aside header"><h1>Mjuu!</h1><ol><li>'.$this->viewLogBTN().'</li></ol></aside>
	<aside class="aside aside-1">      

		<ol>
			 <li>' .$this->addVIDBTN().'</li>
			 <li>'.$this->randomBTN().'</li>
			 <li>'.$this->nextVIDBTN().'</li>
		</ol>
    </aside>
	</div>
	</body>
</html>

';
        loggThis('Page loaded without error');  //log
        $this->logModel()->logToDB();
    }

    /**
     * This view loads the different 'next','random','add' videos.
     * $opt is a html iframe
     * @param $opt
     */
    public function videoView($opt){
        echo '

<!doctype html>
<html>
	<head>
	    <title>Mjuu.se</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="red">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>
	<body>
	<div id="wrapper"> 

	'.$opt.'
	<aside class="aside header"><h1>Mjuu!</h1><ol><li>'.$this->viewLogBTN().'</li></ol></aside>
	<aside class="aside aside-1">      

		<ol>
			 <li>' .$this->addVIDBTN().'</li>
			 <li>'.$this->randomBTN().'</li>
			 <li>'.$this->nextVIDBTN().'</li>
		</ol>
    </aside>
	</div>
	</body>
</html>
  
';
    }

    /**
     * Shows the view where user can add a youtube video to the database
     */
    public function addView(){
            loggThis("User accessed 'add video view'");
        echo '

<!doctype html>
<html>
	<head>
	    <title>Mjuu.se</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="red">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>
	<body>
	<div id="wrapper1"> 
	
	<div id="video">
		<iframe src="https://www.youtube.com/embed/ZImKoemfbiE?t=6&autoplay=0&controls=0&autohide=1&wmode=transparent&hd=1"></iframe>
	</div>
	<aside class="aside header"><h1>Mjuu!</h1></aside>
	<aside class="aside addVideo"><ol><li>'.$this->viewLogBTN().'</li></ol><h1>Add a youtube video</h1> <br>
	<p>Enter youtube link in the box and click Add</p><br>
	
	<form action="" method="post" enctype="multipart/form-data">
	<label for="'.self::$ytURL.'">Youtube URL</label><br>
    <input type="text" size="20" name="'.self::$ytURL.'" id="'.self::$ytURL.'" value="">
    <br>
    <input id="submit" type="submit" name="'.self::$submit.'" value="Add">
    </form>
	
	</aside>
	<aside class="aside aside-1">      
    
		<ol>
			 <li>' .$this->addVIDBTN().'</li>
			 <li>'.$this->randomBTN().'</li>
			 <li>'.$this->nextVIDBTN().'</li>
		</ol>
    </aside>
	</div>
	</body>
</html>

';
    }

    /**
     * Get the Youtube url that user posted
     * @return string
     */
    public function getYTURL(){
        if(isset($_POST[self::$ytURL]))
            return trim($_POST[self::$ytURL]);
    }

    /**
     * Show random button
     * @return string
     */
    public function randomBTN(){
        return "<a href='?".self::$RandomVid."'> [RANDOM]</a>";
    }
    /**
     * Show next button
     * @return string
     */
    public function nextVIDBTN(){
        return "<a href='?" .self::$nextVid."'> [NEXT]</a>";
    }
    /**
     * Show add button
     * @return string
     */
    public function addVIDBTN(){
        return "<a href='?".self::$addVid."'> [ADD VIDEO]</a>";
    }
    /**
     * Show view log button
     * @return string
     */
    public function viewLogBTN(){
        return "<a href='?".self::$logViewBTN."'> [Show logs]</a>";
    }

    /**
     * Checks if button is clicked
     * @return bool
     */
    public function viewLogBTNClicked(){
        if((isset($_GET[self::$logViewBTN]))==true){
            loggThis("User want to see logs");
            return true;
        }
    }
    /**
     * Checks if button is clicked
     * @return bool
     */
    public function nextVIDClicked(){

        if((isset($_GET[self::$nextVid]))===true){
            loggThis('Next btn clicked', null, true);
            $this->logModel()->logToDB();
            return true;
        }
    }
    /**
     * Checks if button is clicked
     * @return bool
     */
    public function randomBTNClicked(){

        if((isset($_GET[self::$RandomVid]))===true){
            loggThis('Random btn clicked', null, true);
            $this->logModel()->logToDB();
            return true;
        }
    }
    /**
     * Checks if button is clicked
     * @return bool
     */
    public function addVIDBTNClicked(){

        if((isset($_GET[self::$addVid]))===true){
            loggThis('add btn clicked', null, true);                     //log
            $this->logModel()->logToDB();
            return true;
        }
    }
    /**
     * Checks if button is clicked
     * @return bool
     */
    public function submitClicked(){
        if(isset($_POST[self::$submit])==true){
            loggThis('Uppload btn clicked', null, true);                //log
            loggThis("include an object", new \Exception("gg"), false); //logg

            $this->logModel()->logToDB();
            return true;
        }
    }

}