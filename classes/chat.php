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

    $chatMessage = trim(strip_tags($message));

    //storing to db
    
    // echo $clearMessage;
    require_once "../_includes/db.php";

    if($db){
      echo "Connect to DB";
      $query = "INSERT INTO message (`message`, `uid`, `username`) VALUES(?,?,?)";
      $insertedRows = 0;
      $uid = $_SESSION["id"];
      $username = $_SESSION["username"];

      if($statement = $db->prepare($query)){  

        $statement->bind_param("sis", $chatMessage, $uid, $username);
        $statement->execute();
        $insertedRows += $statement->affected_rows;

        if($insertedRows > 0){
          $results[] = [
            "id" => $statement->insert_id
          ];
        }
        else {
          $results[] = [
            "Error" => "Nothing Inserted"
          ];
        }

        $statement->close();

      }else {
        $results[] = [
          "Error" => "Query Error"
        ];
      }

      $db->close();

    }
    else {
      $results[] = [
        "Error" => "Connection Error" . mysqli_connect_error()
      ];
    }

    echo json_encode($results);
  }

  public function LoadMessage(){

  }

  public function RefreshMessage(){

  }
}










?>