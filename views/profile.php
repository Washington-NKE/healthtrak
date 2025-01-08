<?php
session_start();

require_once '../config/database.php';

$email = $_SESSION['user'];
$userId = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_picture']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = "profile_" . $userId . "." . $filetype;
            $upload_path = "../storage/profiles/" . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                $profile_picture = $upload_path;
                
                // Update profile picture in database
                $query = "UPDATE users SET profile = ? WHERE email = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $profile_picture, $email);
                $stmt->execute();
            }
        }
    }
    
    // Update user information
    $query = "UPDATE users SET 
              first_name = ?,
              last_name = ?,
              email = ?,
              phone = ?
              WHERE email = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $email);
    
    if ($stmt->execute()) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}

// Get current user data
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-header i {
            font-size: 24px;
            margin-right: 10px;
            color: #2196F3;
        }

        .profile-header h1 {
            margin: 0;
            color: #333;
        }

        .close-icon {
            position: fixed; /* Keeps the icon fixed on the screen */
            top: 20px;       /* Distance from the top of the page */
            right: 20px;     /* Distance from the right side of the page */
            font-size: 24px; /* Adjust icon size */
            color: #6c757d;  /* Icon color */
        }

        .close-icon a {
            text-decoration: none; /* Removes underline from link */
            font-size: 40px;      
        }

        .close-icon a:hover i {
            color: #DC143C; /* Darker color on hover */
            cursor: pointer;
        }

        .profile-picture {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2196F3;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn-save {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-save:hover {
            background-color: #1976D2;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        .alert-error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <i class='bx bx-user'></i>
            <h1>My Profile</h1>

            <div class="close-icon">
            <a href="dashboard.php">
                <i class="bx bx-x"></i>
            </a>
        </div>
            </div>
        

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="profile-picture">
                <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : '../storage/profiles/user.png'; ?>" 
                     alt="Profile Picture">
                <div class="form-group">
                    <label for="profile_picture">Change Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" 
                       value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" 
                       value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone"><?php echo htmlspecialchars($user['phone']); ?></input>
            </div>

            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</body>
</html>