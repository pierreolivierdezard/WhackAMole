<?php
    session_start();
    include_once('../../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';
    // showMem();
    $username = $_SESSION['username'];
    if($_SESSION['userid'] >0)
        $validatedAccount = true;
    else
        $validatedAccount = validateUserAccount($dbConnect,$username,$password);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Resolve Edit</title>
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
              $postid = $_GET['pid'];
              $title = $_POST['title'];
              $content = $_POST['content'];
              updatePostTitle($dbConnect,$postid, $title);
              updatePostContent($dbConnect,$postid, $content);
              echo '<div id="admin-content">';
              echo '<div class="error">Update successful. Click <a href="profile.php">Here</a> to return to your profile.</div>';
              echo '</div>';
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
