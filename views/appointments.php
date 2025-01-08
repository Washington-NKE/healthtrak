<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$role = $_SESSION['role']; // 'doctor' or 'patient'
$user_id = $_SESSION['user_id'];

class AppointmentManager {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // Get all appointments for a doctor
    public function getDoctorAppointments($doctor_id) {
        $query = "SELECT 
                    appointments.*,
                    users.first_name as patient_name,
                    users.email as patient_email
                  FROM appointments 
                  JOIN users ON appointments.patient_id = users.user_id
                  WHERE appointments.doctor_id = ?
                  ORDER BY appointment_time DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get all appointments for a patient
    public function getPatientAppointments($patient_id) {
        $query = "SELECT 
                    appointments.*,
                    users.username as doctor_name
                  FROM appointments 
                  JOIN users ON appointments.doctor_id = users.user_id
                  WHERE appointments.patient_id = ?
                  ORDER BY appointment_time DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Create new appointment
    public function createAppointment($patient_id, $doctor_id, $time) {
        $query = "INSERT INTO appointments 
                    (patient_id, doctor_id,  appointment_time, status) 
                 VALUES (?, ?, ?, 'pending')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iis", $patient_id, $doctor_id, $time);
        return $stmt->execute();
    }
    
    // Update appointment status
    public function updateAppointmentStatus($appointment_id, $status) {
        $query = "UPDATE appointments SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $status, $appointment_id);
        return $stmt->execute();
    }
    
    // Get available time slots for a doctor
    public function getAvailableTimeSlots($doctor_id, $time) {
        $query = "SELECT appointment_time 
                 FROM appointments 
                 WHERE doctor_id = ? AND appointment_time = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $doctor_id, $time);
        $stmt->execute();
        $booked_slots = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Define all possible time slots (9 AM to 5 PM)
        $all_slots = array(
            "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
            "12:00", "12:30", "14:00", "14:30", "15:00", "15:30",
            "16:00", "16:30"
        );
        
        // Remove booked slots
        $booked_times = array_column($booked_slots, 'appointment_time');
        return array_diff($all_slots, $booked_times);
    }
}

// Initialize the appointment manager
$appointmentManager = new AppointmentManager($conn);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                if ($role === 'patient') {
                    $result = $appointmentManager->createAppointment(
                        $user_id,
                        $_POST['doctor_id'],
                        $_POST['time']
                    );
                    if ($result) {
                        $_SESSION['message'] = "Appointment scheduled successfully!";
                    } else {
                        $_SESSION['error'] = "Failed to schedule appointment.";
                    }
                }
                break;
                
            case 'update_status':
                if ($role === 'doctor') {
                    $result = $appointmentManager->updateAppointmentStatus(
                        $_POST['appointment_id'],
                        $_POST['status']
                    );
                    if ($result) {
                        $_SESSION['message'] = "Appointment status updated!";
                    } else {
                        $_SESSION['error'] = "Failed to update status.";
                    }
                }
                break;
        }
        header("Location: appointments.php");
        exit();
    }
}

// Get appointments based on user type
$appointments = ($role === 'doctor') 
    ? $appointmentManager->getDoctorAppointments($user_id)
    : $appointmentManager->getPatientAppointments($user_id);
?>

<?php include '../config/header.php'?>
</div>
</nav>
    <div class="container">
        <h1>Appointments </h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if ($role === 'patient'): ?>
            <!-- Patient: New Appointment Form -->
            <div class="card">
                <h3>Schedule New Appointment</h3>
                <form action="appointments.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="doctor">Select Doctor:</label>
                        <select name="doctor_id" id="doctor" required>
                            <?php
                            $doctors_query = "SELECT user_id AS id, first_name AS name FROM users WHERE role = 'doctor'";
                            $result = $conn->query($doctors_query);
                            
                            if ($result && $result->num_rows > 0) {
                                while ($doctor = $result->fetch_assoc()) {
                                    $id = htmlspecialchars($doctor['id'], ENT_QUOTES, 'UTF-8');
                                    $name = htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8');
                                    echo "<option value=\"$id\">$name</option>";
                                }
                               
                            } else {
                                echo "<option value=\"\" disabled> No doctors available</option>";
                            }

                            if($result) {   
                                $result->close();
                            }
                            
                            /*
                            if (empty($doctors)) {
                                echo "<option disabled>No doctors available</option>";
                            }
                            

                            foreach ($doctors as $doctor) {
                                echo "<option value={$doctor['id']}'>{$doctor['name']} </option>";
                            }*/

                            ?>
                            
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <select name="time" id="time" required>
                            <!-- Will be populated via JavaScript -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Reason for Visit:</label>
                        <textarea name="reason" id="reason" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                </form>
            </div>
        <?php endif; ?>
        
        <!-- Appointments List -->
        <div class="card">
            <h3>Your Appointments</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <?php if ($role === 'doctor'): ?>
                            <th>Patient</th>
                        <?php else: ?>
                            <th>Doctor</th>
                        <?php endif; ?>
                        <th>Reason</th>
                        <th>Status</th>
                        <?php if ($role === 'doctor'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($appointments)): ?>
        <tr>
            <td colspan="<?php echo ($role === 'doctor') ? '6' : '5'; ?>" class="text-center">
                No appointments found.😊📅
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></td>
                <td><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></td>
                <?php if ($role === 'doctor'): ?>
                    <td><?php echo $appointment['patient_name']; ?></td>
                <?php else: ?>
                    <td><?php echo $appointment['doctor_name']; ?></td>
                <?php endif; ?>
                <td><?php echo $appointment['reason']; ?></td>
                <td><?php echo ucfirst($appointment['status']); ?></td>
                <?php if ($role === 'doctor'): ?>
                    <td>
                        <form action="appointments.php" method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" <?php echo $appointment['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $appointment['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="cancelled" <?php echo $appointment['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                <option value="completed" <?php echo $appointment['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../config/footer.php'; ?>

    <script src="../public/healthtrak.js"></script>
</body>
</html>