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
    
     
        
      
        <p class="h4">Our repair section will be coming soon</p> 

         <img src="shop_images/22520129_l.jpg" class="img-rounded" alt="" width="574" height="574"> 

       

        
    
    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>