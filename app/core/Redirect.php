<?php 

class Redirect{


    public function to($location){
       
        header("Location: " .baseurl(). "/" . $location);
        
    }
    

    public function back(){
        header("Location" . $_SERVER['HTTP_REFERER']);
    }

}