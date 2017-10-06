<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
?>

<?php

  require_once 'dbconfig.php';
  require_once("class.user.php");
  $auth_user = new USER();
  if(isset($_GET['delete_id']))
  {
    // this will select from db to delete
    $stmt_select = $auth_user->runQuery('SELECT userPic FROM phones WHERE userID =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("user_images/".$imgRow['userPic']);
    
    //this will delete the actual record from the db
    $stmt_delete = $auth_user->runQuery('DELETE FROM phones WHERE userID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();
    
    header("Location: profile.php");
  }

?>

<head>

<?php include 'includes/head.php'; ?>

<head><?php include 'includes/head.php';?></head>

<body>

<?php include 'includes/menu.php'; ?> 

	<div class="clearfix"></div>
	
    <div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">
    
    	<label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
        <hr />
        
        <h1>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp; 
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
        <hr />
        
        <p class="h4">Manage you adds</p> 

        <div class="row">
<?php
  
  $stmt = $auth_user->runQuery('Select users.user_id, phones.userMake, phones.userModel, phones.userDesc , phones.userPrice,   phones.userID, phones.userPic from users, phones 
                                 where users.user_id = phones.user_id and users.user_id =   :user_id');
    $stmt->execute(array(":user_id"=>$user_id));
 // $stmt->execute();
  
  if($stmt->rowCount() > 0)
  {
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
      extract($row);
      ?>
      <div class="col-xs-3">
        <p class="page-header">Phone make: <?php echo $userMake; ?> <br>
          Phone model: <?php echo $userModel; ?><br>
          Description: <?php echo $userDesc; ?><br>
          Price: <?php echo $userPrice;
          $ph_id = $userID; ?>
        </p>
        <img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
        <p class="page-header">
        <span>
        <a class="btn btn-info" href="editform.php?edit_id=<?php echo $ph_id; ?>" title="edit" onclick="return confirm('Are you sure you want to edit')"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
        <a class="btn btn-danger" href="?delete_id=<?php  echo $ph_id; ?>" title="delete" onclick="return confirm('Are you sure you want to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
        </span>
        </p>
      </div>       
      <?php
    }
  }
  else
  {
    ?>
        <div class="col-xs-12">
          <div class="alert alert-warning">
              <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
  }
  
?>
</div>  
        
   
    
</div>

</div>




<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>