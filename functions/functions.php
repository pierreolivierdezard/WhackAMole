<?php

//Connect to the DB
function dbLink()
{
	$db_user = "advweb";
	$db_pass = "password";
	$db_host = "localhost";
	$db = "whack_a_mole";
	try{
		$db = new PDO("mysql:host=$db_host;dbname=$db",$db_user,$db_pass);
	} catch (Exception $e){
		echo 'Unable to access database';
		exit;
	}
	error_reporting(0);
	return $db;
}

//deletes a table entry using supplied id and table
function deleteItem($dbConnect,$table,$id)
{
 $sql = "DELETE FROM $table WHERE id =  :id";
 $stmt = $dbConnect->prepare($sql);
 $stmt->bindParam(':id',$id);
 $stmt->execute();
}

//Add Post
function insertPost($dbConnect,$title,$content)
{
	if (($title == "") || ($content == "")) {
		echo "<div class='error'>Your post can't be empty</div>";
	} else {
		$q = "INSERT into posts (id,title,content) VALUES(NULL,:title,:content);";
		$query = $dbConnect->prepare($q);
		$query->bindParam(":title",$title);
		$query->bindParam(":content",$content);
		$result = $query->execute();
		//add user and blog link
		$lid = $dbConnect->lastInsertId();  //collects the blog post id
		$q1 = "INSERT into users_posts (id,user_id,post_id) VALUES(NULL,:uid,:bid);";
		$query = $dbConnect->prepare($q1);
		$query->bindParam(":uid",$_SESSION['userid']);
		$query->bindParam(":bid",$lid);
		$result = $query->execute();
		return $result;
	}
}

//add user to system
function insertUser($dbConnect,$username,$name,$pwd)
 {
	$q = "INSERT into users (id,username,password,name) VALUES(NULL,:uname,:password,:name);";
	$query = $dbConnect->prepare($q);
    $query->bindParam(":uname",$username);
    $query->bindParam(":password",$pwd);
     $query->bindParam(":name",$name);
	$result = $query->execute();
 	return $result;
 }

 //list all posts made by user
 function listPosts($dbConnect)
 {
 echo '<div id="admin-content">';
    $sql = 'SELECT * FROM users_posts ';
     foreach ($dbConnect->query($sql) as $row)
     {
         if($row['user_id'] == $_SESSION['userid'])
         {
             $post_title = returnSingleDetail($dbConnect,$row['post_id'],'id','posts','title');
            echo'<p><a href="editform.php?postid='.$row['post_id'].'">Edit post</a>: '.$post_title.'</p>';
         }
     }
     echo '</div>';
 }

 //list all posts made by user for deletetion
 function listPostsDelete($dbConnect)
 {
 echo '<div id="admin-content">';
    $sql = 'SELECT * FROM users_posts ';
     foreach ($dbConnect->query($sql) as $row)
     {
         if($row['user_id'] == $_SESSION['userid'])
         {
            $post_title = returnSingleDetail($dbConnect,$row['post_id'],'id','posts','title');
            echo'<p><a href="resolvedel.php?postid='.$row['post_id'].'&ubid='.$row['id'].'">Delete post</a>: '.$post_title.'</p>';
         }
     }
     echo '</div>';
 }

function nav($page){
	switch ($page) {
		case 'index':
			echo '
				<a href="index.php">Home</a>
				<a href="pages/game/game.php">Play</a>
				<a href="pages/posts.php">Tell us what you think</a>
			';
			break;
		case 'admin':
			echo '
				<a href="../../index.php">Home</a>
				<a href="../game/game.php">Play</a>
				<a href="profile.php">Your Profile</a>
			';
			break;
			case 'game':
			echo '
				<a href="../../index.php">Home</a>
				<a href="game.php">Play</a>
				<a href="../posts.php">Tell us what you think</a>
			';
			break;
			default:
				echo '
					<a href="../index.php">Home</a>
					<a href="game/game.php">Play</a>
					<a href="posts.php">Tell us what you think</a>
				';
			break;
	}
}

//determines the header for authenticated pages
function profileHeader($validatedAccount)
{
    if($validatedAccount)
        echo 'Your Profile';
    else
        echo 'Login Incorrect';
}

//function to extract a single element from the database based off parameters
function returnSingleDetail($dbConnect,$uid, $uidField, $table, $field)
{
	$sql ="SELECT $field from $table WHERE $uidField = $uid ";
	$smt = $dbConnect->prepare($sql);
	if ($smt->execute())
	{
      while ($rows = $smt->fetch(PDO::FETCH_OBJ))
      {
		$data= $rows->$field;
		return $data;
      }
	}
}

//Show variables that we have
function showMem()
{
    echo '<h3>Get Memory</h3>';
    print_r($_GET);
    echo '<h3>Post Memory</h3>';
    print_r($_POST);
    echo '<h3>Session Memory</h3>';
    print_r($_SESSION);
}

//update a blog title
function updatePostTitle($dbConnect,$postid, $title)
{
    $q = $dbConnect -> prepare("UPDATE posts set title = :titlev WHERE id = :postid");
    $q->bindValue(':titlev',$title);
    $q->bindValue(':postid',$postid);
    $q->execute();
}
//update blog content
function updatePostContent($dbConnect,$postid,$content)
{
    $q = $dbConnect -> prepare("UPDATE posts set content = :content WHERE id = :postid");
    $q->bindValue(':content',$content);
    $q->bindValue(':postid',$postid);
    $q->execute();
}

 //compares the two passwords
 function validate($pwd,$pwd2)
 {
     if ($pwd == $pwd2)
         return true;
     else
         return false;
 }

 //validate user account
  function validateUserAccount($db,$username,$password)
 {
 	$q = "SELECT password, id FROM users WHERE username = :username";
 	$query = $db->prepare($q);
 	$query->bindValue(":username", $username);
 	try{

 		$query->execute();
 		$data 				= $query->fetch();
 		$stored_password 	= $data['password'];
 		$id 				= $data['id'];
 		if($password == $stored_password)
 		{
 			$_SESSION['userid'] = $id;
 			$_SESSION['username'] = $username;
 			$_SESSION['password'] = $password;
 			return $id;
 		} else
 		{
 			return false;
 		}
 	}catch(PDOException $e){
 		die($e->getMessage());
 	}
 }
?>
