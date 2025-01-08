
<?php

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once '../config/database.php';

    

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    

    if($stmt){
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    if($user){

        if(password_verify($password, $user['password'])){
            session_start();
            $_SESSION['user'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['user_id'];

            header("Location: dashboard.php");
            die();
        }else{
    
            echo "<div class='red-text center'>Incorrect password</div>";
        }

   }else{
    echo "<div class='red-text center'>User not found</div>";
   }     
    
}else{
    echo "<div class='red-text center'>Database error: " . $conn->error . "</div>";}

}

?>

<?php include '../config/header.php'; ?>

</div>
    </nav>

<section class="container grey-text">
    <h4 class="center">Login</h4>
    <form class="white" action="login.php" method="POST">
        <label>Email or Username</label>
        <input type="email" name="email">
        <label>Password</label>
        <input type="password" name="password">
        <div class="center">
            <input type="submit" name="submit" value="Login" class="btn brand z-depth-0">
        </div>

        <div><p>Not registered yet? <a href="register.php">Register</a></p></div>
    </form>
    
</section>

<?php include '../config/footer.php'; ?>
</html>