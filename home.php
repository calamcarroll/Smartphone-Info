<?php

 
  
  require_once("class.user.php");
  $auth_user = new USER();
  
  
  $user_id = $_SESSION['user_session'];
  
  $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<head>

<?php include 'includes/head.php'; ?>

</head>

<body>

<?php include 'includes/menu.php'; ?> 

<div class="clearfix"></div>
  
    <div class="container-fluid" style="margin-top:80px;">
  
    <div class="container">
    
     
        
        
        <h1>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp; 
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
        <hr />
        
        <p class="h4">Welcome to Smartphone info</p> 

         <img src="shop_images/my image.jpg" class="img-rounded" alt="" width="970" height="545"> 

       

        
    
    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>