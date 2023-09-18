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
            $_SESSION["id"] = $userData["id"];
            //Boolean switch type variable
            $_SESSION["logged_in"] = true;

            // print "Hi there, ".$_SESSION["username"];
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
    <title>Simple Chat Apps</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>


    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) : ?>
        <header>
            <div class="container">
                <div class="flex-header">
                    <div class="name">
                        <h1>WPI1 CHAT</h1>
                        <img src="assets/smile.png" alt="" class="smile">
                    </div>
                    <a href="logout.php" class="logout">Log out</a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="flex-user">
                    <div class="username">
                        <img src="assets/emoji-avatar1.svg" alt="">
                        <h1><?php print $_SESSION["username"]; ?></h1>
                    </div>
                    <div class="phone-icon">
                        <img src="assets/🦆 icon _video call_.svg" alt="">
                        <img src="assets/🦆 icon _phone_.svg" alt="">
                    </div>
                </div>
                <article class="chatbox">
                    <p id="messages">L O A D I N G</p>
                </article>
            </div>
        </section>
        <section class="message-form">
            <div class="container">
                <form id="msg-box">
                    <input type="text"  placeholder="Type your message" name="message" class="type-msg">
                    <input type="submit" value=" " class="send-btn">
                </form>
            </div>
        </section>
    
    <?php elseif($_SERVER['REQUEST_METHOD'] == "POST") : ?>
    <section>
        <div class="container">
            <h2>oops, that didn't work... </h2>
            <a href="index.php">Try again.</a>
        </div>
    </section>
        
    <?php else : ?>

    <section  class="login">
        <div class="container">
            <article class="login-form">
                <h1>Please log in first</h1>
                <form action="index.php" method="post" class="credential" >
                    <input type="text" name="username" placeholder="User name please" pattern=".{3,}" required>
                    <input type="password" name="password" placeholder="Password please" pattern=".{3,}" required>
                    <input type="submit" value="Log me in!" class="login-btn">
                </form> 
                <p>username jacob - jacob123</p>
                <p>username hello - hello123</p>
            </article>
        </div>
    </section>
    <?php endif; ?>

<script>window.myUserId = <?php echo($_SESSION["id"]);?> </script>
<script src="JS/main.js" defer></script>
</body>
</html>