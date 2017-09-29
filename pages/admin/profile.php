<?php
    session_start();
    include_once('../../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';
    //showMem();
    if($_POST['username'] == NULL)
    {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }
    else
    {
        $username = $_POST['username'];
        $password = $_POST['pwd'];
        $validatedAccount = validateUserAccount($dbConnect,$username,$password);
    }
    $validatedAccount = validateUserAccount($dbConnect,$username,$password);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="../../css/stylePosts.css">

        <script>
          function showPosts(){
            var xmlhttp;
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("posts").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","../getPosts.php",true);
            xmlhttp.send();
          }
        </script>
    </head>
    <body>
      <div id="navigation">
        <?php nav('admin') ?>
      </div>
      <h1 class="title"><?= $username ?></h1>
      <?php
      if ($validatedAccount)
      { //login successful
          echo '<div id="adminActions">';
          echo '
          <a class="col-sm-4 userAction" href="addpost.php">Add a new Post</a><br>
          <a class="col-sm-4 userAction" href="editpost.php">Edit an existing post</a><br>
          <a class="col-sm-4 userAction" href="deletepost.php">Remove an existing post</a><br>
          ';
          echo '</div>';
          echo '<p class="showPosts" onclick="showPosts();">POSTS</p>';
          echo '<div id="posts"></div>';
      }
      else
      {  //Failed to log in
          echo '
          <div class="error">  An issue has occured with your login, please <a href="../posts.php">Try Again</a></div>
          ';
      }
      ?>
    </body>
</html>
