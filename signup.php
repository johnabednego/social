
<?php
	 require_once'database.php';
	 $firstname = $lastname = $username = $username2 = $password = $password2 = $email = $email2 = "";
	 $firstname_err = $lastname_err = $username_err = $username2_err = $password_err = $password2_err =  $email_err=  $email2_err = "";
	
	if ($_SERVER['REQUEST_METHOD'] =='POST')
	{
		
		
		//first name
	if(empty(trim($_POST['firstname']))){
		$firstname_err = "Input First name";
	}elseif (!preg_match('/^[a-zA-Z]/',trim($_POST['firstname']) )) {
		$firstname_err = "Firstname must contain only Alphabets";
	}
	else{
		$firstname=trim($_POST['firstname']);
	}

		//last name
	if(empty(trim($_POST['lastname']))){
		$lastname_err = "Input Last name";
	}elseif (!preg_match('/^[a-zA-Z]/',trim($_POST['lastname']) )) {
		$lastname_err = "Lastname must contain only Alphabets";
	}
	else{
		$lastname=trim($_POST['lastname']);
	}
	//username
	if(empty(trim($_POST['username']))){
		$username_err = "Input Username";
	}elseif (!preg_match('/^[a-zA-Z0-9_]+$/',trim($_POST['username']) )) {
		$username_err = "Username can only contain letters, numbers, and underscores.";
	}
	else{
		$sql = 'SELECT id FROM user WHERE username =?';
		if($stmt=mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt, 's', $param_username);
			$param_username = trim($_POST['username']);
			
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				if( mysqli_stmt_num_rows($stmt)>0){
					$username_err = "Username is Already used!!";
				}else{
					$username = trim($_POST['username']);
				}
			}else{echo "Something Went wrong Try again Later...";}
			mysqli_stmt_close($stmt);
		}
	}

	//username2
	if(empty(trim($_POST['username2']))){
		$username2_err = "Repeat Username";
	}
	else{
		if(empty($username_err)&& empty($username2_err)){
			$username2 = trim($_POST['username2']);
			if($username != $username2){
				$username2_err = "Username do not match";
			}
		}
	}
	//password
	if(empty(trim($_POST['password']))){
		$password_err = "Input Password";
	}
	elseif (strlen(trim($_POST['password']))<6) {
		$password_err = "Password must be atleast 6 charaters";
	}
	else{
		$password = trim($_POST['password']);
	}
	//password2
	if(empty(trim($_POST['password2']))){
		$password2_err = "Repeat Password";
	}else{
		if(empty($password_err) && empty($password2_err)){
			$password2 = trim($_POST['password2']);
			if($password != $password2){
				$password2_err = "Password do not match";
			}
		}
	}
	//email
	if(empty(trim($_POST['email']))){
		$email_err = "Input Email Address";
	}else{
		 $email = trim($_POST['email']);
	}
	//email2
	if(empty(trim($_POST['email2']))){
		$email2_err = "Repeat Email";
	}else{
		if(empty($email_err) && empty($email2_err)){
			$email2 = trim($_POST['email2']);
			if($email != $email2){
				$email2_err = "Email do not match";
			}
		}
	}

//validation
	if(empty($firstname_err) && empty($lastname_err) && empty($username2_err) && empty($username2_err) && 
		empty($password_err) && empty($password2_err) && empty($email_err) && empty($email2_err)){
		$birthday=trim($_POST['day'])."/".trim($_POST['month'])."/".trim($_POST['year']);
		$gender=trim($_POST['gender']);
		$number=trim($_POST['number']);
		$profile_picture = trim($_POST['profile_picture']);
		$cover_picture = trim($_POST['cover_picture']);
		$sql = 'INSERT INTO user(firstname, lastname,username, birthday, gender, num, email, password,profile_picture,cover_picture) VALUES(?,?,?,?,?,?,?,?,?,?)';
		if($stmt = mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt, 'ssssssssss', $param_firstname,$param_lastname,$param_username,$param_birthday, $param_gender,$param_num, $param_email, $hash_password, $param_pic, $param_cover);
			$param_firstname = $firstname;
			$param_lastname = $lastname;
			$param_username = $username;
			$param_birthday = $birthday;
			$param_gender = $gender;
			$param_num = $number;
			$param_email = $email;
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			$param_pic = $profile_picture;
			$param_cover = $cover_picture;
			if(mysqli_stmt_execute($stmt)){	
				header('Location:signin.php');
				die;
			}else{
				echo "Something went wrong".mysqli_stmt_error();
			}
		}
	}
 mysqli_close($link);
}
	
