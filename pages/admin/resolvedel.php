<?php
    session_start();
    include_once('../../functions/functions.php');
    $dbConnect = dbLink();
    if($dbConnect)
        echo '<!-- database connection established -->';
    //showMem();
    if($_SESSION['userid'] >0)
        $validatedAccount = true;
    else
        $validatedAccount = validateUserAccount($dbConnect,$username,$password);

    $postid = $_GET['postid'];
    $ubid = $_GET['ubid'];
    deleteItem($dbConnect,'posts',$postid);
    deleteItem($dbConnect,'users_posts',$ubid);

?>
<!DOCTYPE html>
<html>
    <head>
      <title>Resolve Delete</title>
      <link rel="stylesheet" href="../../css/stylePosts.css">
      <script type="text/javascript">
          function bounce()
          {
              window.location.href="profile.php";
          }
      </script>
    </head>
    <body onload="bounce();">
    </body>
</html>
