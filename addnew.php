<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'dbconfig.php';
	require_once("class.user.php");
		$auth_user = new USER();
	
	if(isset($_POST['btnsave']))
	{
		$userMake = $_POST['user_make'];
		$userModel = $_POST['user_model'];
		$userdesc = $_POST['user_desc'];
		$userPrice = $_POST['user_price'];

		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($userMake)){
			$errMSG = "Please Enter make of phone.";
		}
		else if(empty($userModel)){
			$errMSG = "Please Enter model of phone.";
		}
		else if(empty($userdesc)){
			$errMSG = "Please Enter description of phone.";
		}
		else if(empty($userPrice)){
			$errMSG = "Please Enter price of phone.";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = 'user_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $auth_user->runQuery('INSERT INTO phones(userMake,userModel,userDesc,userPrice,userPic) VALUES(:uMake, :uModel, :udesc, :uprice, :upic )');

			$stmt->bindParam(':uMake',$userMake);
			$stmt->bindParam(':uModel',$userModel);
			$stmt->bindParam(':udesc',$userdesc);
			$stmt->bindParam(':uprice',$userPrice);
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:5;index.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>

<head>


<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>



<div class="container">


	<div class="page-header">
    	<h1 class="h2">Add new phone <a class="btn btn-default" href="buy.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; view all </a></h1>
    </div>
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Make.</label></td>
        <td><input class="form-control" type="text" name="user_make" placeholder="Enter make" value="<?php echo $userMake; ?>" /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Model</label></td>
        <td><input class="form-control" type="text" name="user_model" placeholder="Enter model" value="<?php echo $userModel; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Description</label></td>
        <td><input class="form-control" type="text" name="user_desc" placeholder="Enter description" value="<?php echo $userdesc; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Price</label></td>
        <td><input class="form-control" type="text" name="user_price" placeholder="Enter price" value="<?php echo $userPrice; ?>" /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Upload image</label></td>
        <td><input class="input-group" type="file" name="user_image" accept="image/*" /></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>




    

</div>



	



<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>