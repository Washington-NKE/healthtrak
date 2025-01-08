<?php
require_once '../config/database.php';

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $details = isset($_POST['details']) ? $_POST['details'] : '';

    // Validate required fields
    if (!empty($first_name) && !empty($last_name) && !empty($email)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO queries (first_name, last_name, email, phone, details) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $details);

        $stmt->close();
    } else {
        echo "Error: Please fill in all required fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Query Form</title>
    <style>
        /* Resetting some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container styling */
.container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
    padding: 20px;
    text-align: left;
}

/* Header */
.container h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 16px;
    color: #333;
    display: block;
    margin-bottom: 8px;
}

/* Input & Textarea styling */
input[type="text"],
input[type="tel"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
}

/* Checkbox Styling */
input[type="checkbox"] {
    margin-right: 10px;
}

/* Submit button styling */
button {
    background-color: #0365dc;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

button:hover {
    background-color: #45a049;
}

button:active {
    background-color: #397c39;
}

/* Styling for disabled input */
input[disabled] {
    background-color: #f9f9f9;
    cursor: not-allowed;
}

/* Placeholder Text */
input::placeholder,
textarea::placeholder {
    color: #aaa;
}

    </style>
  </head>
  <body>
    <div class="container">
      <form action="addition1.php" method="POST">
        <h2>Query Form</h2>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($first_name)) : ?>
    <p style="color: green;">Query sent successfully!</p>
<?php endif; ?>


      <!-- Completed Dosage Checkbox -->
      <div class="form-group">
        <label><i>Personal Details</i></label>
        <label for="first_name">🙎‍♂️First Name</label>
        <input type="text" id="first_name" placeholder="Enter First Name" name="first_name" required />
        <label for="last_name">🙎‍♂️Last Name</label>
        <input type="text" id="last_name" placeholder="Enter Last Name" name="last_name" required />
        <label for="email">📧Email</label>
        <input type="text" id="email" placeholder="Enter Email" name="email" required />
        <label for="phone">📞Phone Number</label>
        <input type="tel" id="phone" placeholder="Enter Phone Number" name="phone" required />
        
      </div>

      <!-- Comments Section -->
      <div class="form-group">
        <label for="details">📝Subject and Detailed Description</label>
        <textarea
          id="details"
          rows="4"
          placeholder="Enter your query details here starting with the subject title"
         name="details" required></textarea>
      </div>
      <button type="submit">Submit</button>
      </form>
    </div>
  </body>
</html>
