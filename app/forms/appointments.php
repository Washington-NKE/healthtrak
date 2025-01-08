<?php
// Include the database configuration
require_once '../../config/database.php';

// Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$date = $_POST['date'];
$department = $_POST['department'];
$doctor = $_POST['doctor'];
$message = $_POST['message'];

// Check if the user exists in the users table
$query = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// If the user exists, fetch the user ID and proceed to make an appointment
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
} else {
    // If the user does not exist, insert the user into the users and patients tables
    $password = $phone; // Use the phone number as the default password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $insert_user_query = "INSERT INTO users (username, password, email, gender, first_name, last_name, phone) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_user_query);
    $stmt->bind_param("sssssss", $first_name, $hashed_password, $email, $gender, $first_name, $last_name, $phone);
    $stmt->execute();

    // Get the user_id of the newly inserted user
    $user_id = $stmt->insert_id;

    // Insert into patients table
    $insert_patient_query = "INSERT INTO patients (user_id, medical_history, feedback) VALUES (?, '', '')";
    $stmt = $conn->prepare($insert_patient_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Now insert the appointment data into the appointments table
$insert_appointment_query = "INSERT INTO appointments (patient_id, doctor_id, appointment_time, reason) 
                             VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insert_appointment_query);

// Get doctor_id based on selected doctor
$doctor_id = null;
if ($doctor == "Doctor 1") {
    $doctor_id = 1;
} elseif ($doctor == "Doctor 2") {
    $doctor_id = 2;
} elseif ($doctor == "Doctor 3") {
    $doctor_id = 3;
}

// Get patient_id from the patients table
$get_patient_id_query = "SELECT patient_id FROM patients WHERE user_id = ?";
$stmt = $conn->prepare($get_patient_id_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$patient_result = $stmt->get_result();
$patient = $patient_result->fetch_assoc();
$patient_id = $patient['patient_id'];

// Bind parameters and execute
$stmt = $conn->prepare($insert_appointment_query);
$stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $message);
if ($stmt->execute()) {
    echo "Your appointment request has been sent successfully. Thank you!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
