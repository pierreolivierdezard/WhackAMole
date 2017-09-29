<?php
  include_once('../../functions/functions.php');
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/gameStyle.css">
    <title>Whack a mole</title>
  </head>
  <body>
    <div class="container">
      <div id="navigation">
        <?php nav('game') ?>
      </div>
      <audio src="assets/music/arcadeFunk.mp3" autoplay="true" loop></audio>
      <audio id="outch" src="assets/music/outch.wav"></audio>
      <canvas id="myPlayground" width="1093" height="632" onclick="handleClick(event)"></canvas>
      <p onclick="start()">Click to Start</p>
      <p onclick="playAgain()">Play Again</p>
    </div>
  </body>
</html>

<script>
  //Draw Playground
  var canvasObject = document.getElementById("myPlayground");
  var ctx = canvasObject.getContext('2d');
  var gameWidth = canvasObject.width;
  var gameHeight = canvasObject.height;

  //Background with holes to hide moles
  var bgImage = new Image();
  bgImage.src = 'assets/playground.png';
  //Full Background
  var bgStart = new Image();
  bgStart.src ="assets/playgroundFull.png";
  bgImage.addEventListener('load',init,false);

  //Define variables for the game
  var fps = 120;
  var tick = 0;
  var pop = 0;
  var score = 0;

  //Define holes
  var holes = [
    {'img' : new Image(), 'holeNumber' : "hole1", 'x' : 62, 'y' : 483},
    {'img' : new Image(),'holeNumber' : "hole2", 'x' : 638, 'y' : 546},
    {'img' : new Image(),'holeNumber' : "hole3", 'x' : 183, 'y' : 325},
    {'img' : new Image(),'holeNumber' : "hole4", 'x' : 432, 'y' : 409},
    {'img' : new Image(),'holeNumber' : "hole5", 'x' : 898, 'y' : 354},
    {'img' : new Image(),'holeNumber' : "hole6", 'x' : 399, 'y' : 266},
    {'img' : new Image(),'holeNumber' : "hole7", 'x' : 692, 'y' : 290},
  ];

  //Define moles
  var moles = [
    {'img' : new Image(),'size' : 0.29,  'x' : 90, 'y' : 480, 'posY' : 480, 'up' : 180},
    {'img' : new Image(),'size' : 0.33, 'x' : 669, 'y' : 546, 'posY' : 546, 'up' : 250},
    {'img' : new Image(),'size' : 0.29, 'x' : 180, 'y' : 325, 'posY' : 325, 'up' : 170},
    {'img' : new Image(),'size' : 0.27, 'x' : 432, 'y' : 414, 'posY' : 414, 'up' : 140},
    {'img' : new Image(),'size' : 0.33, 'x' : 898, 'y' : 354, 'posY' : 354, 'up' : 190},
    {'img' : new Image(),'size' : 0.20, 'x' : 399, 'y' : 266, 'posY' : 266, 'up' : 130},
    {'img' : new Image(),'size' : 0.22, 'x' : 692, 'y' : 290, 'posY' : 290, 'up' : 130},
  ];

  var mole = randomSelectMole();

  window.requestAnimFrame = (function (){
    return window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.msRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      function( callback ){
        window.setTimeout(callback,1000/fps);
      };
  })();

  function drawBackground(){
    ctx.drawImage(bgImage,0,0);
  }

  function drawBackgroundStart(){
    ctx.drawImage(bgStart,0,0);
  }

  //To hide to moles, we will hide them under holes. We will draw the background first, then the moles ans then the holes
  function drawHoles(){
    for (i = 0; i < holes.length; i++) {
      holes[i]['img'].src = 'assets/'+holes[i]['holeNumber']+'.png';
      var posHoleX = holes[i]['x'];
      var posHoleY = holes[i]['y'];
      ctx.drawImage(holes[i]['img'],posHoleX,posHoleY,holes[i]['img'].width, holes[i]['img'].height);
    }
  }

  function drawMole(mole){
    mole['img'].src = 'assets/molesm.png';
    ctx.drawImage(mole['img'],mole['x'],mole['y'],mole['img'].width*mole['size'], mole['img'].height*mole['size']);
  }

  //Select a random mole in the moles array
  function randomSelectMole(){
    var max = Math.floor(moles.length);
    var moleId = Math.floor(Math.random() * max);
    var mole = moles[moleId];
    return mole;
  }

  function riseMole(mole){
    drawMole(mole);
    mole['y'] = mole['y']-1;
  }

  function dropMole(mole){
    drawMole(mole);
    mole['y'] = mole['y']+1;
  }

  function loopUp(mole){
    setTimeout(function () {
      requestAnimFrame(start);
      clearScreen();
      drawBackground();
      riseMole(mole);
      drawHoles();
      updateScore();
    }, 1000/fps);
  }

  function loopDrop(mole){
    setTimeout(function () {
      requestAnimFrame(start);
      clearScreen();
      drawBackground();
      dropMole(mole);
      drawHoles();
      updateScore();
    }, 1000/fps);
  }

  function init() {
    drawBackgroundStart();
    drawText("15 moles will pop, try to catch them all !",250 ,623,"black");
    updateScore();
  }

  function start(){
    tick++;
    //We raise our mole during 75 ticks and drop her during 75 ticks, so a "pop" is each 150 ticks
    var floor = Math.floor(tick/75)%2;
    //During a game, 15 moles pop
    if(pop < 15){
      //After each pop we put our mole at the initial position and we select another one
      if (Number.isInteger(tick/150)) {
        pop = pop+1;
        mole['y'] = mole['posY'];
        mole = randomSelectMole();
      }
      if (floor == 0) {
        loopUp(mole);
      }
      if (floor == 1) {
        loopDrop(mole);
      }
    }else {
      drawText("END OF THE GAME",420 ,360,"black");
      //Score 15 is the best score
      if (score == 15) {
        drawText("Congrats, You caught all the moles, you are quick !",150 ,465,"black");
      }
    }
  }

  function updateScore(){
    ctx.font = "30px Fantasy";
    ctx.fillStyle = "black";
    ctx.fillText("Score: "+score+"/15",910,60);
  }

  function increaseScore(x,y){
    //for each mole we define a clickable zone
    for (var i = 0; i < moles.length; i++) {
      var startX_startWidth = moles[i]['x'];
      var startX_maxWidth = moles[i]['x'] + moles[i]['img'].width*moles[i]['size'];
      var startY_startHeight = moles[i]['y'];
      var startY_maxHeight = moles[i]['y'] + moles[i]['img'].height*moles[i]['size'];

      //if our click is inside the clickable zone
      if ((x>=startX_startWidth) && (x<=startX_maxWidth)) {
        if ((y>=startY_startHeight) && (y<=startY_maxHeight)) {
          //We place our mole at her initial position, select a random one and increase the score
          document.getElementById("outch").play();
          mole['y'] = mole['posY'];
          mole = randomSelectMole();
          score++;
          //Then we have to increase the tick to go to the next "pop", so we calculate the difference between the next multiple of 150 and the tick
          var rest = tick%150;
          var add = 150 - rest;
          tick = tick + add;

          //When the player reach the score of 4, we speed up the game.
          if (score == 4) {
            var floor = Math.floor(tick/75)%2;
            if (floor == 0) {
              loopUp(mole);
            }
            if (floor == 1) {
              loopDrop(mole);
            }
          }

          //When the player reach the score of 10, we speed up the game again.
          if (score == 10) {
            var floor = Math.floor(tick/75)%2;
            if (floor == 0) {
              loopUp(mole);
            }
            if (floor == 1) {
              loopDrop(mole);
            }
          }
          pop = pop+1;
        }
      }
    }
  }

  function playAgain(){
    score = 0;
    pop = 0;
    start();
  }

  function clearScreen() {
    ctx.clearRect(0,0,gameWidth,gameHeight);
  }

  function drawText(text,x,y,fontColour) {
    var ctx = document.getElementById("myPlayground").getContext('2d');
    ctx.fillStyle = fontColour;
    ctx.font = "40px Fantasy";
    ctx.fillText(text,x,y);
  }

  function handleClick(event){
    var windowClickX = event.clientX;
    var windowClickY = event.clientY;
    //console.log('x: ',windowClickX,' y: ',windowClickY);
    var playground = document.getElementById("myPlayground");
    var winOffSetX = playground.offsetLeft - playground.scrollLeft;
    var winOffSetY = playground.offsetTop - playground.scrollTop;
    var clickX = windowClickX - winOffSetX;
    var clickY = windowClickY - winOffSetY;
    increaseScore(clickX,clickY);
    //  console.log('Adjusted x: ',clickX,' y: ',clickY);
  }
</script>
