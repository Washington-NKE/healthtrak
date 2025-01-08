<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    die();
}

    if(isset($_POST['submit'])){

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $contact_number = $_POST['contact_number'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $errors = array();

        if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($password2) || empty($date_of_birth) || empty($gender) || empty($contact_number)){
            array_push($errors, "All fields are required!");
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Invalid email address!");
        }
        if($password < 8 || $password2 < 8){
            array_push($errors, "Password must be at least 8 characters!");
        }
        if($password != $password2){
            array_push($errors, "Passwords do not match!");
        }

        require_once '../config/database.php';

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            array_push($errors, "Email already exists!");
        }

        if(count($errors) > 0){
            foreach($errors as $key => $error){
                echo "<div class='chip red'>" . $error . "</div>";
            }
        }else{
           

            $sql = "INSERT INTO users  (first_name, last_name, email, password, dob, gender,role , phone) 
                    VALUES (?, ?, ?, ?, ?, ?,'patient', ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $first_name, $last_name, $email, $password_hash, $date_of_birth, $gender, $contact_number);
            
            if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        
        $_SESSION['user'] = $email; 
        $_SESSION['role'] = 'patient';
        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit(); // Ensure no further code is executed
            } else {
                echo "Registration failed: " . $conn->error;
            }
        }
    }
?>

<section class="container grey-text">
    <h4 class="center">REGISTRATION</h4>
    <form class="white" action="register.php" method="POST">
       <label for="first_name"> First Name</label>
        <input id="first_name" type="text" name="first_name" class="validate">
        <label for="last_name"> Last Name</label>
        <input id="last_name" type="text" name="last_name" class="validate">
        <label for="email"> Email</label>
        <input id="email" type="email" name="email" class="validate">
        <label> Password</label>
        <input type="password" name="password">
        <label> Confirm Password</label>
        <input type="password" name="password2">
        <label> Date of Birth</label>
        <input type="date" name="date_of_birth">
        <label> Gender:</label>
        <p>
      <label>
        <input name="gender" type="radio" value="Male" checked />
        <span>Male</span>
      </label>
    </p>
    <p>
      <label>
        <input name="gender" type="radio" value="Female"/>
        <span>Female</span>
      </label>
    </p>
        <label> Contact Number</label>
        <input type="text" name="contact_number">
        <div class="center">
            <input type="submit" name="submit" value="Register" class="btn brand z-depth-0">
        </div>

        <div><p>Already have an account? <a href="login.php">Log in</a></p></div>
    </form>
  
</section>

<?php include '../config/footer.php'; ?>
</html>