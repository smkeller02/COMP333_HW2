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
            <a href="../signup,login,out/logout.php">Log Out</a>
        </p>

        <h1>
            Update Rating
        </h1>

        <p>
            Update your ratings here:
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
                $s_id = $_REQUEST['id'];
    
                // Check that the user entered data in the form.
                if (!empty($s_artist) && !empty($s_song) && !empty($s_rating)) {
                    if ($s_rating <= 5 && $s_rating >= 1 && is_numeric($s_rating)) { //Checking for invalid rating type
                        // Check that user isnt updating their artist and song to an artist and song they have already rated under a different ID
                        $check_duplicate_stmt = mysqli_prepare($conn, "SELECT id FROM ratings WHERE username = ? AND artist = ? AND song = ?");
                        mysqli_stmt_bind_param($check_duplicate_stmt, "sss", $s_username, $s_artist, $s_song);
                        mysqli_stmt_execute($check_duplicate_stmt);
                        // Make $duplicate_id = -1 which is an impossible result for the table and then bind result of $check_duplicate_stmt to $duplicate_id
                        $duplicate_id = -1;
                        // Bind results and fetch
                        mysqli_stmt_bind_result($check_duplicate_stmt, $duplicate_id);
                        mysqli_stmt_fetch($check_duplicate_stmt);
                        // Close the statement
                        mysqli_stmt_close($check_duplicate_stmt);
                        // Check whether $duplicate_id = -1 OR if it = $s_id. If so, update rating since there is no duplicate found, else show appropriate error message
                        if ($duplicate_id == -1 || $duplicate_id == $s_id) {
                            // Update the rating
                            $stmt = mysqli_prepare($conn, "UPDATE ratings SET artist = ?, song = ?, rating = ? WHERE id = ?");
                            mysqli_stmt_bind_param($stmt, "ssii", $s_artist, $s_song, $s_rating, $s_id);
                            $result = mysqli_stmt_execute($stmt);
                            if ($result) {
                                // Send user to main page if successful update
                                header("Location: ../index.php");
                            } else {
                                $out_value = "Error: " . mysqli_error($conn);
                            }
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            $out_value = "Error: You've already rated this artist and song under a different ID.";
                        }
                    } else {
                        $out_value = "Error: Rating must be between 1 and 5.";
                    }
                } else {
                    $out_value = "Error: Not all fields filled out";
                }
            }     

        // Auto-fill form
            // Get ID
            $s_id = $_GET['id'];

            // Parametricize and prepare statment
            $stmt2 = mysqli_prepare($conn, "SELECT username, artist, song, rating FROM ratings WHERE id =?");

            if ($stmt2) {
                // Execute prepared query and bind output of prepared statement to variables
                mysqli_stmt_bind_param($stmt2, "i", $s_id);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $username, $current_artist, $current_song, $current_rating);
                
                // Fetch result of prepared statement and check if there are any results for the given ID, else show error
                if (mysqli_stmt_fetch($stmt2)) {
                } else {
                    echo "No data found for ID: $s_id";
                }
                // Close the statement
                mysqli_stmt_close($stmt2);
            } else {
                echo "Error: Could not execute prepared statekemtn ";
            }

            // Close SQL connection.
            $conn->close();
        ?>

        <!-- Log in HTML form for users already in database -->
        <form method="POST" action="">
            Artist <input type="text" name="artist" placeholder="Enter the artist" value="<?php echo $current_artist; ?>"/><br>
            Song <input type="text" name="song" placeholder="Enter the song title" value="<?php echo $current_song; ?>"/><br>
            Rating <input type="number" name="rating" placeholder="Enter your rating" value="<?php echo $current_rating; ?>"/><br>
            <input type="submit" name="submit" value="Submit"/>
            <p>
                <a href="../index.php">Cancel</a>
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
