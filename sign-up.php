<?php
session_start();
require_once('class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$ufname = strip_tags($_POST['txt_fname']);
	$ulname = strip_tags($_POST['txt_lname']);
	$uaddress = strip_tags($_POST['txt_address']);	
	$unum = strip_tags($_POST['txt_num']);	
    $uemail = strip_tags($_POST['txt_email']);	
	$upass = strip_tags($_POST['txt_upass']);

	
	//checks if details are correct 
	if($uname=="")	{
		$error[] = "provide username !";	
	}
	else if($uemail=="")	{
		$error[] = "provide email address !";	
	}
	else if(!filter_var($uemail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please enter a valid email address !';
	}
	else if($upass=="")	{
		$error[] = "provide password !";
	}
	else if(strlen($upass) < 6){
		$error[] = "Password must be atleast 6 characters";	
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, user_email FROM users WHERE user_name=:uname OR user_email=:uemail");
			$stmt->execute(array(':uname'=>$uname, ':uemail'=>$uemail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['user_name']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($row['user_email']==$uemail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($uname,$uemail,$upass,$ufname, $ulname, $uaddress, $unum)){	
					$user->redirect('sign-up.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>

<head>
<meta charset=utf-8>
<title>Sign up</title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
			}
			?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_fname" placeholder="Enter first name" value="<?php if(isset($error)){echo $ufname;}?>" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_lname" placeholder="Enter last name" value="<?php if(isset($error)){echo $ulname;}?>" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_address" placeholder="Enter address" value="<?php if(isset($error)){echo $uaddress;}?>" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_num" placeholder="Enter phone number" value="<?php if(isset($error)){echo $unum;}?>" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="txt_email" placeholder="Enter Email" value="<?php if(isset($error)){echo $uemail;}?>" />
            </div>

            <div class="form-group">
            <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
            </div>

            <div class="clearfix"></div><hr />

            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-signup">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ? <a href="index.php">Sign In</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>