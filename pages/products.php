<?php
	// echo "<a href='admin/add-products.php'>Add Product</a>";
	include('../functions/functions.php');
	$page = 'products';
    $image_src = '../image/';
	session_start();
	$ipaddress = get_client_ip();
	$_SESSION['ip_address'] = $ipaddress; 
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
	GoToLogin("login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
	<title>STONE MART - Products</title>
</head>

<body>
	<header>
			<div class="header">
				<center>
					<a href="">
						<img src="../css/header-icon.png" alt="" width="70" height = "70" class="header-icon">
					</a>
					<br>
					<h1>STONE MART</h1>
					<br>
				</center>
			</div>
			
		<div class="navbar">
				<a href="../index.php" class="bold">Home</a>
				<a href="products.php" class="bold selected">Products</a>
				<a href="account.php" class="bold">Account</a>
				<a href="register.php" class="bold">Sign Up</a>
				<a href="shopping-cart.php" class="bold">Shopping Cart</a>
				<a href="contact-us.php" class="bold">Contact Us</a>
				<a  class="bold">
					<form action="products.php" method="get" id="search-form">
						<input type="text" placeholder="Search here" id="search-box" name="search-box">
						<input type="submit" value="go" id="search-button" name="search-button">
					</form> 
				</a>
		</div>
	</header>

	<div class="breadcrumbs">
		<div class=""></div>
		<div class="">
			<?php showLogin("logout.php") ?>
			<h5><?php addtoCart() ?></h5>
			<?php breadCrumbsDisplay() ?> <a class="breadcrumbs-cart" href="shopping-cart.php">Go To Cart</a>
		</div>
		<div class=""></div>
	</div>

			<center><h2>PRODUCTS</h2></center>
	<section class="main">
		

		<div class="side-bar">

			<div class="brands">
				<h5>SORT PRODUCTS BY:</h5>
				<p class='bold'>Brands</p>
				<br>
				<?php listSideBarItems('brands','brand_id','brand_name',$page) ?>

				<br>
			</div>

			<div class="categories">
				<br>
				<p class='bold'>Categories</p>
				<br>
				<?php listSideBarItems('categories','cat_id','cat_name',$page) ?>

				<br>
			</div>
		</div>

		<div class="content" id="content">

			
			<?php listProducts($page,$image_src) ?>
			<?php chooseWhatToDisplay($page,$image_src) ?>
		</div>

	</section>

	<section class="footer">
		<br><br><br>
		<center>Copyright, 2019</center>
		<br><br><br>
	</section>

</body>
</html>