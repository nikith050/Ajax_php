<?php 
	
	//DATABASE CONNECTION
	include_once('db.php');

	//INSERTING USER DATA
	if(isset($_POST['buttonsave'])) {
		$sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES ('{$_POST['name']}','{$_POST['email']}','{$_POST['password']}')";
		$result = mysqli_query($conn, $sql);

		if ($result) {
			echo "1 record added";
		} else {
			echo " error";
		}		
	};

	//SHOW USER DETAILS
	if(isset($_GET['show'])) {
		$sql = "SELECT * FROM user ";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			while ($row=mysqli_fetch_object($result)) {
				echo "<tr><td id='name' class='text-center name'>$row->name</td><td id='email' class='text-center'>$row->email</td><td id='pwd' class='text-center'>$row->password</td><td class='text-center'><a ide='$row->id' class='edit' href='#?id=$row->id'>Edit</a> <a idd='$row->id' class='delete' href='#?idd=$row->id'>Delete</a></td>'</tr>";		
			}			
			exit();
		}
	};

	//EDIT BUTTON OPERATION
	if(isset($_POST['edituser'])) {
		$sql = "SELECT * FROM user WHERE id='{$_POST['id']}'";		
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$row = mysqli_fetch_object($result);
			header('Content-Type: application/json');
			echo json_encode(array('user' => $row));
		} else {
			echo " error";
		}		
	};

	//UPDATE USER DETAILS
	if(isset($_POST['updateuser'])) {
		$sql = "UPDATE `user` SET `id`='{$_POST['id']}',`name`='{$_POST['name']}',`email`='{$_POST['email']}',`password`='{$_POST['password']}' WHERE id='{$_POST['id']}'";		
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "Updated";
		} else {
			echo " error";
		}		
	};

	//UPLOAD IMAGE
	if(isset($_POST['image'])) {
		for($i=0; $i<count($_FILES['image']['name']); $i++) {
			global $conn;
		  	if(isset($_FILES["image"])) {
		    @list(, , $imtype, ) = getimagesize($_FILES['image']['tmp_name'][$i]);
		    // Get image type.
		    // We use @ to omit errors
			    if ($imtype == 3){ // cheking image type
			      	$ext="png";
			    }
			    elseif ($imtype == 2){
			      	$ext="jpeg";
			    }
			    elseif ($imtype == 1){
			      	$ext="gif";
			    }
			    else{
			      $msg = 'Error: unknown file format';
			       	echo $msg;
			      	exit;
			    }
			    if(getimagesize($_FILES['image']['tmp_name'][$i]) == FALSE){
			      	echo "Please select an image.";
			    }
			    else{
			      	$image= addslashes($_FILES['image']['tmp_name'][$i]);
			      	$name= addslashes($_FILES['image']['name'][$i]);
			      	$image= file_get_contents($image);
			      	$image= base64_encode($image);
			      	saveimage($name,$image);
			    }
		  	}
		}
		function saveimage($name,$image){
			global $conn;	
		  	$check="SELECT * FROM images WHERE name = '$name'";
		  	$rs = mysqli_query($conn,$check);
		  	$data = mysqli_fetch_array($rs, MYSQL_NUM);
		  	if($data[0] > 1) {
		    	echo ($name . " " . "Image already exists.\n");
		  	}
		  	else{
		    	$qry="INSERT INTO images (name,image) values ('$name','$image')";
		    	$result=mysqli_query($conn,$qry);
		    	if($result){
		      	echo ($name . " " . "Image uploaded.\n");
		    	}
		    	else{
		      		echo ($name . " " . "Image not uploaded.\n");
		    	}
		  	}
		}
	}	

	mysqli_close($conn);
?>