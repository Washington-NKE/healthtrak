<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user'];

$sql = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


$doctor_id = $row['user_id'];
$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : null;

// Function to get all patients assigned to the doctor
function getDoctorPatients($conn, $doctor_id) {
    $sql = "SELECT DISTINCT p.* 
            FROM patients p 
            JOIN appointments a ON p.patient_id = a.patient_id 
            WHERE a.doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get patient details
function getPatientDetails($conn, $patient_id) {
    $sql = "SELECT * FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to get patient's appointments
function getPatientAppointments($conn, $patient_id, $doctor_id) {
    $sql = "SELECT * FROM appointments 
            WHERE patient_id = ? AND doctor_id = ? 
            ORDER BY appointment_time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $patient_id, $doctor_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get patient's medical history
function getPatientMedicalHistory($conn, $patient_id) {
    $sql = "SELECT medical_history FROM patients 
            WHERE patient_id = ? 
            ORDER BY updated_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to add medical history
function addMedicalHistory($conn, $patient_id,$medical_history, $feedback) {
    $sql = "INSERT INTO patients (patient_id, medical_history, feedback) 
            VALUES ( ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $patient_id,$medical_history, $feedback);
    return $stmt->execute();
}

// Function to update appointment status
function updateAppointmentStatus($conn, $appointment_id, $status, $notes) {
    $sql = "UPDATE appointments SET status = ?, notes = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $notes, $appointment_id);
    return $stmt->execute();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_medical_history'])) {
        $patient_id = $_POST['patient_id'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $treatment = $_POST['treatment'];
        $medical_history = 'Type: ' . $type . ', Description: ' . $description . ', Treatment: ' . $treatment;
        $feedback = $_POST['feedback'];
        if (addMedicalHistory($conn, $patient_id, $medical_history, $feedback)) {
            $_SESSION['success'] = "Medical history added successfully";
        } else {
            $_SESSION['error'] = "Error adding medical history";
        }
    }
    
    if (isset($_POST['update_appointment'])) {
        $appointment_id = $_POST['appointment_id'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];
        
        if (updateAppointmentStatus($conn, $appointment_id, $status, $notes)) {
            $_SESSION['success'] = "Appointment updated successfully";
        } else {
            $_SESSION['error'] = "Error updating appointment";
        }
    }
    
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['patient_id']) ? '?patient_id=' . $_GET['patient_id'] : ''));
    exit();
}

// Get patients list
$patients = getDoctorPatients($conn, $doctor_id);

// Get specific patient details if patient_id is provided
$selected_patient = null;
$patient_appointments = null;
$medical_history = null;

if (isset($_GET['patient_id'])) {
    $selected_patient = getPatientDetails($conn, $_GET['patient_id']);
    if ($selected_patient) {
        $patient_appointments = getPatientAppointments($conn, $_GET['patient_id'], $doctor_id);
        $medical_history = getPatientMedicalHistory($conn, $_GET['patient_id']);
    }
}
?>


    <?php include '../config/header.php'; ?>
    </div>
</nav>

    <div class="container">
        <div class="row">
            <!-- Patients List Sidebar -->
            <div class="col-md-3">
                <div class="patients-sidebar">
                    <h2>My Patients</h2>
                    <div class="patient-list">
                        <?php while ($patient = $patients->fetch_assoc()): ?>
                            <a href="?patient_id=<?php echo $patient['id']; ?>" 
                               class="patient-item <?php echo (isset($_GET['patient_id']) && $_GET['patient_id'] == $patient['id']) ? 'active' : ''; ?>">
                                <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <hr>
            
            <!-- Patient Details Section -->
            <div class="col-md-9">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
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
                
                <?php if ($selected_patient): ?>
                    <div class="patient-details">
                        <h2>Patient Information</h2>
                        <div class="info-card">
                            <p><strong>Name:</strong> <?php echo $selected_patient['first_name'] . ' ' . $selected_patient['last_name']; ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo $selected_patient['date_of_birth']; ?></p>
                            <p><strong>Gender:</strong> <?php echo $selected_patient['gender']; ?></p>
                            <p><strong>Blood Type:</strong> <?php echo $selected_patient['blood_type']; ?></p>
                            <p><strong>Contact:</strong> <?php echo $selected_patient['phone']; ?></p>
                            <p><strong>Email:</strong> <?php echo $selected_patient['email']; ?></p>
                        </div>
                        
                        <hr>
                        <!-- Appointments Section -->
                        <section class="appointments">
                            <h3>Appointments</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($appointment = $patient_appointments->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo date('Y-m-d', strtotime($appointment['appointment_date'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($appointment['appointment_time'])); ?></td>
                                            <td><?php echo $appointment['status']; ?></td>
                                            <td><?php echo $appointment['notes']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                        data-toggle="modal" 
                                                        data-target="#updateAppointment<?php echo $appointment['id']; ?>">
                                                    Update
                                                </button>
                                                
                                                <!-- Update Appointment Modal -->
                                                <div class="modal fade" id="updateAppointment<?php echo $appointment['id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST">
                                                                <input type="hidden" name="update_appointment" value="1">
                                                                <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                                                                                                            <div class="modal-header">
                                                                    <h4 class="modal-title">Update Appointment</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                               <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Status:</label>
                                                                        <select name="status" class="form-control" required>
                                                                            <option value="Scheduled" <?php echo $appointment['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                                                            <option value="Completed" <?php echo $appointment['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                                            <option value="Cancelled" <?php echo $appointment['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                                            <option value="No Show" <?php echo $appointment['status'] == 'No Show' ? 'selected' : ''; ?>>No Show</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label>Notes:</label>
                                                                        <textarea name="notes" class="form-control"><?php echo $appointment['notes']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                              <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </section>
                        
                        <hr>
                        <!-- Medical History Section -->
                        <section class="medical-history">
                            <h3>Medical History</h3>
                            <button type="button" class="btn btn-primary mb-3" 
                                    data-toggle="modal" data-target="#addMedicalHistory">
                                Add Medical History
                            </button>
                            
                            <!-- Medical History List -->
                            <div class="history-timeline">
                                <?php while ($history = $medical_history->fetch_assoc()): ?>
                                    <div class="history-item">
                                        <div class="date"><?php echo date('Y-m-d', strtotime($history['date'])); ?></div>
                                        <div class="type"><?php echo $history['type']; ?></div>
                                        <div class="description"><?php echo $history['description']; ?></div>
                                        <?php if ($history['treatment']): ?>
                                            <div class="treatment">
                                                <strong>Treatment:</strong> <?php echo $history['treatment']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            
                            <!-- Add Medical History Modal -->
                            <div class="modal fade" id="addMedicalHistory">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST">
                                            <input type="hidden" name="add_medical_history" value="1">
                                            <input type="hidden" name="patient_id" value="<?php echo $selected_patient['id']; ?>">
                                            
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Medical History</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Type:</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="Diagnosis">Diagnosis</option>
                                                        <option value="Treatment">Treatment</option>
                                                        <option value="Surgery">Surgery</option>
                                                        <option value="Medication">Medication</option>
                                                        <option value="Test Results">Test Results</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Description:</label>
                                                    <textarea name="description" class="form-control" required></textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Treatment:</label>
                                                    <textarea name="treatment" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Add Record</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php else: ?>
                    <div class="select-patient-message">
                        <h2>Select a patient from the list to view their details</h2>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include '../config/footer.php'; ?>
    
    <!-- Include necessary JavaScript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>