<?php

  
  
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
    // this will select from the db to delete
    $stmt_select = $auth_user->runQuery('SELECT userPic FROM phones WHERE userID =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("user_images/".$imgRow['userPic']);
    
    //this will delete an actual record from db
    $stmt_delete = $auth_user->runQuery('DELETE FROM phones, users WHERE users.user_id = phones.user_id');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();
    
    header("Location: index.php");
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
    
    
        <hr />
        
        <h1>
        <a href="buy.php"><span class="glyphicon glyphicon-shopping-cart"></span></span> buy</a> &nbsp; 
        <a href="sell.php"><span class="glyphicon glyphicon-usd"></span> sell</a></h1>
        <hr />
     

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
         
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-0">

            <form action="" class="search-form">
                <div class="form-group has-feedback">
                <label for="search" class="sr-only">Search</label>
                <input type="text" class="form-control" name="search" id="search" placeholder="search">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
              </div>
            </form>
        </div>
    </div>
</div>

  
    
<br />

<div class="row">
<?php
  
  $stmt = $auth_user->runQuery('select users.user_name, phones.userMake, phones.userModel, phones.userDesc , phones.userPrice,  phones.userPic from users, phones 
                                where users.user_id = phones.user_id
                                order by userId DESC');
  $stmt->execute();
  
  if($stmt->rowCount() > 0)// if there is results 
  {
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
      extract($row);
      ?>
      <div class="col-xs-3">
        <p class="page-header">

          User: <?php echo $user_name; ?><br>
          Make: <?php echo $userMake; ?> <br>
          Model: <?php echo $userModel; ?><br>
          Description: <?php echo $userDesc; ?><br>
          Price: <?php echo $userPrice; ?>
        </p>
        <img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
        <span>
        <a class="btn btn-info" href=""><span class="glyphicon glyphicon-shopping-cart"></span> Buy now</a> 
       </span>
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

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>