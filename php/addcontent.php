<?php
	session_start();
	if(!$_SESSION['auth']){
		header('Location: /pb/index.php');
	}
	// 
	// 
	include "videoexists.php";
	// 
	// 
	include "connect.php";
	
	// Add category logic.
	if (!empty($_POST['addcategory']) && !empty($_POST['name']) && !empty($_POST['select_group'])) {
		$name = $_POST['name'];
		$select_group = $_POST['select_group'];
		
		mysqli_query($con, "INSERT INTO categories (id_group, name) VALUES ('$select_group', '$name')");
		header('Location: /pb/addcategory.php');
	}
	else {
		echo 'Cimpurile sunt goale!';
	}

	// Add group logic.
	if (!empty($_POST['addgroup']) && !empty($_POST['name']) && !empty($_POST['language']) && !empty($_FILES['image'])) {
		if ($_FILES['image']['error']) {
			echo 'Sunt erori in adaugarea imaginii!';
			return;
		}
		$name = $_POST['name'];
		$language = $_POST['language'];
		$filename = $_FILES['image']['tmp_name'];
		$plain = fread(fopen($filename, "r"), filesize($filename));
		$base64_encoded = 'data:image/' . $_FILES['image']['type'] . ';base64,' . base64_encode($plain);
		
		mysqli_query($con, "INSERT INTO groups (name, thumbnail, language) VALUES ('$name', '$base64_encoded', '$language')");
		header('Location: /pb/addgroup.php');
	}
	else {
		echo 'Cimpurile sunt goale!';
	}

	// Add post logic.
	if (!empty($_POST['addpost']) &&!empty($_POST['group']) && !empty($_POST['category']) && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['searchteg'])) {
		$group = $_POST['group'];
		$category = $_POST['category'];
		$important = !empty($_POST['important']) ? 1 : 0;
		
		// get res from image field
		$image_name = '../post_images/' . $_FILES['image']['name'];
		if (file_exists($image_name)) {
			unlink($image_name);
		}
		if(!empty($_FILES['image']['name'])){
			// print $image_name;
			move_uploaded_file($_FILES['image']['tmp_name'], $image_name);
			$image_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/pb/post_images/' . $_FILES['image']['name'];
		}else{
			$image_url = "";
		}
		// END get res from image field
		
		$title = $_POST['title'];
		$subtitle = $_POST['subtitle'];
		$content = $_POST['content'];
		
		// get res from video field
		$video = $_POST['video'];
		$href = '';
		if (!empty($video)) {
			$v_id = substr($video, 32);
			$href = videoExist($v_id);
		}
		// END get res from video field

		$created = $updated = time();
		$searchteg = $_POST['searchteg'];

		mysqli_query($con, "
			INSERT INTO posts (id_group, id_category, image_url, title, subtitle, content, video, created, updated, important, teg)
			VALUES ('$group', '$category', '$image_url', '$title', '$subtitle', '$content', '$href', '$created', '$updated', '$important', '$searchteg')");

		header('Location: /pb/addpost.php');
	}
	else {
		print "Cimpurile sunt goale.";
	}

	// Add language logic.
	if (!empty($_POST['addlanguage']) && !empty($_POST['name']) && !empty($_POST['prefix'])) {
		$name = $_POST['name'];
		$prefix = $_POST['prefix'];
		
		mysqli_query($con, "INSERT INTO languages (name, prefix) VALUES ('$name', '$prefix')");
		header('Location: /pb/addlanguage.php');
	}
	else {
		echo 'Cimpurile sunt goale!';
	}

	$con->close();
 ?>