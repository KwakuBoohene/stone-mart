<?php
	require('../functions/functions.php');
	session_start();
	$ipaddress = get_client_ip();
	$_SESSION['ip_address'] = $ipaddress; 
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
	<title>STONE MART - Homepage</title>
</head>

<body>
	<?php 
	deleteFromCart();
	UpdateFromCart();
	 ?>
	<header>
			<div class="header">
				<center>
					<a href="">
						<img src="css/header-icon.png" alt="" width="70" height = "70" class="header-icon">
					</a>
					<br>
					<h1>STONE MART</h1>
					<br>
				</center>
			</div>

		<div class="navbar">
				<a href="../index.php" class="bold">Home</a>
				<a href="products.php" class="bold">Products</a>
				<a href="account.php" class="bold">Account</a>
				<a href="register.php" class="bold">Sign Up</a>
				<a href="shopping-cart.php" class="bold selected">Shopping Cart</a>
				<a href="contact-us.php" class="bold">Contact Us</a>
		</div>
	</header>


	<section class= "cart-middle-part">
	<div class=""></div>
	<div class="cart-table">
		<table class="tg">
			<tr>
				<th class="tg-0lax">item Name</th>
				<th class="tg-0lax">Quantity</th>
				<th class="tg-0lax">Price</th>
			</tr>
		<?php displayCartItems(); ?>	
		</table>
		<br>
	<?php DisplayCartPrice(); ?>

	<a href="../index.php">Continue Shopping</a>	
	<?php checkoutRedirect() ?>

	</div>
	<div class=""></div>
	</section>
	
	<section class="footer">
		<br><br><br>
		<center>Copyright, 2019</center>
		<br><br><br>
	</section>

</body>
</html>