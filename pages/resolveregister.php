<?php
    session_start();
    include_once('../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';

   // showMem();
    //Collect information
    $username = $_POST['username'];
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];
    //Add details to database if passwords match there is a unique username and username and pasword are not empty
   if(($username == NULL) || ($pwd == NULL))
    {
        $message = '<div class="error">Empty username or password. Please <a href="posts.php">Try again!</a></div>';
    }
    else
    {
        $validate = validate($pwd,$pwd2);
        if($validate)
        {
            $addaccount = insertUser($dbConnect,$username, $name ,$pwd);
            if($addaccount)
                $message = '<div class="error">Account has been successfully created. Click <a href="posts.php">Home</a> and login.</div>';
            else
                $message = '<div class="error">An error occured, username already in use. Please <a href="posts.php">Try again!</a></div>';
        }else
        {
            $message = '<div class="error">Passwords did not match, please <a href="posts.php">Try again!</a></div>';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register Resolver</title>
        <link rel="stylesheet" href="../css/stylePosts.css">
    </head>
    <body>
      <div class="container">
        <div class="row">
          <div id="navigation">
            <?php nav('posts'); ?>
          </div>
          <h1 class="title">Register Account</h1>
          <div id="register-form">
              <?php
                  echo $message;
              ?>
          </div>
        </div>
      </div>
    </body>
</html>
