<!DOCTYPE html>

<html>
<head>
  <title> Metube Sign Up</title>
</head>

<body>
  <form action="" method="post">
    <p>
        <label for="username">Please Select a Username: </label><br>
        <input type="text" id = "username" name = "username" required><br>
        <label for="password">Please Select a Password: </label><br>
        <input type="password" id="password" name="password" required><br>

      <p>Please Select Your Gender:</p><br>
      <input type="radio" id="female" name="gender" value="Female" required>
      <label for="female">Female</label><br>

      <input type="radio" id="male" name="gender" value="Male" required>
      <label for="male">Male</label><br>

      <input type="radio" id="other" name="gender" value="Other" required>
      <label for="Female">Other</label><br>

      <br>

      <label for="fname"> First Name: </label>
      <input type="text" id="fname" name="fname" required><br>

      <label for="lname"> Last Name: </label>
      <input type="text" id="lname" name="lname" required><br>

      <br>

      <label for="birthday"> Birthday: </label>
      <input type="date" id="birthday" name="birthday" required>

      <br>

      <input type="submit" value="submit" name="submit">
      <input type="reset">

    </form>
  </body>

  <?php

    include 'configure.php';

    if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $birthday = $_POST['birthday'];

    $query = "SELECT * FROM user_info WHERE username = '$username'";
    $result = mysqli_query($conn,$query) or die ("Query error ".mysqli_error($conn)."\n");
    $num_rows = mysqli_num_rows($result);
    if($num_rows != 0){
      echo "Username $username is already taken\n";
    }

    else{
      //setting the session and entering the information then
      //going to homepage
      $query = "SELECT userID from user_info where username ='$username'";
      $result = mysqli_query($conn,$query) or die ("Query error".mysqli_error($conn)."\n");
      $_SESSION['userID'] = $result;
      $sql = "INSERT INTO user(username, password, gender, first_name, last_name, birthday)
      VALUES ('$username', '$password', '$gender', '$fname', '$lname', '$birthday')";

        if($conn->query($sql) == TRUE){
          echo"entered into user";
        }
  }
  }
  ?>
  </html>
