<?php
//// Displaying errors
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    //load up the DB connection
    require_once "_includes/db.php";

//// Setting up users
    // $user1 = "peter";
    // $passw1 = "pizza123";
    // $user2 = "mary";
    // $passw2 = "pasta123";

   // INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, 'baba123', '$2y$10$RCrjMrpjADJCyqR0M0p3UugmpKdRxx6RFIVATV2YJRuCyrFfWd8nO');

//// POST check & content check via if conditional...
    if(isset($_POST["username"]) && !empty($_POST["username"]) && $_POST["username"] != " ") {
        
        /// Assigning values to variables as well as "sanitizing" the inputs
        $username = trim(strip_tags($_POST["username"]));
        $password = trim(strip_tags($_POST["password"]));

        $user = $db->real_escape_string($username);
        $pass = $db->real_escape_string($password);
        
        //set db query
        $query = "SELECT * FROM users WHERE username = '$user'";
        $data = mysqli_query($db , $query);

        if(mysqli_num_rows($data) == 0){
            echo("<p>User Not Found </p>");
            exit();
        }

        $userData = mysqli_fetch_assoc($data); 

        // echo("<pre>");
        // var_dump($userData);
        // echo("</pre>");
     
            
        
        //echo "Form data is OK";
        if(password_verify($pass, $userData["password"])) {

            session_start();
            $_SESSION["username"] = $username;
            //Boolean switch type variable
            $_SESSION["logged_in"] = true;

            print "Hi there, ".$_SESSION["username"];
        }
    }

    // if(isset($_GET["logout"])) {
    //     session_start();
    //     session_destroy();
    //     echo 'You have been logged out. <a href="login.php">Go back</a>';
    // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Simple Login</title>
</head>
<body>


    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) : ?>
    
        <h1>Welcome <?php print $_SESSION["username"]; ?></h1>

        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officiis omnis ipsam eveniet quasi iure quidem incidunt deleniti aliquam, facilis iste, deserunt odio quod fuga ullam natus tenetur dolor magni facere.</p>

        <a href="logout.php">Log me out</a>
    
    <?php elseif($_SERVER['REQUEST_METHOD'] == "POST") : ?>

        <h2>oops, that didn't work... </h2>
        <a href="index.php">Try again.</a>
        
    <?php else : ?>

        <h1>Please log in first</h1>
        <form action="index.php" method="post">
            <input type="text" name="username" placeholder="User name please" pattern=".{3,}" required>
            <input type="password" name="password" placeholder="Password please" pattern=".{3,}" required>
            <input type="submit" value="Log me in!">
        </form>
    
    <?php endif; ?>

    

</body>
</html>