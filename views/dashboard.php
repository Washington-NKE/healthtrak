<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

// Fetch user details with role
$email = $_SESSION['user'];
$user_query = "SELECT user_id, last_name, username, role, email FROM users  WHERE email = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

$is_doctor = ($user['role'] === 'doctor');

// Fetch additional details based on role
if ($is_doctor) {    
    // Fetch today's appointments
    $today = date('Y-m-d');
    $appointments_query = "SELECT COUNT(*) as today_count FROM appointments WHERE doctor_id = ? AND DATE(appointment_time) = ?";
    $stmt = $conn->prepare($appointments_query);
    $stmt->bind_param("is", $user['user_id'], $today);
    $stmt->execute();
    $appointments_result = $stmt->get_result();
    $appointments = $appointments_result->fetch_assoc();
} else {
    $patient_query = "SELECT p.* FROM patients p WHERE p.user_id = ?";
    $stmt = $conn->prepare($patient_query);
    $stmt->bind_param("i", $user['user_id']);
    $stmt->execute();
    $detail_result = $stmt->get_result();
    $details = $detail_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

    <?php include '../config/header.php'; ?>

            <ul  class="right hide-on-med-and-down">
                <li><a href="../app/index.php" class="btn">Home</a></li>
                <li><a href="logout.php" class="btn">Logout</a></li>
                <li><a href="settings.php" class="settings">
                    <i class='bx bx-cog'></i>
                </a>
            </li>
                <li>
                    <a href="profile.php" class="profile">
                        <div class="profile-picture">
                            <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : '../storage/profiles/user.png'; ?>" 
                     alt="Profile Picture">
                        </div>
                    </a>
                </li>
            </ul>

<!-- Mobile Menu Icon -->
<div id="mySidebar" class="sidebar">
    <a href="../app/index.php"><i class='bx bx-home'></i>Home</a>
    <a href="settings.php"><i class='bx bx-cog'></i>Settings</a>
    <a href="profile.php"><i class='bx bx-user'></i>Profile</a>
    <a href="logout.php"><i class='bx bx-log-out'></i>Logout</a>
</div>

<div id="main">
    <a href="#" class="dropdown-trigger hide-on-large-only">
        <img src="../assets/bx-menu.svg" alt="Menu Icon" class="menu-icon" onclick="toggleSidebar()">
    </a>
    <!-- Your main content goes here -->
</div>
</div>
    </nav>


    <div class="dashboard">
        <div class="welcome">
            <?php if ($is_doctor): ?>
                <h1>🩺Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>

                <p>Your dedication to healing and care makes a difference every day. Here's your dashboard to help you manage appointments, patients, and prescriptions seamlessly. Let's make today impactful for those who rely on you. 💙</p>
            <?php else: ?>
                <h1>🌼Welcome, <?= htmlspecialchars($user['last_name']) ?>!</h1>

                <p>Your health is our priority. This is your space to manage appointments, view prescriptions, and connect with your doctor with ease. Let’s work together towards a healthier you! 💚</p>
            <?php endif; ?>
        </div>

        <div class="grid">
            <?php if ($is_doctor): ?>
                <!-- Doctor-specific cards -->
                <div class="card">
                    <h3>Today's Appointments</h3>
                    <div class="stats"><?= $appointments['today_count'] ?></div>
                    <a href="appointments.php" class="btn">View Schedule</a>
                </div>

                <div class="card">
                    <h3>Patient Management</h3>
                    <p>Access your patient records and manage appointments</p>
                    <a href="patients.php" class="btn">Manage Patients</a>
                </div>

                <div class="card">
                    <h3>Prescriptions</h3>
                    <p>Write and manage patient prescriptions</p>
                    <a href="prescriptions.php" class="btn">Manage Prescriptions</a>
                </div>

                <div class="card">
                    <h3>Messages</h3>
                    <p>Check and respond to patient inquiries</p>
                    <a href="messages.php" class="btn">View Messages</a>
                </div>
            <?php else: ?>
                <!-- Patient-specific cards -->
                <div class="card">
                    <h3>Upcoming Appointments</h3>
                    <p>Schedule and manage your appointments</p>
                    <a href="appointments.php" class="btn">Schedule Appointment</a>
                </div>

                <div class="card">
                    <h3>My Prescriptions</h3>
                    <p>View your current prescriptions and history</p>
                    <a href="prescriptions.php" class="btn">View Prescriptions</a>
                </div>

                <div class="card">
                    <h3>Medical Records</h3>
                    <p>Access your medical history and reports</p>
                    <a href="records.php" class="btn">View Records</a>
                </div>

                <div class="card">
                    <h3>Contact Doctor</h3>
                    <p>Send messages to your healthcare provider</p>
                    <a href="messages.php" class="btn">Send Message</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../config/footer.php'; ?>

    <script src="../public/healthtrak.js"></script>
</body>
</html>