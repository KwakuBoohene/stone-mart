<?php
//include database
require(__DIR__.'../../database/dbconnect.php' );
require('upload.php');


function itemsDropDown($item_id,$item_name,$table)
{
	$conn = OpenConnection();
	$result = $conn->query("select $item_id,$item_name from $table");
	closeConnection($conn);
	echo "<option value='0'>Select One (Mandatory) </option>";
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo '<option value="' . $row[$item_id] . '">' . $row[$item_name] . '</option>';
		}
	}
}

//Inserts Row into the database
function insertRow()
{
	$title = $_POST['pname'];
	$category = $_POST['pcategory'];
	$brand = $_POST['pbrand'];
	$description = $_POST['pdesc'];
	$price =  (int)$_POST['pprice'];
	$keywords = $_POST['pkeywords'];
	$image = uploadImage();
	$conn = OpenConnection();

	$result = $conn->query("INSERT INTO
	products(product_title,product_cat, product_brand, 
	product_desc, product_image,product_price,product_keywords) 
	VALUES('$title',$category,$brand,'$description','$image',$price,'$keywords')");


	if ($result === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $result . "<br>" . $conn->error;
	}

	closeConnection($conn);
	return ($result);
}

function validate_form()
{
	$price = $_POST['pprice'];
	$title = $_POST['pname'];
	$brand = $_POST['pbrand'];
	$category = $_POST['pcategory'];
	$regValidPrice = preg_match('/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/', $price);

	if (empty($title)){ 
		echo "Please fill the form title <br>";
		return false;
	}elseif(empty($price)) {
		echo "Please enter a number <br>";
		return false;
	}elseif($regValidPrice == false){
		echo "number is invalid <br>";
	}elseif(empty($brand)){
		echo "Please select a brand <br>";
		return false;
	}elseif(empty($category)){
		echo "Please select a category <br>";
		return false;
	}else{
		return true;
	}
}

//Alerts User that there was an errror in filling the input spaces
function errorFill(){
	return(isset($_GET['error'])?$_GET['error']:'');
}

$error = "There was an error in filling your form <br> , please fill all spaces and try again";
if (isset($_POST['addproduct'])){
	validate_form();
	if(!validate_form()){
	header("Location: ../admin/add-products.php?error=$error");
	echo "Please fill the form";
	}
	else{
		insertRow();
	}
	
}

//Lists items in the side bar. 
function listSideBarItems($table,$table_id,$table_name,$page)
{
	$conn = OpenConnection();
	$result = $conn->query("select $table_id,$table_name from $table");
	closeConnection($conn);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo '<a href=" '.$page.'.php?'.$table.'='.$row[$table_id].' " class="light-bold">' . $row[$table_name] . '</a><br>';
		}
	}
}


//Lists all the products in the content space
function listProducts($page,$image_src){

	$conn = OpenConnection();
	$result = $conn->query('select product_id,product_title,product_image,product_price,product_cat,product_brand from products');
	closeConnection($conn);
		if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo '<div class="item-card">
					<br><br>

					<center>
						<img src="'.$image_src.''.$row['product_image'].'" height="150" width="150" alt="">
						<p>'.$row['product_title'].'</p>
						<p>Price: GHS '.$row['product_price'].'.00</p>
					</center>
					
					<form method="post" class="add-to-cart-form">
							<input type="hidden" name="cart-item" value='.$row['product_id'].'>
							<br>
							<input type="submit" name="add-to-cart" value="add to cart" class="add-to-cart">
						
						Quantity:	<select name="quantity">
										<option value=1 selected>1</option>
										<option value=2>2</option>
										<option value=3>3</>
										<option value=4>4</option>
										<option value=5>5</option>
									</select>
					</form>
					<a href=" '.$page.'.php?productId='.$row['product_id'].' ">View</a>	
						<br><br>
				</div>';
		}
	}

}

