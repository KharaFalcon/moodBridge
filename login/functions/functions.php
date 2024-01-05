<?php



/****************helper functions ********************/



function clean($string) {

//The htmlentities() function converts characters to HTML entities.
return htmlentities($string);


}



function redirect($location){


return header("Location: {$location}");

}


function set_message($message) {


	if(!empty($message)){


		$_SESSION['message'] = $message;

	}else {

		$message = "";

	}


}



function display_message(){


	if(isset($_SESSION['message'])) {


		echo $_SESSION['message'];

		unset($_SESSION['message']);

	}



}


//make secure and use to validate function 
function token_generator(){

//set to session 
$token = $_SESSION['token'] =  md5(uniqid(mt_rand(), true));

return $token;


}


function validation_errors($error_message) {
//adds css to error messages 
$error_message = <<<DELIMITER

<div class="alert alert-danger alert-dismissible" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	<strong>Warning!</strong> $error_message
 </div>
DELIMITER;

return $error_message;
		




}



function email_exists($email) {

	$sql = "SELECT id FROM users WHERE email = '$email'";

	$result = query($sql);

	if(row_count($result) == 1 ) {

		return true;

	} else {


		return false;

	}



}



function username_exists($username) {

	$sql = "SELECT id FROM users WHERE username = '$username'";

	$result = query($sql);

	if(row_count($result) == 1 ) {

		return true;

	} else {


		return false;

	}



}


function send_email($email, $subject, $msg, $headers){


return mail($email, $subject, $msg, $headers);


}



/****************Validation functions ********************/



function validate_user_registration(){

	$errors = [];

	$min = 3;
	$max = 20;



	if($_SERVER['REQUEST_METHOD'] == "POST") {


		$first_name 		= clean($_POST['first_name']);
		$last_name 			= clean($_POST['last_name']);
		$username 		    = clean($_POST['username']);
		$email 				= clean($_POST['email']);
		$password			= clean($_POST['password']);
		$confirm_password	= clean($_POST['confirm_password']);


//Errors
		if(strlen($first_name) < $min) {

			$errors[] = "Your first name cannot be less than {$min} characters";

		}

		if(strlen($first_name) > $max) {

			$errors[] = "Your first name cannot be more than {$max} characters";

		}




		if(strlen($last_name) < $min) {

			$errors[] = "Your Last name cannot be less than {$min} characters";

		}


		if(strlen($last_name) > $max) {

			$errors[] = "Your Last name cannot be more than {$max} characters";

		}

		if(strlen($username) < $min) {

			$errors[] = "Your Username cannot be less than {$min} characters";

		}

		if(strlen($username) > $max) {

			$errors[] = "Your Username cannot be more than {$max} characters";

		}


		if(username_exists($username)){

			$errors[] = "Sorry that username is already is taken";

		}



		if(email_exists($email)){

			$errors[] = "Sorry that email already is registered";

		}




		if(strlen($email) < $min) {

			$errors[] = "Your email cannot be more than {$max} characters";

		}

		if($password !== $confirm_password) {

			$errors[] = "Your password fields do not match";

		}



		if(!empty($errors)) {

			foreach ($errors as $error) {

			echo validation_errors($error);

			
			}


		} else {


			if(register_user($first_name, $last_name, $username, $email, $password)) {



				set_message("<p class='bg-success text-center'>Account Activation is successful</p>");

				redirect("../../moodmeter.php");


			} else {


				set_message("<p class='bg-danger text-center'>Sorry we could not register the user</p>");

				redirect("index.php");

			}



		}



	} // post request 



} // function 

/****************Register user functions ********************/

function register_user($first_name, $last_name, $username, $email, $password) {
	//take in data 
	//escape data to prevent sql injection
	$first_name = escape($first_name);
	$last_name  = escape($last_name);
	$username   = escape($username);
	$email      = escape($email);
	$password   = escape($password);


//checks if email exists
	if(email_exists($email)) {


		return false;

//checks if username exists
	} else if (username_exists($username)) {

		return false;

	} else {
		//encrypts passowrd
		$password   = md5($password);
	
		//sql query to insert into database 
		$sql = "INSERT INTO users(first_name, last_name, username, email, password)";
		$sql.= " VALUES('$first_name','$last_name','$username','$email','$password')";
		$result = query($sql);
		confirm($result);

		return true;

	}



} 




 // function 

/****************Validate user login functions ********************/



function validate_user_login(){

	$errors = [];

	$min = 3;
	$max = 20;



	if($_SERVER['REQUEST_METHOD'] == "POST") {


		$email 		= clean($_POST['email']);
		$password	= clean($_POST['password']);
		$remember   = isset($_POST['remember']); //rememeber me part of login 




		if(empty($email)) {

			$errors[] = "Email field cannot be empty";

		}


		if(empty($password)) {

			$errors[] = "Password field cannot be empty";

		}



		if(!empty($errors)) {

				foreach ($errors as $error) {

				echo validation_errors($error);

				
				}


			} else {


				if(login_user($email, $password, $remember)) {

//redirects to admin 
					redirect("../../moodmeter.php");


				} else {


				echo validation_errors("Your credentials are not correct");		



				}



			}



	}


} // function 





/****************User login functions ********************/


	function login_user($email, $password, $remember) {

//selects the password from where the email matches
//active=1 means the account is active 
		$sql = "SELECT password, username, id FROM users WHERE email = '".escape($email)."'";

		$result = query($sql);

		if(row_count($result) == 1) {
//fetches the result 
			$row = fetch_array($result);

			$db_password = $row['password'];
			$username = $row['username'];

//return yes or no if it is able to match
			if(md5($password) === $db_password) {
//check if rememeber me button has been clicked 
				if($remember == "on") {
					//sets the cookie and holds cookie for a day 
					setcookie('email', $email, time() + 86400);

				}

				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;



				return true;

			} else {


				return false;
			}









			return true;

		} else {


			return false;



		}



	} // end of function



/****************logged in function ********************/



function logged_in(){
//sets the session and if set returns true
	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){


		return true;

	} else {


		return false;
	}
}






