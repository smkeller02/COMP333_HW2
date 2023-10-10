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
        <p>
        Sign Up Below!
        </p>

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
                if (!empty($s_username) && !empty($s_password)) {

                    //Making sure username isn't already taken
                    $check_username = "SELECT * FROM user_table WHERE username = '$s_username'";
                    $result = mysqli_query($conn, $check_username);

                    // get the post records
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];

                    // If username isn't taken and passwords match, continue - otherwise give appropriate notice
                    if (mysqli_num_rows($result) === 0 && $password === $password2) {

                        // database insert SQL code
                        $sql_query = "INSERT INTO user_table (username, password) VALUES ('$s_username', '$s_password')";
                        // insert in database
                        $result = mysqli_query($conn, $sql_query);

                        if ($result) {
                            header("Location: index.php");
                        } else {
                            echo "Error: " . $conn->error;;
                        }

                    } else if ($password !== $password2) {
                        $out_value = "Error: passwords don't match";
                    } else {
                        $out_value = "Username already taken. Please choose a different one.";
                    }

            } else {
                $out_value = "Please enter a username and password.";
            }

            // Close SQL connection.
            $conn->close();
            }
    ?>

     <!-- Sign up HTML form -->
     <form method="POST" action="signup.php">
            New Username: <input type="text" name="username" placeholder="Enter a username" /><br>
            New Password: <input type="text" name="password" placeholder="Enter a password" /><br>
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

    </body>
</html>


