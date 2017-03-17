<?php
/**
 * Created by PhpStorm.
 * User: Benji
 * Date: 2016-09-05
 * Time: 19:50
 */

namespace model;
class videoModel{

    private $next;
    private $random;
    public $videoArray;
    private $videoSize;
    private $dbconn;
    public $matches;
    public $firstRun=1;

    /**
     * videoModel constructor.
     */
    public function __construct(){
        $this->dbconn = new \model\DBConn();

        if($this->firstRun !=1){    //Run this first time, to set some video to Database
             $this->videoDBSet();
            $this->firstRun = 1;

        }
        $this->setArray();         //Get videos and set the array
    }

    /**
     * Returns random video
     * @return string
     */
    public function randomVid(){

        return '

        <div id="video">
				<iframe frameborder="0"  width="100%" height="100%" src="https://www.youtube.com/embed/' .$this->random().'?t=6&autoplay=1&controls=0&loop=1&rel=0&showinfo=0&autohide=1&wmode=transparent&hd=1"></iframe>
	    </div>';
    }

    /**
     * Returns the next video in queue
     * @return string
     */
    public function nextVid(){
        return '

        <div id="video">
				<iframe frameborder="0"  width="100%" height="100%" src="https://www.youtube.com/embed/' .$this->getNext().'?t=6&autoplay=1&controls=0&loop=1&rel=0&showinfo=0&autohide=1&wmode=transparent&hd=1"></iframe>
	    </div>';
    }

    /**
     * Returns a random videoID
     * @return mixed
     */
    public function random(){
       // var_dump($this->videoArray);
        $this->random =rand(0,$this->videoSize);
        $_SESSION['videoNR'] =$this->random;
        return $test = $this->videoArray[$this->random];
    }

    /**
     * Returns the next videoID in queue
     * @return mixed
     */
    public function getNext(){
        $current= $_SESSION['videoNR'];
        $this->next = $current+1;

        if($this->next > $this->videoSize){
            $_SESSION['videoNR'] =0;
            return $this->videoArray[0];
        }else{
            $_SESSION['videoNR'] =$this->next;
            return $this->videoArray[$this->next];
        }
    }

    /**
     * Add video to the array
     * @param $videoID
     */
    public function addVideo($videoID){
        array_push($this->videoArray,$videoID);
        $GLOBALS['vidArr'] = $this->videoArray;
    }

    /**
     * Sets default videos to the Database
     */
    public function videoDBSet(){
        $this->videoArray = array("BWDqy0zZAsY","HiRl1VcUv1Q","UprcpdwuwCg");
        $this->addToDB();
    }

    /**
     * Fetch videoIDs from database and save to the videoArray
     */
    public function setArray(){
        $this->videoArray = $this->dbconn->getVideos();
        //Give the right max value
        $this->videoSize =count($this->videoArray) -1;
    }

    /**
     * Add video to the Database
     */
    public function addToDB(){
        $this->dbconn->addVideo($this->videoArray);
    }

    /**
     * Returns the videoArray
     * @return mixed
     */
    public function getArray(){
        return $this->videoArray;
    }

    /**
     * Regex to extract youtube videoID
     * Adding the videoID to the database
     * @param $vidURL
     */
    public function extractVideoID($vidURL){
        if($this->videoArray == null){
            $this->videoArray =[];
        }
        $url = $vidURL;
        preg_match_all("#(?<=v=|v\/|vi=|vi\/|youtu.be\/)[a-zA-Z0-9_-]{11}#", $url, $this->matches);

        $temp = array_merge($this->matches[0],$this->videoArray);
        $this->videoArray = $temp;
        //var_dump($this->videoArray);
        $this->addToDB();

    }


}