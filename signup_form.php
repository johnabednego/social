<?php require_once'session.php';?>
<?php
	 require_once'database.php';
	 $firstname = $lastname = $username = $username2 = $password = $password2 = $email = $email2 = "";
	 $firstname_err = $lastname_err = $username_err = $username2_err = $password_err = $password2_err =  $email_err=  $email2_err = "";
	
	if ($_SERVER['REQUEST_METHOD'] =='POST')
	{
	
		
		
		
		$birthday=trim($_POST['day'])."/".trim($_POST['month'])."/".trim($_POST['year']);
		$gender=trim($_POST['gender']);
		$number=trim($_POST['number']);
		
		
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
		$username_err = "Username2 must contain only a-z,A-Z,0-9 or _";
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
		$username2_err = "Input Username2";
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
		$sql = 'INSERT INTO user(firtname, lastname,username, birthday, gender, num, email, password) VALUES(?,?,?,?,?,?,?,?)';
		if($stmt = mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt, 'sssisiss', $param_firstname,$param_lastname,$param_username,$param_birthday, $param_gender,$param_num, $param_email, $hash_password);
			$param_firstname = $firstname;
			$param_lastname = $lastname;
			$param_username = $username;
			$param_birthday = $birthday;
			$param_gender = $gender;
			$param_num = $number;
			$param_email = $email;
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			if(mysqli_stmt_execute($stmt)){	
				header('Location: signin.php');
				die;
			}else{
				echo "Something went wrong".mysqli_stmt_error();
			}
		}
	}

}
	
?>