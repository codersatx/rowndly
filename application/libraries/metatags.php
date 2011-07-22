<?php
class metatags {
    var $title = '';
    var $description = '';
    var $error_invalid_url = 'Error';   //message to display if the url can't be loaded
    var $error_no_title = 'Untitled';   //display if title is not set
    var $error_no_desc = 'None set';    //display if description is not set
 
    function getmetadata($url){
        //make sure URL is formated correctly
        if (strstr($url, 'http://') == false){
            $url = 'http://'.$url;
        }
        //get file contents
        $d = file_get_contents($url);
        //display error if site can't be loaded
        if ( ! $d) {
            echo $this->error_invalid_url;
            exit();
        }
        //shorten string
        $line = substr($d, 0, 3000);
            //remove linebreaks from the string
            $linebreaks   = array("rn", "n", "r");
            //Processes rn's first so they aren't converted twice.
            $line = str_replace($linebreaks, '', $line);
            // This only works if the title and its tags are on one line
            //if (eregi ("(.*)", $line, $out)) {
                //$this->title = $out[1];
            //}
        //get description
        $desc = get_meta_tags($url);
        $this->description = $desc['description'];   
 
    }
    //get title
    function get_title(){
        if(!$this->title){
            return $this->error_no_title;
        }else{
            return $this->title;
        }
    }
    //get description
    function get_description(){
        if(!$this->description){
            return $this->error_no_desc;
        }else{
            return $this->description;
        }
    }
}