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
                $s_id = $_REQUEST['id'];
    
                if(isset($_GET['id']) && !empty($_GET['id'])){
                    if ($s_rating <= 5 && $s_rating >= 1 && is_numeric($s_rating)) { //Checking for invalid rating type
                        $check_stmt = $conn->prepare("SELECT * FROM ratings WHERE username = ? AND song = ? AND artist=? AND id=?");
                        // Preparing statement
                        // $stmt = $conn->prepare("UPDATE ratings SET artist = ?, song = ?, rating = ? WHERE id = ?");
                        if ($stmt) {
                            // Bind parameters and execute
                            mysqli_stmt_bind_param($stmt, "ssii", $s_artist, $s_song, $s_rating, $s_id);
                            $result = mysqli_stmt_execute($stmt);
                            // If successful, redirect to main page, else show error
                            if ($result) {                        
                                header("Location: index.php");
                                exit();
                            } else {
                                $out_value = "Error: " . $conn->error;
                            }
                            // Close statment

                        } else {
                            $out_value = "Error: Could not execute prepared statement ";
                        }

                    } else {
                    $out_value = "Error: Rating must be between 1 and 5.";
                    mysqli_stmt_close($stmt);
                }

                    // if(!empty($s_song) && !empty($s_artist) && !empty($s_rating)){
                    //     if ($s_rating <= 5 && $s_rating >= 1 && is_numeric($s_rating)) { //Checking for invalid rating type
                    //         $check_stmt = $conn->prepare("SELECT * FROM ratings WHERE username = ? AND song = ? AND artist=? AND id=?");
                    //         // $stmt = $conn->prepare("UPDATE ratings SET rating = ? WHERE username = ? AND song = ? AND artist = ?");
                        
                    //         if ($check_stmt) {
                    //             mysqli_stmt_bind_param($check_stmt, "sssi", $s_username, $s_song, $s_artist, $s_id);
                    //             mysqli_stmt_execute($check_stmt);
                    //             mysqli_stmt_store_result($check_stmt);
    
                    //             if (mysqli_stmt_num_rows($check_stmt) > 1) {
                    //                 // The user has the same song already rated in database
                    //                 $out_value = "Error: You have already rated this song.";
                    //             } else {
                    //                 The user has not rated this song yet, so update
                    //                 $update_stmt = $conn->prepare("UPDATE ratings SET song = ?, artist = ?, rating = ? WHERE id = ?");
                                        
                    //                 if ($update_stmt) {
                    //                     mysqli_stmt_bind_param($update_stmt, "ssii", $s_song, $s_artist, $s_rating, $s_id);
                    //                     $result = mysqli_stmt_execute($update_stmt);
                                            
                    //                     if ($result) {
                    //                         header("Location: index.php");
                    //                     } else {
                    //                         $out_value = "Error: " . $conn->error;
                    //                     }
                    //                     mysqli_stmt_close($update_stmt);
                    //                 } else {
                    //                     $out_value = "Error: Could not execute the update prepared statement";
                    //                 }
                    //             }
                    //             mysqli_stmt_close($check_stmt);
                    //         } else {
                    //             $out_value = "Error: Could not execute prepared statement ";
                    //         }
                    //     } else {
                    //         $out_value = "Error: Rating must be between 1 and 5.";
                    //     }
                    // } else {
                    //     $out_value = "Error: Not all fields filled out";
                    // }
                }
            }
    
            // Get ID
            $s_id = $_GET['id'];


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
        <form method="POST" action="">
            Artist <input type="text" name="artist" placeholder="Enter the artist" value="<?php echo $current_artist; ?>"/><br>
            Song <input type="text" name="song" placeholder="Enter the song title" value="<?php echo $current_song; ?>"/><br>
            Rating <input type="number" name="rating" placeholder="Enter your rating" value="<?php echo $current_rating; ?>"/><br>
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
