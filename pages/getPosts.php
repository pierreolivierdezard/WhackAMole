<?php
	include_once('../functions/functions.php');
	$dbConnect = dbLink();
	if ($dbConnect !== NULL)
		echo '<!-- db Connection established -->';
    $sql = "SELECT * FROM posts ORDER BY id DESC";
    foreach ($dbConnect->query($sql) as $row) {
		echo '<div class="post">';
		$id = $row['id'];
		echo '<label>'.$row['title'].'</label>';
    echo '<div class="postMessage">'.$row['content'].'</div>';
    echo '</div>';
    }
?>
