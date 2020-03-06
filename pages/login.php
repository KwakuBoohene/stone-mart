<?php require("../functions/functions.php") ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body> 


	<div class="form">

		<div class=""></div>
		<form  class="login-form" action="login.php" method="post" >
        
        <?php login() ?>
            

            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            


            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>
            <br><br>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <br><br>

            <input type="submit" name="login" value="Login">
                    
        
        <div class="container signin">
            <p>Don't have an account? <a href="register.php">Sign up</a>.</p>
        </div>
		</form>
		<div class=""></div>
	</div>	



</body>
	<script src="../javascript/script.js"></script>


</html>

