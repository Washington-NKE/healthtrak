<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Get user role
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Function to get all prescriptions for a doctor
function getDoctorPrescriptions($conn, $doctor_id) {
    $sql = "SELECT p.*, u.first_name as patient_fname, u.last_name as patient_lname, 
            p.medication, p.dosage
            FROM prescriptions p
            JOIN users u ON p.patient_id = u.user_id
            WHERE p.doctor_id = ?
            ORDER BY p.updated_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get patient's prescriptions
function getPatientPrescriptions($conn, $patient_id) {
    $sql = "SELECT p.*, u.first_name as doctor_fname, u.last_name as doctor_lname
            FROM prescriptions p
            JOIN users u ON p.doctor_id = u.user_id
            WHERE p.patient_id = ?
            ORDER BY p.updated_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to add new prescription
function addPrescription($conn, $doctor_id, $patient_id, $medication, $dosage) {
    $sql = "INSERT INTO prescriptions (doctor_id, patient_id, medication, dosage,  status) 
            VALUES (?, ?, ?, ?, 'Active')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $doctor_id, $patient_id, $medication, $dosage);
    return $stmt->execute();
}

// Function to update prescription status
function updatePrescriptionStatus($conn, $prescription_id, $status) {
    $sql = "UPDATE prescriptions SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $prescription_id);
    return $stmt->execute();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_prescription']) && $user_role == 'doctor') {
        $patient_id = $_POST['patient_id'];
        $medicine_id = $_POST['medicine_id'];
        $dosage = $_POST['dosage'];
        $frequency = $_POST['frequency'];
        $duration = $_POST['duration'];
        
        if (addPrescription($conn, $user_id, $patient_id, $medicine_id, $dosage, $frequency, $duration)) {
            $_SESSION['success'] = "Prescription added successfully";
        } else {
            $_SESSION['error'] = "Error adding prescription";
        }
        
        header('Location: prescriptions.php');
        exit();
    }
    
    if (isset($_POST['update_status']) && $user_role == 'doctor') {
        $prescription_id = $_POST['prescription_id'];
        $status = $_POST['status'];
        
        if (updatePrescriptionStatus($conn, $prescription_id, $status)) {
            $_SESSION['success'] = "Prescription status updated";
        } else {
            $_SESSION['error'] = "Error updating status";
        }
        
        header('Location: prescriptions.php');
        exit();
    }
}

// Get prescriptions based on user role
if ($user_role == 'doctor') {
    $prescriptions = getDoctorPrescriptions($conn, $user_id);
} else {
    $prescriptions = getPatientPrescriptions($conn, $user_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescriptions Management</title>
    <?php include '../config/header.php'; ?>
</div>
</nav>
</head>
<body>
    <div class="container">
        <h1>Prescriptions Management</h1>
        
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
        
        <?php if ($user_role == 'doctor'): ?>
            <!-- Doctor's Add Prescription Form -->
            <div class="prescription-form">
                <h2>Add New Prescription</h2>
                <form method="POST" action="prescriptions.php">
                    <input type="hidden" name="add_prescription" value="1">
                    
                    <div class="form-group">
                        <label for="patient_id">Select Patient:</label>
                        <select name="patient_id" required>
                            <?php
                            $patients = $conn->query("SELECT id, first_name, last_name FROM patients");
                            while ($patient = $patients->fetch_assoc()) {
                                echo "<option value='" . $patient['id'] . "'>" . 
                                     $patient['first_name'] . " " . $patient['last_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="medicine_id">Select Medicine:</label>
                        <select name="medicine_id" required>
                            <?php
                            $medicines = $conn->query("SELECT id, medicine_name, dosage_form FROM medicines");
                            while ($medicine = $medicines->fetch_assoc()) {
                                echo "<option value='" . $medicine['id'] . "'>" . 
                                     $medicine['medicine_name'] . " (" . $medicine['dosage_form'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="dosage">Dosage:</label>
                        <input type="text" name="dosage" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency">Frequency:</label>
                        <input type="text" name="frequency" placeholder="e.g., Twice daily" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="text" name="duration" placeholder="e.g., 7 days" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Prescription</button>
                </form>
            </div>
        <?php endif; ?>
        
        <!-- Prescriptions List -->
        <div class="prescriptions-list">
            <h2>Current Prescriptions</h2>
            <?php if ($prescriptions->num_rows == 0): ?>
                <div class="no-prescriptions">
                    <p>😌 No prescriptions at the moment. Keep up the good health! 🌟</p>
                    <p>If you have concerns, feel free to schedule an appointment with your doctor.</p>
                </div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <?php if ($user_role == 'doctor'): ?>
                                <th>Patient</th>
                            <?php else: ?>
                                <th>Doctor</th>
                            <?php endif; ?>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <?php if ($user_role == 'doctor'): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $prescriptions->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime($row['prescribed_date'])); ?></td>
                                <?php if ($user_role == 'doctor'): ?>
                                    <td><?php echo $row['patient_fname'] . ' ' . $row['patient_lname']; ?></td>
                                <?php else: ?>
                                    <td><?php echo $row['doctor_fname'] . ' ' . $row['doctor_lname']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $row['medicine_name'] . ' (' . $row['dosage_form'] . ')'; ?></td>
                                <td><?php echo $row['dosage']; ?></td>
                                <td><?php echo $row['frequency']; ?></td>
                                <td><?php echo $row['duration']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <?php if ($user_role == 'doctor'): ?>
                                    <td>
                                        <form method="POST" action="prescriptions.php" style="display: inline;">
                                            <input type="hidden" name="update_status" value="1">
                                            <input type="hidden" name="prescription_id" value="<?php echo $row['id']; ?>">
                                            <select name="status" onchange="this.form.submit();">
                                                <option value="Active" <?php echo $row['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="Completed" <?php echo $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo $row['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../config/footer.php'; ?>
</body>
</html>
