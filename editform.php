<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig.php';
	require_once("class.user.php");
	$auth_user = new USER();
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $auth_user->runQuery('select users.user_name, phones.userMake, phones.userModel, phones.userDesc , phones.userPrice,  phones.userPic from users, phones 
                                 where users.user_id = phones.user_id and phones.userID = :id
                               ');
		$stmt_edit->execute(array(
			':id'=>$id));

		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: profile.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_make'];
		$userjob = $_POST['user_model'];
		$userDesc = $_POST['user_desc'];
		$userPrice = $_POST['user_price'];
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'user_images/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // gets image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt; // generates random number between the two and adds extenstion at the end 
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['userPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}	
						
		
		// if no error occured, continue ...
		if(!isset($errMSG))
		{
			$stmt = $auth_user->runQuery('UPDATE phones 
									     SET userMake=:uname, 
										     userModel=:ujob,
										     userDesc =:udesc,
										     userPrice =:uprice,  
										     userPic=:upic 
								       WHERE userID=:uid');

			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':ujob',$userjob);
			$stmt->bindParam(':udesc',$userDesc);
			$stmt->bindParam(':uprice',$userPrice);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>

<head>

<title>Edit Phone</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="style.css">
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="jquery-1.11.3-jquery.min.js"></script>
</head>
<body>




<div class="container">


	<div class="page-header">
    	<h1 class="h2">	Update phone <a class="btn btn-default" href="profile.php"> All phones </a></h1>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
  
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Make</label></td>
        <td><input class="form-control" type="text" name="user_make" value="<?php echo $userMake; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Model</label></td>
        <td><input class="form-control" type="text" name="user_model" value="<?php echo $userModel; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Description</label></td>
        <td><input class="form-control" type="text" name="user_desc" value="<?php echo $userDesc; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Price</label></td>
        <td><input class="form-control" type="text" name="user_price" value="<?php echo $userPrice; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Phone image</label></td>
        <td>
        	<p><img src="user_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="profile.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>




</div>
</body>
</html>