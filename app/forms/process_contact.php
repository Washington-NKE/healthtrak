<?php
// Include database configuration
require_once '../../config/database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "Your message has been sent successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
}
?>
