<?php
// Start session to manage user data
session_start();

require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user']; // Assuming you store user_id in session
    
    // Get form data
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $dark_mode = isset($_POST['dark_mode']) ? 1 : 0;
    $language = $conn->real_escape_string($_POST['language']);
    $timezone = $conn->real_escape_string($_POST['timezone']);

    // Update settings in database
    $query = "UPDATE settings SET 
              email_notifications = ?, 
              dark_mode = ?,
              language = ?,
              timezone = ?
              WHERE email = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $email_notifications, $dark_mode, $language, $timezone, $email);
    
    if ($stmt->execute()) {
        $success_message = "Settings updated successfully!";
        header("Location: dashboard.php");
    } else {
        $error_message = "Error updating settings. Please try again.";
    }
}

// Get current settings
$email = $_SESSION['user'];
$query = "SELECT * FROM settings WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$settings = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Settings</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .settings-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .settings-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .settings-header i {
            font-size: 24px;
            margin-right: 10px;
            color: #2196F3;
        }

        .settings-header h1 {
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


        .settings-section {
            margin-bottom: 30px;
        }

        .settings-section h2 {
            color: #666;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .toggle-switch {
            display: flex;
            align-items: center;
        }

        .toggle-switch input[type="checkbox"] {
            margin-right: 10px;
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
    <div class="settings-container">
        <div class="settings-header">
            <i class='bx bx-cog'></i>
            <h1>Settings</h1>

        </div>
        <div class="close-icon">
    <a href="dashboard.php">
        <i class="bx bx-x"></i>
    </a>
</div>


        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
           
            <div class="settings-section">
                <h2>Notifications</h2>
                <div class="form-group toggle-switch">
                    <input type="checkbox" id="email_notifications" name="email_notifications" 
                           <?php echo ($settings['email_notifications'] ? 'checked' : ''); ?>>
                    <label for="email_notifications">Email Notifications</label>
                </div>
            </div>

            <div class="settings-section">
                <h2>Appearance</h2>
                <div class="form-group toggle-switch">
                    <input type="checkbox" id="dark_mode" name="dark_mode" 
                           <?php echo ($settings['dark_mode'] ? 'checked' : ''); ?>>
                    <label for="dark_mode">Dark Mode</label>
                </div>
            </div>

            <div class="settings-section">
                <h2>Regional</h2>
                <div class="form-group">
                    <label for="language">Language</label>
                    <select id="language" name="language">
                        <option value="en" <?php echo ($settings['language'] == 'en' ? 'selected' : ''); ?>>English</option>
                        <option value="es" <?php echo ($settings['language'] == 'es' ? 'selected' : ''); ?>>Spanish</option>
                        <option value="fr" <?php echo ($settings['language'] == 'fr' ? 'selected' : ''); ?>>French</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <select id="timezone" name="timezone">
                        <option value="UTC" <?php echo ($settings['timezone'] == 'UTC' ? 'selected' : ''); ?>>UTC</option>
                        <option value="America/New_York" <?php echo ($settings['timezone'] == 'America/New_York' ? 'selected' : ''); ?>>Eastern Time</option>
                        <option value="America/Chicago" <?php echo ($settings['timezone'] == 'America/Chicago' ? 'selected' : ''); ?>>Central Time</option>
                        <option value="America/Denver" <?php echo ($settings['timezone'] == 'America/Denver' ? 'selected' : ''); ?>>Mountain Time</option>
                        <option value="America/Los_Angeles" <?php echo ($settings['timezone'] == 'America/Los_Angeles' ? 'selected' : ''); ?>>Pacific Time</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</body>
</html>