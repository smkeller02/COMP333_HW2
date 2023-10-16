<!--
    COMP333: Software Engineering

    Sydney Keller (smkeller@wesleyan.edu)
    Minji Woo (mwoo@wesleyan.edu)
-->
<?php
    // Start session
    session_start();
?>
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
        <meta name="description" content="Music rating web app delete your rating page"/>

        <title>MusicUnited Rating Delete Page</title>
    </head>

    <body>
        <!-- Logged in message -->
        <p style="text-align: left;">
            You are logged in as user: 
            <?php 
                echo $_SESSION['username']; 
            ?>
            </br></br><a href="../signup,login,out/logout.php">Log Out</a>
        </p>

        <h1>
            Delete Rating
        </h1>

        <p>
            Are you sure you want to delete this rating?
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


            if (isset($_POST["submit"])) {
                $s_id = $_REQUEST['id'];
                
                // Prepare deletion statement
                $stmt = $conn->prepare("DELETE FROM ratings WHERE id = ?");
            
                if ($stmt) {
                    // Execute prepared query and bind output of prepared statement to variables
                    mysqli_stmt_bind_param($stmt, "i", $s_id);
                    $result = mysqli_stmt_execute($stmt);
                    // Send user back to main page if statement executed correctly, else show error
                    if ($result) {   
                        header("Location: ../index.php");
                    } else {
                        $out_value = "Error: " . $conn->error;
                    }
                    // Statement close
                    mysqli_stmt_close($stmt);
                } else {
                    $out_value = "Error: Could not execute prepared statement ";
                }
            }

            // Close SQL connection
            $conn->close();
        ?>

        <!-- Log in HTML form for users already in database -->
        <form method="POST" action="">
            <input type="submit" name="submit" value="Yes"/>
            <p>
                <a href="../index.php">No</a>
            </p>
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