//Displays products in the content space based on the category selected
function displayByColumnType($ColumnValue,$ColumnToSelectBy,$page,$image_src){
	$conn = OpenConnection();
	//sql query to get the product by the required column using a value from the column e.g where "brands" = 1; 
		$result = $conn->query("select product_id,product_image, product_title, product_price,product_cat,product_brand from products where $ColumnToSelectBy= $ColumnValue ");
	//close the connection
	closeConnection($conn);

	//javascript code that will make the div with the id 'theDiv' empty (clear all the products from the screen). We do this inorder to display a single product on the screen
	echo '<script>
	document.getElementById("content").innerHTML = "";
	</script>';

	//if the number of rows is greater than 0
	if($result->num_rows>0){
		//for each row that has that product id (this will always be 1 product since product_id is a primary key)
		while ($row = $result->fetch_assoc()) {
			echo '
					<div class="item-card">
						<br><br>

						<center>
							<img src="'.$image_src.''.$row['product_image'].'" height="150" width="150" alt="">
							<p>'.$row['product_title'].'</p>
							<p>Price: GHS '.$row['product_price'].'.00</p>
						</center>
					

					
						<form method="post" class="add-to-cart-form">
							<input type="hidden" name="cart-item" value='.$row['product_id'].'>
							<br>
							<input type="submit" name="add-to-cart" value="add to cart" class="add-to-cart">

						Quantity:	<select name="quantity">
										<option value=1 selected>1</option>
										<option value=2>2</option>
										<option value=3>3</>
										<option value=4>4</option>
										<option value=5>5</option>
									</select>
						</form>
						
						<a href=" '.$page.'.php?productId='.$row['product_id'].' ">View</a>
						<br><br>
					</div>';
		}
	}

}

//Displays only one product in the content space
function displayOneProduct($productID,$image_src,$page){
	$conn = OpenConnection();
	//sql query to get the product by the product_id
	$result = $conn->query("select product_id, product_image, product_title, product_price from products where product_id ='$productID' ");
	//close the connection
	closeConnection($conn);

	//javascript code that will make the div with the id 'theDiv' empty (clear all the products from the screen). We do this inorder to display a single product on the screen
	echo '<script>

	document.getElementById("content").innerHTML = "";
	document.getElementById("content").style.display = "block";
	</script>';

	//if the number of rows is greater than 0
	if($result->num_rows>0){
		//for each row that has that product id (this will always be 1 product since product_id is a primary key)
		while ($row=$result->fetch_assoc()) {
		//echo the details of the product
			echo '<div>
						<div>
							<center>
								
								<img src="'.$image_src.''.$row['product_image'].'" height="400" width="500">
								<h3>'.$row['product_title'].'</h3>
								<p>Price: '.$row['product_price'].'</p>
								<form method="post" class="add-to-cart-form">
									<input type="hidden" name="cart-item" value='.$row['product_id'].'>
									<input type="submit" name="add-to-cart" value="add to cart" class="add-to-cart">
						Quantity:	<select name="quantity">
										<option value=1 selected></option>
										<option value=2>2</option>
										<option value=3>3</>
										<option value=4>4</option>
										<option value=5>5</option>
									</select>
								</form>
								<a class="black-text view-button" href="'.$page.'.php">Close</a>
								
							</center>
							
						</div>
					
					</div>';  	
		}
	}
	
}

//Decides whether to display all items or items by catergories , or items by brands 
function chooseWhatToDisplay($page,$image_src){
	if(isset($_GET['productId'])){
  				displayOneProduct($_GET['productId'],$image_src,$page);
  				}
	if(isset($_GET['categories'])){
						displayByColumnType((int)$_GET['categories'],'product_cat',$page,$image_src);
					}
	if(isset($_GET['brands'])){
					displayByColumnType((int)$_GET['brands'],'product_brand',$page,$image_src);
	}
	if(isset($_GET['search-button'])){
					searchFunction($page,$image_src);
	}

}



