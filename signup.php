<!--
    COMP333: Software Engineering

    Sydney Keller (smkeller@wesleyan.edu)
    Minji Woo (mwoo@wesleyan.edu)
-->
<!DOCTYPE html>

<!-- Setting the language -->
<html lang='en'>

    <!-- Basic info about page for browser, not displayed on website -->
    <head>
        <!-- Help the browser understand what characters to render by
            specifying a character set -->
        <meta charset="utf-8" />

        <!-- Setting viewport to be accessible on mobile and desktop -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Summary describing content on website for brower to use -->
        <meta name="description" content="Music rating web app log-in/rating page"/>

        <title>MusicUnited Sign Up</title>

        <!-- Linking CSS style sheet -->
        <link rel="stylesheet" href="style_sheet.css" />

    </head>

    <body>
        <h1>
            Welcome to MusicUnited!
        </h1>

        <h2>
            Sign Up Below!
        </h2>

        <?php
            // Setting up variables
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "music_db";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if(isset($_REQUEST["submit"])){
                // Variables for the output and the web form below.
                $out_value = "";
                $s_username = $_REQUEST['username'];
                $s_password = $_REQUEST['password'];
                $s_password2 = $_REQUEST['password2'];

                // Check that the user entered data in the form.
                if (!empty($s_username) && !empty($s_password) && !empty($s_password2)) {
                    // Making sure username isn't already taken
                    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
                    
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "s", $s_username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $row_num = mysqli_stmt_num_rows($stmt);
                        // Close statement
                        mysqli_stmt_close($stmt);
                        // If username isn't taken and passwords match, continue - otherwise give appropriate notice
                        if ($row_num === 0 && $s_password === $s_password2 && strlen($s_password) >= 10) {
                            // Database insert SQL code
                            $stmt2 = mysqli_prepare($conn, "INSERT INTO user (username, password) VALUES (?, ?)");
                            
                            if ($stmt2) {
                                // Bind variable
                                mysqli_stmt_bind_param($stmt2, "ss", $s_username, $s_password);
                                // Insert in database
                                mysqli_execute($stmt2);
                                // Close statement
                                mysqli_stmt_close($stmt2);
                                // Start session
                                session_start();
                                // Keep track of username in session
                                $_SESSION['username'] = $s_username;   
                                // Send user to main page
                                header("Location: index.php");
                            } else {
                                $out_value = "Error executing prepared statement 2";
                            }
                        } else if ($s_password !== $s_password2) {
                            $out_value = "Error: passwords don't match.";
                        } else if (strlen($s_password) < 10){
                            $out_value = "Error: Password isn't at least 10 characters long.";
                        } else {
                            $out_value = "Error: Username already taken. Please choose a different one.";
                        }
                    } else {
                        $out_value = "Error: Could not execute prepared statement";
                    }
            } else {
                $out_value = "Error: Not all fields filled out. Please enter a username and password.";
            }

            // Close SQL connection.
            $conn->close();
            }
    ?>

     <!-- Sign up HTML form -->
     <form method="POST" action="signup.php">
            New Username: <input type="text" name="username" placeholder="Enter a username" /><br>
            New Password (must be at least 10 characters long): <input type="text" name="password" placeholder="Enter a password" /><br>
            Re-Enter Password: <input type="text" name="password2" placeholder="Re-enter password" /><br>
            <input type="submit" name="submit" value="Sign Up"/>
            <!--
            Make sure that there is a value available for $out_value.
            If so, print to the screen.
            -->
            <p><?php
                if(!empty($out_value)){
                    echo $out_value;
                }
            ?></p>
    </form>

     <p>
        Already have an account? <br>
        <a href="login.php">Login here</a>
    </p>

    </body>
</html>


