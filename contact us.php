<?php
  

  require_once('class.user.php');
  
  require_once("session.php");
 
   $auth_user = new USER();
  
  
  $user_id = $_SESSION['user_session'];
  
  $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);



?>
<?php

  error_reporting( ~E_NOTICE ); // avoids any notice errors that might show up. undefined variables ect 
  
  require_once 'dbconfig.php';
  require_once("class.user.php");
    $auth_user = new USER();
  
  if(isset($_POST['btnsave']))
  {
    $problemName = $_POST['problem_name'];
     $problemNumber = $_POST['problem_Number'];
    $problemProblem = $_POST['problem_problem'];
   
   

    
    if(empty($problemName)){
      $errMSG = "Please Enter your name so we can acess your problem further";
    }
    else if(empty($problemProblem)){
      $errMSG = "Please Enter your problem";
    }
   
    
    // if no error occure then the data is inserted 
    if(!isset($errMSG))
    {
      $stmt = $auth_user->runQuery('INSERT INTO contactUs(name, Phone_number, problem) VALUES(:probName, :probNum, :probProb)');

      $stmt->bindParam(':probName',$problemName);
      $stmt->bindParam(':probNum',$problemNumber);
      $stmt->bindParam(':probProb',$problemProblem);
      
      
      if($stmt->execute())
      {
        $successMSG = "Your problem has been sent and we will be in toutch soon ...";
        header("refresh:5;home.php"); // redirects after 5 seconds.
      }
      else
      {
        $errMSG = "error while inserting....";
      }
    }
  }
?>


<head>

<?php include 'includes/head.php'; ?>

</head>

<body>

<?php include 'includes/menu.php'; ?> 

    <div class="clearfix"></div>
      
    
<div class="container-fluid" style="margin-top:80px;">
  
    <div class="container">
    
    



    
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
      <td><label class="control-label">Name </label></td>
        <td><input class="form-control" type="text" name="problem_name" placeholder="Enter name" value="<?php echo $problemName; ?>" /></td>
    </tr>
    
     <tr>
      <td><label class="control-label">Phone number </label></td>
        <td><input class="form-control" type="text" name="problem_Number" placeholder="Enter phone number" value="<?php echo $problemNumber; ?>" /></td>
    </tr>

    <tr>
      <td><label class="control-label">Problem</label></td>
        <td><input class="form-control" type="text" name="problem_problem" placeholder="Enter problem" value="<?php echo $problemProblem; ?>" /></td>
    </tr>

    
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; Let us know
        </button>
        </td>
    </tr>
    
    </table>
    
</form>



  


<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>