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
    
   
        <hr />
        
        <h1>
        <a href="buy.php"><span class="glyphicon glyphicon-shopping-cart"></span> buy</a> &nbsp; 
        <a href="sell.php"><span class="glyphicon glyphicon-usd"></span> sell</a></h1>
        <hr />
        
        <p class="h4">Welcome to smartphoneInfo online store </p> 
       




<div class="container">
  <br>
  <div id="imageSlide" class="carousel slide" data-ride="carousel">
    
    <ol class="carousel-indicators">
      <li data-target="#imageSlide" data-slide-to="0" class="active"></li>
      <li data-target="#imageSlide" data-slide-to="1"></li>
      <li data-target="#imageSlide" data-slide-to="2"></li>
      <li data-target="#imageSlide" data-slide-to="3"></li>
    </ol>

    
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="shop_images/capture.jpg" alt="" width="1200" height="630">
      </div>

      <div class="item">
        <img src="shop_images/repairs.jpg" alt="" width="767" height="300">
      </div>
    
      <div class="item">
        <img src="shop_images/iphone_5c_feature.jpg" alt="" width="1024" height="575">
      </div>

      <div class="item ">
        <img src="shop_images/iphone6.jpg" alt="" width="1200" height="630">
      </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#imageSlide" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#imageSlide" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

        
    
    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>