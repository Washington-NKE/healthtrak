<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}


$email = $_SESSION['user'];
$role = $_SESSION['role'];

// Function to get patient's personal information
function getPatientInfo($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to get patient's medical history
function getMedicalHistory($conn, $email) {
    $sql = "SELECT u.*, p.medical_history FROM users u LEFT JOIN patients p ON u.user_id = p.patient_id WHERE u.email = ? ORDER BY updated_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get past appointments
function getPastAppointments($conn, $email) {
    $sql = "SELECT a.*, u.first_name as doctor_fname, u.last_name as doctor_lname
            FROM appointments a
            JOIN users u ON a.doctor_id = u.user_id
            WHERE u.email = ? AND DATE(a.appointment_time) < CURDATE()
            ORDER BY a.appointment_time DESC;";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get medical documents

function getMedicalDocuments($conn, $email) {
    $sql = "SELECT d.*, u.first_name  FROM documents d
            JOIN users u ON d.patient_email = u.email
            WHERE u.email = ? 
            ORDER BY uploaded_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $email);
    $stmt->execute();
    return $stmt->get_result();
}


// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_document'])) {
    $target_dir = "../storage/medical_documents/";
    $file_extension = strtolower(pathinfo($_FILES["document"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check file type
    $allowed_types = array('pdf', 'jpg', 'jpeg', 'png');
    if (in_array($file_extension, $allowed_types)) {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $document_name = $_POST['document_name'];
            $document_type = $_POST['document_type'];
            
            $sql = "INSERT INTO documents (patient_email, file_name, file_type, 
                    file_path, uploaded_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $email, $document_name, $document_type, $new_filename);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Document uploaded successfully";
            } else {
                $_SESSION['error'] = "Error uploading document";
            }
        } else {
            $_SESSION['error'] = "Error uploading file";
        }
    } else {
        $_SESSION['error'] = "Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.";
    }
    
    header('Location: records.php');
    exit();
}

// Get patient information
$patient_info = getPatientInfo($conn, $email);
$medical_history = getMedicalHistory($conn, $email);
$past_appointments = getPastAppointments($conn, $email);
$medical_documents = getMedicalDocuments($conn, $email);
?>

    <?php include '../config/header.php'; ?>
</div>
</nav>
    
    <div class="container">
        <h1>Medical Records & History</h1>
        <hr>
        
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
        
        <!-- Personal Information -->
        <section class="patient-info">
            <h2>Personal Information</h2>
            <div class="info-card">
                <p><strong>Name:</strong> <?php echo $patient_info['first_name'] . ' ' . $patient_info['last_name']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $patient_info['dob']; ?></p>
                <p><strong>Gender:</strong> <?php echo $patient_info['gender']; ?></p>
                <p><strong>Contact:</strong> <?php echo $patient_info['phone']; ?></p>
                <p><strong>Email:</strong> <?php echo $patient_info['email']; ?></p>
                <p><strong>Address:</strong> <?php echo $patient_info['residence']; ?></p>
            </div>
        </section>
        

        <!-- Past Appointments -->
<section class="past-appointments">
<hr>
    <h2>Past Appointments</h2>
    <?php if ($past_appointments->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($appointment = $past_appointments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($appointment['appointment_date'])); ?></td>
                            <td><?php echo date('H:i', strtotime($appointment['appointment_time'])); ?></td>
                            <td>
                                Dr. <?php echo $appointment['doctor_fname'] . ' ' . $appointment['doctor_lname']; ?>
                                <br>
                                <small><?php echo $appointment['specialization']; ?></small>
                            </td>
                            <td><?php echo $appointment['department']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                            <td><?php echo $appointment['notes']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-appointments">
            <p>🚫 No past appointments found. Please check back later! 🗓️</p>
        </div>
    <?php endif; ?>
</section>

        <hr>
        <!-- Medical History -->
<section class="medical-history">
    <h2>Medical History</h2>
    <?php if ($medical_history->num_rows > 0 || $medical_history->fetch_assoc()['medical_history'] != ''): ?>
        <div class="history-timeline">
            <?php while ($history = $medical_history->fetch_assoc()): ?>
                <div class="history-item">
                    <div class="history"><?php echo $history['medical_history']; ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-history">
            <p>📝 No medical history found. Please update your records! 🏥</p>
        </div>
    <?php endif; ?>
</section>

        
        <hr>
        <!-- Medical Documents -->
        <section class="medical-documents">
            <h2>Medical Documents</h2>
            
            <!-- Upload Form -->
            <div class="upload-form">
                <h3>Upload New Document</h3>
                <form method="POST" action="records.php" enctype="multipart/form-data">
                    <input type="hidden" name="upload_document" value="1">
                    
                    <div class="form-group">
                        <label for="document_name">Document Name:</label>
                        <input type="text" name="document_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="document_type">Document Type:</label>
                        <input list="document_types" name="document_type" id="document_type" />
                    <datalist id="document_types">
                    <option value="Lab Report">
                     <option value="X-Ray">
                     <option value="Prescription">
                    <option value="Discharge Summary">
                     <option value="Other">
                    </datalist>
                    </div>
                    
                    <div class="form-group">
                        <label for="document">Select File:</label>
                        <input type="file" name="document" required>
                        <small>Allowed formats: PDF, JPG, JPEG, PNG</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Upload Document</button>
                </form>
            </div>
            
            <hr>
            <!-- Documents List -->
<div class="documents-list">
    <h3>Uploaded Documents</h3>
    <?php if ($medical_documents->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Document Name</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($document = $medical_documents->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($document['uploaded_at'])); ?></td>
                            <td><?php echo $document['file_name']; ?></td>
                            <td><?php echo $document['file_type']; ?></td>
                            <td>
                                <a href="view_document.php?id=<?php echo $document['document_id']; ?>" 
                                   class="btn btn-sm btn-primary" target="_blank">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-documents">
            <p>📂 No documents uploaded yet. Please check back later! 📄</p>
        </div>
    <?php endif; ?>
</div>

    </section>
    </div>
    
    <?php include '../config/footer.php'; ?>
</body>
</html>