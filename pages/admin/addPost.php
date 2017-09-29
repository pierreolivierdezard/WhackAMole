<?php
    session_start();
    include_once('../../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';
    //showMem();
    $username = $_SESSION['username'];
    if($_SESSION['userid'] >0){
        $validatedAccount = true;
    }else{
        $validatedAccount = validateUserAccount($dbConnect,$username,$password);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add A Post</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/stylePosts.css">
    </head>
    <body>
      <div class="container">
        <div class="row">
          <div id="navigation">
            <?php nav('admin'); ?>
          </div>
          <h1 class="title"><?= $username ?></h1>
          <?php
          if ($validatedAccount)
          { //login successful
              echo '
              <div class="addForm">
               <h4>Add A Post</h4>
               <form action="resolveadd.php" method="post">
                  <label>Title:</label>
                  <input type="text" name="title">
                  <label>Your Message:</label><br>
                  <textarea name="content"></textarea>
                  <input class="btn" type="submit" name="submit" value="Add Post">
              </form>
              </div>
              ';
          }
          else
          {  //Failed to log in
              echo '
              <div class="error">An issue has occured with your login, please <a href="../pages/login.php">Try Again</a></div>
              ';
          }
          ?>
        </div>
      </div>
    </body>
</html>
