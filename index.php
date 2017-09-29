<?php
    include_once('functions/functions.php');
    $dbConnect = dbLink();
    if ($dbConnect)
        echo '<!-- database connection established -->';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/styleHome.css">
    <title>Welcome</title>
  </head>
  <body>
    <img class="holeL1" src="assets/holeLeft.png" alt="holeL1">
    <img class="holeL2" src="assets/holeLeft.png" alt="holeL2">
    <img class="mole" src="assets/molesm.png" alt="mole">
    <img class="holeMain" src="assets/holeRight.png" alt="holeM">
    <img class="holeR1" src="assets/holeRight.png" alt="holeR1">
    <img class="holeR2" src="assets/holeRight.png" alt="holeR2">
    <h1 class="title">Whack A Mole</h1>
    <div id="navigation">
      <?php nav('index') ?>
    </div>
  </body>
</html>
