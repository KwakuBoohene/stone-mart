<?php include("../functions/functions.php") ?>
<?php
	echo "<a href='../index.php'>back to home page</a>";

	//drop down in the form should pull from the database

	//validation - regular expression (javascript & php)

	//add product 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Product</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php echo '<h1 class="error">' .errorFill(). '</h1>' ?> 

	<!-- <form action="../function/upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
	</form> -->

	<!--create html form to match the product table-->
	<div class="form">

		<div class=""></div>
		<form  class="add-product-form" action="../functions/functions.php" method="post" enctype="multipart/form-data" name="add_product" onsubmit="return validate()">
			<h2 class="bold">Please fill the following form to add a product</h2><br>
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<br><br>
			<!-- <input type="submit" value="Upload Image" name="submit"> -->

			<label>Product Title</label>
			<input type="text" name="pname"   placeholder="Enter a title (Mandatory)"> <br><br>
			<label>Product Category</label>
				<select name="pcategory"  >
				<?php itemsDropDown('cat_id','cat_name','categories'); ?>
				</select> <br><br>

			<label>Product Brand</label>
				<select name="pbrand" >
				<?php itemsDropDown('brand_id','brand_name','brands'); ?>
				</select> <br><br>
			
			<label>Product Desription</label>
			<input type="text" name="pdesc" ><br><br>

			<label for="">Product Price</label>
			<input type="text" name="pprice" placeholder="Enter a price (Mandatory)"><br><br>

			<label for="">Keywords</label>
			<input type="text" name="pkeywords" ><br><br>

			<input type="submit" name="addproduct" value="Add Product" id="submit">

		</form>
		<div class=""></div>
	</div>	



</body>
	<script src="../javascript/script.js"></script>


</html>