?> 
<!DOCTYPE html>
<html>

	<head>
		<title>Welcome  To Biobook - Sin up, Log in, Chat </title>
		<link rel="stylesheet" type="text/css" href="style/signup.css">
	</head>

<body>

	<div id="container">
		<div class="sign-in-form">
		<center>	
			<h1>Welcome to Biobook</h1>
		</center>

			<h2>Sign up</h2>
			<b>All fields are required.</b>
		<br />
		
		<fieldset class="sign-up-form-1">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>First name*</label></td>
					<td><label>Last name *</label></td>
				</tr>
				<tr>
					<p style="color:red;"><?php echo $firstname_err?></p>
					<td><input type="text" name="firstname" placeholder="Enter your firstname....." class="form-1" title="Enter your firstname" required /></td>
					<p style="color:red;"><?php echo $lastname_err?></p>
					<td><input type="text" name="lastname" placeholder="Enter your lastname....." class="form-1" title="Enter your lastname" required /></td>
				</tr>
				<tr>
					<td><label>User name*</label></td>
					<td><label>Repeat user name*</label></td>
				</tr>
				<tr>
					<p style="color:red;"><?php echo $username_err?></p>
					<td><input type="text" name="username" placeholder="Enter your username....." class="form-1" title="Enter your username" required /></td>
					<p style="color:red;"><?php echo $username2_err?></p>
					<td><input type="text" name="username2" class="form-1" title="Enter your username" required /></td>
				</tr>
				<tr>
					<td colspan="2">Note: No one can follow your username.</td>
				</tr>
			</table>
		</fieldset>
		
		<br />		
		
		<fieldset class="sign-up-form-1">
			<legend>Profile information</legend>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>Birthday</label></td>
					<td>
					<select name=day style="font-size:18px;" required>
					<?php

					$day=1;
					while($day<=31)
					  {
					  echo "<option> $day
					  </option>";
					  $day++;
					  }
					?>
					</select>
					<select name=month style="font-size:18px;" required>
						<option>January</option>
						<option>Febuary</option>
						<option>March</option>
						<option>April</option>
						<option>May</option>
						<option>June</option>
						<option>July</option>
						<option>August</option>
						<option>September</option>
						<option>October</option>
						<option>November</option>
						<option>December</option>
					</select>
					<select name=year style="font-size:18px;" required>
					<?php
					$year=1901;
					while($year<=2014)
					  {
					  echo "<option> $year
					  </option>";
					  $year++;
					  }
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td><label>Gender</label></td>
					<td>
					<label>Male</label><input type="radio" name="gender" value="male" required />
					<label>Female</label><input type="radio" name="gender" value="female" required />
					</td>
				</tr>
				<tr>
					<td><label>Mobile number*</label></td>
					<td><input type="text" name="number" placeholder="09...." maxlength="13" class="form-1" title="Enter your mobile number" required /></td>
				</tr>
			</table>
		</fieldset>
		
		<br />
		
		<fieldset class="sign-up-form-1">
			<legend>Log in information*</legend>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td><label>Your email address*</label></td>
					<td><label>Repeat email *</label></td>
				</tr>
				<tr>
					<p style="color:red;"><?php echo $email_err?></p>
					<td><input type="text" name="email" placeholder="Enter your email address....." class="form-1" title="Enter your firstname" required /></td>
					<p style="color:red;"><?php echo $email2_err?></p>
					<td><input type="text" name="email2" class="form-1" title="Enter your lastname" required /></td>
				</tr>
				<tr>
					<td colspan="2">Note: no-one can see your email address.</td>
				</tr>
				<tr>
					<td><label>Password*</label></td>
					<td><label>Repeat password*</label></td>
				</tr>
				<tr>
					<p style="color:red;"><?php echo $password_err?></p>
					<td><input type="password" name="password" placeholder="Enter your password....." class="form-1" title="Enter your username" required /></td>
					<p style="color:red;"><?php echo $password2_err?></p>
					<td><input type="password" name="password2" class="form-1" title="Enter your username" required /></td>
				</tr>
				<tr>
					<td colspan="2">Note: no-one else can see your password.</td>
				</tr>
				
			</table>
		</fieldset>
		
		<br />
		
			<strong>Yes, I have read and I accept the <a href="#">Biobook Terms of Use</a> and the <a href="#">Biobook Privacy Statement</a></strong>
			
		<br />
		<br />
					<input type="submit" name="submit" value="I Agree - Continue" class="btn-sign-in" title="Log in" />
		</form>
		
		</div>
	</div>

</body>

</html>