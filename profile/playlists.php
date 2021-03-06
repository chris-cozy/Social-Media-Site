<?php
session_start();
include 'connection.php';
include 'functions.php';
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Metube: Profile</title>
		<link rel="stylesheet" href="../styles.css">
    </head>
    <body>
        <header>
            <h2 class="text"><a href="../MeTube.php" class="text">MeTube<3</a></h2>
            <h3 class="text">
				<?php 
					$uid = $_SESSION['userID'];
					getName($uid, $conn);
				?>
			</h3>
        </header>
        <main>
          	<section>
				<div class="navbar">
					<nav>
						<ul class="text">
							<li><a href="user_profile.php" >Media</a></li>
							<li><a href="playlists.php" ><b>Playlists</b></a></li>
							<li><a href="friends.php" >Friends</a></li>
                  			<li><a href="about.php" >About</a></li>
							<li><a href="updateprofile.php">Update Profile</a></li>
              				<li><a href="upload.php">Upload</a></li>
                  			<li><a href="messages.php" >Messages</a></li>
						</ul>
					</nav>
				</div>
			</section>
          	<hr>
          	<section>
            	<div class="playlist">
              	<h2 class='text'> Playlists</h2>


            	<?php
            		$uid = $_SESSION['userID'];
                	$query = "SELECT * from user_playlists WHERE userID = '$uid'";
                	$result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
                	$numrows = mysqli_num_rows($result);

                	if($numrows == 0){
                  	echo "<p class='text'>You currently have no playlists</p>";
                	}

                	else{
                		//displaying all of the users playlists
                  		while($rows = mysqli_fetch_assoc($result)){
                    		$playlistname = $rows['playlist_name'];
		    				$playlistID = $rows['playlistID'];
		   					echo "<br>";
		    				echo "<a href='playlistmedia.php?pid=".$playlistID."&pname=".$playlistname."' class='text'> ".$playlistname." </a>";
		    				echo "<br>";
                  		}
                	}
				?>
            	</div>
         	</section>

          	<section>
            	<div class="playlistbar">
              		<h2 class='text'> Create Playlist</h2>
              			<form action = "" method = "post">
                			<p>
                			<label for "playlistname" class='text'>Playlist Name </label><br>
                			<input type="text" id = "playlistname" name = "playlistname"><br>

                			<input type="submit" value="Send" name="submit">
							<input type="reset">

							<h2 class='text'> Delete a Playlist</h2>
							<label for "playlistdelete" class='text'>What Playlist would you like to delete?</label><br>
                			<input type="text" id="playlistdelete" name="playlistdelete"><br>

                 			<input type="submit" value="Send" name="submitdelete">
							<input type="reset">

							<h2 class='text'> Rename a Playlist</h2>
							<label for "playlistold" class='text'>What Playlist would you like to rename?</label><br>
							<input type='text' id='playlistold' name="playlistold"><br>
							<label for'playlistnew' class='text'>What new name?</label><br>
							<input type='text' id='playlistnew'name="playlistnew"><br>
		  					<input type="submit" value="Send" name="submitrename">
                			<input type="reset">
						</form>
           
            			<?php
							//adding the new playlist to the database
							if(isset($_POST['submit'])){
								$userID = $_SESSION['userID'];
								$playlistname = $_POST['playlistname'];
						
								$query = "SELECT *  FROM user_playlists WHERE userID  = '$userID' and playlist_name = '$playlistname'";
								$result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
								$num_rows = mysqli_num_rows($result);
								if($num_rows != 0){
									echo "You already have a playlist by that name";
								}
								else{
									$query = "INSERT INTO user_playlists(userID, playlist_name) VALUES ('$userID', '$playlistname')";
									$result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
									unset($_POST['submit']);
									header("location:playlists.php");
								}
	      					}
						?>
						<?php
							if(isset($_POST['submitdelete'])){
								$userID = $_SESSION['userID'];
								$playlistname = $_POST['playlistdelete'];
										
								$query = "SELECT *  FROM user_playlists WHERE userID  = '$userID' and playlist_name = '$playlistname'";
								$result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
								$num_rows = mysqli_num_rows($result);
								if($num_rows == 0){
									echo "You do not have any playlists by that name";
								}
								else{
									$query = "SELECT * FROM user_playlists WHERE userID = '$userID' and playlist_name='$playlistname'";
									$result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
									$row = mysqli_fetch_assoc($result);
									$playlistID = $row['playlistID'];

									$query = "DELETE FROM user_playlists where userID='$userID' and playlistID='$playlistID'";
									$result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
										
									$query = "DELETE FROM media_playlists where  playlistID='$playlistID'";
									$result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
									
									unset($_POST['submitdelete']);
									header("Location:playlists.php");
								}
							}
						?>	

						<?php
							if(isset($_POST['submitrename'])){
								$userID = $_SESSION['userID'];
								$playlistname = $_POST['playlistold'];
								$newplaylistname = $_POST['playlistnew'];

								$query = "SELECT *  FROM user_playlists WHERE userID  = '$userID' and playlist_name = '$playlistname'";
								$result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
								$num_rows = mysqli_num_rows($result);
								if($num_rows == 0){
									echo "Playlist $playlistname does not exist";
								}
								else{
									$row = mysqli_fetch_assoc($result);
									$playlistID = $row['playlistID'];
									$query = "SELECT *  FROM user_playlists WHERE userID  = '$userID' and playlist_name = '$newplaylistname'";
									$result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
									$num_rows = mysqli_num_rows($result);
									if($num_rows != 0){
										echo "You already have a playlist called '.$newplaylistname.'";	
									}
									else{
										$query = "UPDATE user_playlists SET playlist_name = '$newplaylistname' where playlistID = '$playlistID'";
										$result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
										unset($_POST['submitrename']);
										header("Location:playlists.php");
									}
								}
							}
						?>
				</div>
			</section>
        </main>
    </body>
</html>
