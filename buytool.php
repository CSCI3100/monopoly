<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<form action="./proc.php" method="post">
<p>Stop other player for one round(Price: 1 credit)</p>
<p>Quantity:
  <input type="number" name="one">
</p>
<p>Get double rent (Price: 3 credits)</p>
<p>Quantity:
  <input type="number" name="double">
</p>
<p>Get quick cash $10000 (Price: 2 credits)</p>
<p>Quantity:
  <input type="number" name="cash">
</p>
<p><br>
  <input type="submit" name="submit">
  <br>
  <?php
if(isset($_GET['res'])){ 
  if($_GET['res']==0){
	  		echo "You don't have enough money, please recharge.";
	  }
	  if($_GET['res']==1){
		  echo "Buy successfully";
		  }
}
	  ?>
</p>
</form>
</body>
</html>