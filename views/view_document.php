<?php
// Include database connection
include('../config/database.php');

// Check if document ID is passed via GET request
if (isset($_GET['file_path']) && !empty($_GET['file_path'])) {
    $file_path = basename($_GET['file_path']);
    
    // Fetch the document details from the database
    $query = "SELECT * FROM documents WHERE document_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $document_id);  // 'i' for integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the document exists
    if ($result->num_rows > 0) {
        $document = $result->fetch_assoc();
        $document_name = $document['file_name'];
        $document_path = $document['file_path'];
        $document_type = $document['file_type'];

        // Check if the file exists on the server
        if (file_exists($document_path)) {
            // Send the appropriate headers to view the document
            header('Content-Type: ' . mime_content_type($document_path));
            header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
            header('Content-Length: ' . filesize($document_path));
            readfile($document_path);
            exit;
        } else {
            echo "The document file was not found.";
        }
    } else {
        echo "Document not found.";
    }
} else {
    echo "Invalid document ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document</title>
    <link rel="stylesheet" href="styles.css"> <!-- If you have a stylesheet -->
    <?php include '../config/header.php'; ?>
</div>
</nav>
</head>
<body>
    <div class="container">
        <h2>Viewing Document</h2>
        <div class="document-info">
            <p>Document Name: <?php echo htmlspecialchars($document_name); ?></p>
            <p>Document Type: <?php echo htmlspecialchars($document_type); ?></p>
        </div>
        <hr>
        <div class="document-view">
            <!-- Document will be displayed here -->
        </div>
    </div>
</body>
</html>