//Displays products in the content space based on the category selected
function searchFunction($page,$image_src){
	$searchValue = $_GET['search-box'];
	$conn = OpenConnection();
	//sql query to get the product by the required column using a value from the column e.g where "brands" = 1; 
	$result = $conn->query("SELECT product_id, product_image, product_title, product_price FROM products
		 WHERE product_title LIKE '%$searchValue%' ");
	//close the connection
	closeConnection($conn);

	//javascript code that will make the div with the id 'theDiv' empty (clear all the products from the screen). We do this inorder to display a single product on the screen
	echo '<script>
	document.getElementById("content").innerHTML = "";
	</script>';

	//if the number of rows is greater than 0
	if($result->num_rows>0){
		//for each row that has that product id (this will always be 1 product since product_id is a primary key)
		while ($row = $result->fetch_assoc()) {
			echo '
					<div class="item-card">
						<br><br>

						<center>
							<img src="'.$image_src.''.$row['product_image'].'" height="150" width="150" alt="">
							<p>'.$row['product_title'].'</p>
							<p>Price: GHS '.$row['product_price'].'.00</p>
						</center>
					
					
						<form method="post" class="add-to-cart-form">
									<input type="hidden" name="cart-item" value='.$row['product_id'].'>
									<input type="submit" name="add-to-cart" value="add to cart" class="add-to-cart">
						Quantity:	<select name="quantity">
										<option value=1 selected></option>
										<option value=2>2</option>
										<option value=3>3</>
										<option value=4>4</option>
										<option value=5>5</option>
									</select>
						</form>

						<a href=" '.$page.'.php?productId='.$row['product_id'].' ">View</a>
						
						<br><br>
					</div>';
		}
	}else{
		echo '<div>
			<h1>NO RESULTS FOR  THIS SEARCH</h1>
		</div>';
	}

}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function addtoCart(){
	if(isset($_POST["add-to-cart"])){
		$ipaddress = get_client_ip();
		$productid =  $_POST["cart-item"];
		$quantity = $_POST['quantity'];

//First check if the item is already in the cart
		$con = openConnection();
		$checkCartQuery = $con->query("SELECT p_id,ip_add FROM cart WHERE p_id=$productid AND ip_add ='$ipaddress' ");
		closeConnection($con);
		if($checkCartQuery->num_rows>0){
			echo '
			<script>
				alert("Sorry the item has already been added to the cart");
			</script>
			';
			
//if the item is not in the cart then add it
		}else{
			$con = openConnection();
			$sql = "INSERT INTO cart (p_id, ip_add, qty)VALUES ($productid, '$ipaddress', $quantity)";
			if ($con->query($sql) === TRUE) {
				echo '
					<script>
						alert("New item added successfully");
					</script>
			';
			} else {
				echo '
					<script>
						alert("Sorry there is a problem with the system");
					</script>
			';
				
			}
			closeConnection($con); 
		}
	}
//add to cart
}

function breadCrumbsDisplay(){
	$ipaddress = get_client_ip();
	global $username;

	$con = openConnection();
	$result = $con->query("SELECT SUM(cart.qty*products.product_price) AS total, SUM(cart.qty) AS quantity
	 FROM cart,products WHERE products.product_id=cart.p_id");
	closeConnection($con);
	
	if($result->num_rows>0){
		while ($row = $result->fetch_assoc()) {
			if($row['quantity']==null || $row['quantity']==""){
				echo '<h2 class="bold">
				Welcome '.$username.', shopping cart - Total Items: 0 Total Price: GHS 0
				</h2>';
			
			}else{
				echo '<h2 class="bold">
				Welcome '.$username.', shopping cart - Total Items: '.$row['quantity'].' Total Price: GHS '.$row['total'].'.00 
				</h2>';
			}
		}
	}

} 


function displayCartItems(){
	$conn = OpenConnection();
	
	$result = $conn->query("SELECT cart.p_id,cart.ip_add,cart.qty,
	products.product_title,cart.qty*products.product_price AS total
	FROM cart,products WHERE cart.p_id=products.product_id");
	
	closeConnection($conn);

	$conn = OpenConnection();
	$result2 = $conn->query("SELECT COUNT(cart.qty) AS count FROM cart,products WHERE cart.p_id=products.product_id");
	closeConnection($conn);
	if($result2->num_rows>0){
		while($row = $result2->fetch_assoc()){
			$count = $row['count'];
		}
	}else{
		$count = 0;
	}
		
		
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if($count ==0){
			echo "<h1>the cart is empty boss</h1>";
			
			}else{
				echo '
				<tr>
				<td class="tg-0lax">'.$row['product_title'].'</td>
				<td class="tg-0lax">'.$row['qty'].'</td>
				<td class="tg-0lax">GHS '.$row['total'].'.00</td>
				<td>
					<form method="get">
						<input type="hidden" name="id" value='.$row['p_id'].' >
						<input type="number" name="qty" value='.$row['qty'].' class="shopping-cart-value">
						<input type="submit" value="update" name="update" class="shopping-cart-form">
						<input type="submit" value="delete" name="delete" class="shopping-cart-form">
					</form>
				</td>
			</tr>
			';
				
			}
		}
	}
		
	}

function deleteFromCart(){
	if (isset($_GET['delete'])){
		$id = $_GET['id'] ;
		echo $id;
		$conn = OpenConnection();
		$result = $conn->query("DELETE FROM cart WHERE p_id=$id");	
		closeConnection($conn);
		unset($_GET['delete']);
		header("Location: shopping-cart.php");
	}
}

function UpdateFromCart(){
	if (isset($_GET['update'])){
		$qty = $_GET['qty'] ;
		$id = $_GET['id'] ; ;
		$conn = OpenConnection();
		$result = $conn->query("UPDATE cart
		SET qty=$qty WHERE p_id=$id");	
		closeConnection($conn);
		unset($_GET['update']);
		header("Location: shopping-cart.php");
	}
}

function DisplayCartPrice(){
		$con = openConnection();
	$result = $con->query("SELECT SUM(cart.qty*products.product_price) AS total
	 FROM cart,products WHERE products.product_id=cart.p_id");
	closeConnection($con);
	
	if($result->num_rows>0){
		while ($row = $result->fetch_assoc()) {
			echo '<h3>Total Price =GHS '.$row['total'].'.00</h3> ';
		}
	}
}

function registrationFormSubmit(){
	if(isset($_POST['register'])){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$country = $_POST['country'];
		$city =  $_POST['city'];
		$contact = $_POST['contact'];
		$image = uploadImage();
		$address = $_POST['address'];
		$conn = OpenConnection();

	//	if (registrationValidate($email,$password,$contact)== TRUE ){
			$result = $conn->query("INSERT INTO
			customer(customer_name,customer_email, customer_pass,  customer_country,
			customer_city,customer_contact,
			customer_image,customer_address) 
			VALUES('$username','$email','$password',
			'$country','$city',$contact,'$image','$address')");

			if ($result === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $result . "<br>" . $conn->error;
			}

			closeConnection($conn);
			return ($result);
		// }else{
		// 	return FALSE;
		// }


	}

}

function registrationValidate($email,$password,$contact){
	$contactcheck = preg_match("^\+\d{12}|\d{11}|\+\d{2}-\d{3}-\d{7}^",$contact);
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//email validation
		if (strlen($password) > 7 ){
			//password length validation
				//password validation
				if ($contactcheck === TRUE) {
					//contact validation
					return TRUE;
				}else{
					echo '<script>alert("Invalid Phone Number.
						Should only contain numbers. For example : 0244257713")
					</script>
					<h1>Invalid Phone Number.
						Should only contain numbers. For example : 0244257713</h1>
					';
					return FALSE;
				}
		}else{
			echo '<script>alert("Invalid Password. 
			Should be a minimum of 8 characters")
				 </script>
				 <h1>Invalid Password. 
			Should be a minimum 8 characters</h1>';
			return FALSE;
		}
	}else{
			echo '<script>alert("Email is invalid. For example : "user@example.com"");
		</script>
		<h1>Email is invalid. For example : "user@example.com"</h1>
		';
		return FALSE;
	}
}


function login(){
	if(isset($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$conn = OpenConnection();

		$result = $conn->query("SELECT customer_email,customer_pass
		 FROM customer WHERE customer_email = '$email' AND customer_pass='$password'");
		
		closeConnection($conn);


		$conn = OpenConnection();
		$result2 = $conn->query("SELECT COUNT(customer_email) AS count
		 FROM customer WHERE customer_email = '$email' AND customer_pass='$password'");
		closeConnection($conn);
		 if($result2->num_rows>0){
			 while($row = $result2->fetch_assoc()){
				 $count = $row['count'];
			 }
		 }else{
			 $count = 0;
		 }

		if($result->num_rows>0){
		while ($row = $result->fetch_assoc()) {
			if($count==0){
					echo "your login credentials are incorrect";
			}else{
					echo "welcome to the page";
					session_start();
					$conn = OpenConnection();
					
					$query = "SELECT * FROM customer WHERE customer_email = '$email' AND customer_pass = '$password'";
					$result = $conn->query($query);
					if($result->num_rows>0){
						while($row= $result->fetch_assoc()){
						$_SESSION['username'] = $row['customer_name'];
						header("Location: ../index.php");
						}
					}	
			}
		}
	}
		
	}
}

function showLogin($logoutpage){
	global $username;
	if($username == "Guest"){
		echo '<form method="POST">
			<input type="submit" name="login" value="Login">
		</form>';
	}else{
		echo '<a href="'.$logoutpage.'">Logout</a>';
	}
}

function GoToLogin($page){
	if(isset($_POST['login'])){
		header("Location:$page");
	};
};




function checkoutRedirect(){
	global $username;
	if($username == "Guest"){
		echo '<a href="login.php">Checkout?</a>';
	}else{
		echo '<a href="checkout.php">Checkout?</a>';
	}
}
?>