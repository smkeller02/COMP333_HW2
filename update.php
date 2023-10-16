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
        <meta name="description" content="Music rating web app update rating page"/>

        <title>MusicUnited Update Ratings Page</title>
    </head>

    <body>
        <!-- Logged in message -->
        <p style="text-align: left;">
            You are logged in as user: 
            <?php 
                echo $_SESSION['username']; 
            ?>
            <a href="logout.php">Log Out</a>
        </p>

        <h1>
            Update Rating
        </h1>

        <p>
            Here you can update your ratings.
        </p>
        <p>
            Username: 
            <?php 
                echo $_SESSION['username']; 
            ?>
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


            if (isset($_REQUEST["submit"])) {
                $s_username = $_SESSION['username'];
                $s_artist = $_REQUEST['artist'];
                $s_song = $_REQUEST['song'];
                $s_rating = $_REQUEST['rating'];
            
                if ($s_rating <= 5 && $s_rating >= 1 && is_numeric($s_rating)) { //Checking for invalid rating type
                    // Preparing statement
                    $stmt = $conn->prepare("UPDATE ratings SET artist = ?, song = ?, rating = ? WHERE username = ?");
                    if ($stmt) {
                        // Bind parameters and execute
                        mysqli_stmt_bind_param($stmt, "ssis", $s_artist, $s_song, $s_rating, $s_username);
                        $result = mysqli_stmt_execute($stmt);
                        // If successful, redirect to main page, else show error
                        if ($result) {                        
                            header("Location: index.php");
                        } else {
                            $out_value = "Error: " . $conn->error;
                        }
                        // Close statment
                        mysqli_stmt_close($stmt);
                    } else {
                        $out_value = "Error: Could not execute prepared statement ";
                    }
                } else {
                    $out_value = "Error: Rating must be between 1 and 5.";
                }
            }

            // Get ID
            $s_id = $_REQUEST['id'];

            // Parametricize and prepare statment
            $stmt = mysqli_prepare($conn, "SELECT username, artist, song, rating FROM ratings WHERE id =?");

            if ($stmt) {
                // Execute prepared query and bind output of prepared statement to variables
                mysqli_stmt_bind_param($stmt, "i", $s_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $username, $current_artist, $current_song, $current_rating);
                
                // Fetch result of prepared statement and check if there are any results for the given ID, else show error
                if (mysqli_stmt_fetch($stmt)) {
                } else {
                    echo "No data found for ID: $s_id";
                }
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Could not execute prepared statekemtn ";
            }

            // Close SQL connection.
            $conn->close();
        ?>

        <!-- Log in HTML form for users already in database -->
        <form method="GET" action="">
            Artist <input type="text" name="artist" placeholder="Enter the artist" value="<?php echo $current_artist; ?>"/><br>
            Song <input type="text" name="song" placeholder="Enter the song title" value="<?php echo $current_song; ?>"/><br>
            Rating <input type="text" name="rating" placeholder="Enter your rating" value="<?php echo $current_rating; ?>"/><br>
            <input type="submit" name="submit" value="Submit"/>
            <p>
                <a href="index.php">Cancel</a>
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
