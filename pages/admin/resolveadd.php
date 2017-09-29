<?php
    session_start();
    include_once('../../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';
    //showMem();
    $username = $_SESSION['username'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    if($_SESSION['userid'] >0)
        $validatedAccount = true;
    else
        $validatedAccount = validateUserAccount($dbConnect,$username,$password);
?>
<!DOCTYPE html>
<html>
    <head>
      <title>Resolve Add Post</title>
      <link rel="stylesheet" href="../../css/stylePosts.css">
    </head>
    <body>
      <div id="navigation">
        <?php nav('admin'); ?>
      </div>
      <h1 class="title"><?= $username ?></h1>
      <?php
      if ($validatedAccount)
      { //login successful
          echo '<div id="admin-content">';
          $insertResult = insertPost($dbConnect,$title,$content);
          if($insertResult)
              echo '<div class="error">Post has been successfully added. View post by clicking on your <a href="profile.php">Profile</a> or return to <a href="addpost.php">Add Post</a> to add another post.</div>';
          else
              echo ' <a class="error" href="addPost.php">Try Again</a>';
          echo '</div>';
      }
      else
      {  //Failed to log in
          echo '
          <div class="error">An issue has occured with your login, please <a href="../pages/login.php">Try Again</a></div>
          ';
      }
      ?>
    </body>
</html>
