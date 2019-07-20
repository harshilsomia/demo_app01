<?php
	require_once('dbConfig.php');
	$upload_dir = 'uploads/';

	if(isset($_POST['btnSave'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confrm_pass = $_POST['confrm_pass'];
// 		if ($password != $confrm_pass) {
// echo("Error... Passwords do not match");
// }
		$position = $_POST['position'];

		$imgName = $_FILES['myfile']['name'];
		$imgTmp = $_FILES['myfile']['tmp_name'];
		$imgSize = $_FILES['myfile']['size'];

		if(empty($name)){
			$errorMsg = 'Please input name';
		}elseif(empty($email)){
			$errorMsg = 'Please input Email';
		}
		elseif(empty($password)){
			$errorMsg = 'Please input password';
		}
		elseif(empty($confrm_pass)){
			$errorMsg = 'Please input Conform password';
		}

		 elseif($password != $confrm_pass){
       $errorMsg='Passwords do not match';
    }

		elseif(empty($position)){
			$errorMsg = 'Please input position';
		}elseif(empty($imgName)){
			$errorMsg = 'Please select photo';
		}else{
			//get image extension
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
			//allow extenstion
			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');
			//random new name for photo
			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
			//check a valid image
			if(in_array($imgExt, $allowExt)){
				//check image size less than 5MB
				if($imgSize < 5000000){
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
				}
			}else{
				$errorMsg = 'Please select a valid image';
			}
		}

		//check upload file not error than insert data to database
		if(!isset($errorMsg)){
			$sql = "insert into tbl_users(name, email, password, confrm_pass, position, photo)
					values('".$name."', '".$email."', '".$password."', '".$confrm_pass."', '".$position."', '".$userPic."')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$successMsg = 'New record added successfully';
				header('refresh:5;index.php');
			}else{
				$errorMsg = 'Error '.mysqli_error($conn);
			}
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Uploadimage</title>
	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap-theme.min.css">
</head>
<body>

<div class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<h3 class="navbar-brand">PHP upload image</h3>
		</div>
	</div>
</div>
<div class="container">
	<div class="page-header">
		<h3>Add New
			<a class="btn btn-default" href="index.php">
				<span class="glyphicon glyphicon-arrow-left"></span> &nbsp;Back
			</a>
		</h3>
	</div>

	<?php
		if(isset($errorMsg)){		
	?>
		<div class="alert alert-danger">
			<span class="glyphicon glyphicon-info">
				<strong><?php echo $errorMsg; ?></strong>
			</span>
		</div>
	<?php
		}
	?>

	<?php
		if(isset($successMsg)){		
	?>
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-info">
				<strong><?php echo $successMsg; ?> - redirecting</strong>
			</span>
		</div>
	<?php
		}
	?>

	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			<label for="name" class="col-md-2">Name</label>
			<div class="col-md-10">
				<input type="text" name="name" placeholder="Enter you Name" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="email" class="col-md-2">Email</label>
			<div class="col-md-10">
				<input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"  placeholder="Enter you Email" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="text" class="col-md-2">Password</label>
			<div class="col-md-10">
				<input type="password" name="password" placeholder="Enter you password" class="form-control" value="<?php echo $row['password'] ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="text" class="col-md-2">Conform Password</label>
			<div class="col-md-10">
				<input type="password" name="confrm_pass"   placeholder="Enter you Conform password" class="form-control" value="<?php echo $row['confrm_pass'] ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="position" class="col-md-2">Position</label>
			<div class="col-md-10">
				<input type="text" name="position" placeholder="Enter you Position" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="photo" class="col-md-2">Photo</label>
			<div class="col-md-10">
				<input type="file" name="myfile">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2"></label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-success" name="btnSave">
					<span class="glyphicon glyphicon-save"></span>Save
				</button>
			</div>
		</div>
	</form>
</div>

</body>
</html>
