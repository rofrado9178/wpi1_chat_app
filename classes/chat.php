<?php 

class Chat {
  function __construct()
  {
    session_start();

    if(isset($_SESSION["logged_in"]) && isset($_POST)){
      $this->StoreMessage($_POST["message"]);
    }
  }

  public function StoreMessage($message){

    $clearMessage = trim(strip_tags($message));

    //storing to db
    
    // echo $clearMessage;
    require_once "../_includes/db.php";

  }

  public function LoadMessage(){

  }

  public function RefreshMessage(){

  }
}










?>