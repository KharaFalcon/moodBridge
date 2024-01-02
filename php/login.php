<?php

/*
    STEPS WE NEED TO TAKE...
    
    1.  Build Login HTML form
    2.  Check if form has been submitted
    3.  Validate form data
    4.  Add form data to variables
    5.  Connect to database
    6.  Query the database for username submitted in the form
    6.1     If no entries: show error message
    7.  Store basic user data from database in variables
    8.  Verify stored hashed password with the one submitted in the form
    8.1     If invalid: show error message
    9.  Start a session & create session variables
    10. Redirect to a "profile page"
    10.1    Provide link to "logout" page
    10.2    Add cookie clear to logout page
    10.3    Provide link to log back include
    11. Close the MySQL connection
    
*/

if (isset($_POST['login'])) {

    // build a function to validate data
    function validateFormData($formData)
    {
        $formData = trim(stripslashes(htmlspecialchars($formData)));
        return $formData;
    }

    // create variables
    // wrap the data with our function
    $formUser = validateFormData($_POST['username']);
    $formPass = validateFormData($_POST['password']);

    // connect to database
    include('connection.php');

    // create SQL query
    $query = "SELECT username, email, password FROM user WHERE username='$formUser'";

    // store the result
    $result = mysqli_query($conn, $query);

    // verify if result is returned
    if (mysqli_num_rows($result) > 0) {

        // store basic user data in variables
        while ($row = mysqli_fetch_assoc($result)) {
            $user       = $row['username'];
            $email      = $row['email'];
            $hashedPass = $row['password'];
        }

        // verify hashed password with the typed password
        if (password_verify($formPass, $hashedPass)) {

            // correct login details!
            // start the session
            session_start();

            // store data in SESSION variables
            $_SESSION['loggedInUser'] = $user;
            $_SESSION['loggedInEmail'] = $email;

            header("Location: ../moodmeter.html");
        } else { // hashed password didn't verify

            // error message
            $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.</div>";
        }
    } else { // there are no results in database

        $loginError = "<div class='alert alert-danger'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    // close the mysql connection
    mysqli_close($conn);
}

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <p class="lead">Use this form to log in to your account</p>

        <?php echo $loginError; ?>

        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="login-username" class="sr-only">Username</label>
                <input type="text" class="form-control" id="login-username" placeholder="username" name="username">
            </div>
            <div class="form-group">
                <label for="login-password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
            </div>
            <button type="submit" class="btn btn-default" name="login">Login!</button>

        </form>


    </div>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>