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

        <!-- Linking CSS style sheet -->
        <link rel="stylesheet" href="style_sheet.css" />

    </head>

    <body>
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

                // Check that the user entered data in the form.
                if(!empty($s_username) && !empty($s_password)){
                    // If so, prepare SQL query with the data to query the database.
                    $sql_query = "SELECT * FROM user_table WHERE username = ('$s_username') AND password = ('$s_password')";
                    // Send the query and obtain the result.
                    // mysqli_query performs a query against the database.
                    $result = mysqli_query($conn, $sql_query);
                    $row = mysqli_fetch_assoc($result);
                    //If username and password found, take user to main page, otherwise give incorrect username/pw
                    if($row > 0) {
                        $out_value = "You have sucessfully logged in";
                        header("Location: main.php");
                        exit;
                    } else {
                        $out_value = "Incorrect username or password.";
                    }
                } else {
                    $out_value = "Username not found";
                }
            }

            // Close SQL connection.
            $conn->close();
        ?>

        <!-- Log in HTML form for users already in database -->
        <form method="GET" action="">
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
            Don't have an account?
        </p>
        <div><a href="signup.php">Sign up here</a></div>


    </body>
</html>
