<?php
  include_once('../functions/functions.php');
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>What Do You Think ?</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stylePosts.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
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
        xmlhttp.open("GET","getPosts.php",true);
        xmlhttp.send();
      }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div id="navigation">
          <?php nav('posts') ?>
        </div>
        <h1 class="title">What do you think about the game ?</h1>
            <form action="resolveregister.php" class="col-sm-5 offset-sm-2 registerForm" method="post">
              <h4>Create an account</h4>
              <div class="register">
                <label>Username:</label><br>
                <input type="text" name="username"><br><br>
                <label>Name:</label><br>
                <input type="text" name="name"><br><br>
                <label>Password:</label><br>
                <input type="password" name="pwd"><br><br>
                <label>Confirm Password:</label><br>
                <input type="password" name="pwd2"><br><br>
              </div>
              <input class="btn" type="submit" name="submit" value="Register Account">
            </form>

            <form action="./admin/profile.php" class="col-sm-5 loginForm" method="post">
              <h4>Log In</h4>
              <div class="log">
                <label>Username:</label><br>
                <input type="text" name="username"><br>
                <label>Password:</label><br>
                <input type="password" name="pwd"><br><br>
              </div>
              <input class="btn" type="submit" name="submit" value="Login">
            </form>
          <p class="showPosts col-xs-12" onclick="showPosts();">SEE POSTS</p>
          <div class="col-xs-12" id="posts"></div>
      </div>
    </div>
  </body>
</html>
