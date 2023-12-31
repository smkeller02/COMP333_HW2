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

        <title>MusicUnited Login</title>

    </head>

    <body>
        <h1>
            Welcome to MusicUnited!
        </h1>

        <h2>
            Login below:
        </h2>
        <?php
            // Setting up variables
            //$servername = "localhost";
            //$username = "root";
            //$password = "";
            //$dbname = "music_db";
            $servername = "sql313.infinityfree.com";
            $username = "if0_35135068";
            $password = "WQFLcEyVvOrKu";
            $dbname = "if0_35135068_music_db";

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

                // Check that the user entered data in the form.
                if(!empty($s_username) && !empty($s_password)){
                    // If so, prepare SQL query with the data to query the database.
                    $stmt = mysqli_prepare($conn,"SELECT password FROM users WHERE username = ?");

                    if ($stmt) {
                        // Bind parameters and execute query
                        mysqli_stmt_bind_param($stmt, "s", $s_username);
                        $result = mysqli_stmt_execute($stmt);
                        // mysqli_query performs a query against the database.
                        mysqli_stmt_store_result($stmt);
                        $row_num = mysqli_stmt_num_rows($stmt);
                        //If username and password found, take user to main page, otherwise give incorrect username/pw
                        if($row_num > 0) {
                            mysqli_stmt_bind_result($stmt, $hashed_password);
                            mysqli_stmt_fetch($stmt);
                            if(password_verify($s_password, $hashed_password)){
                                session_start();
                                $_SESSION['username'] = $s_username;
                                header("Location: ../index.php");
                            } else {
                                $out_value = "Incorrect username and/or password.";
                            }
                        } else {
                            $out_value = "Incorrect username and/or password.";
                        }
                        // Close statement
                        mysqli_stmt_close($stmt);
                    } else {
                        $out_value = "Error: Could not execute prepared statement";
                    }
                } else {
                    $out_value = "Error: Not all fields filled out";
                }
            }

            // Close SQL connection.
            $conn->close();
        ?>

        <!-- Log in HTML form for users already in database -->
        <form method="POST" action="">
            Username: <input type="text" name="username" placeholder="Enter username" /><br>
            Password: <input type="text" name="password" placeholder="Enter password" /><br>
            <input type="submit" name="submit" value="Submit"/>
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

        <!-- Button for if new user who wants to make an account -->
        <p style="padding-top: 20px">
            Don't have an account? <br>
            <a href="signup.php">Sign up here</a>
        </p>

    </body>
</html>
