<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$email = $_SESSION['user'];

class MessageManager {
    private $conn;
    
    public function __construct($database) {
        $this->conn = $database;
    }
    
    // Get all conversations for the current user
    public function getConversations($user_id, $role) {
        $query = $role === 'doctor' ?
            "SELECT DISTINCT 
                u.user_id as other_id,
                u.first_name,
                u.email,
                (SELECT message_content 
                 FROM messages 
                 WHERE (sender_id = ? AND receiver_id = u.user_id) 
                    OR (sender_id = u.user_id AND receiver_id = ?)
                 ORDER BY sent_at DESC 
                 LIMIT 1) as last_message,
                (SELECT sent_at 
                 FROM messages 
                 WHERE (sender_id = ? AND receiver_id = u.user_id) 
                    OR (sender_id = u.user_id AND receiver_id = ?)
                 ORDER BY sent_at DESC 
                 LIMIT 1) as last_message_time
             FROM messages m
             JOIN users u ON (m.sender_id = u.user_id OR m.receiver_id = u.user_id)
             WHERE (m.sender_id = ? OR m.receiver_id = ?)
             AND u.user_id != ?
             AND u.role = 'patient'
             GROUP BY u.user_id
             ORDER BY last_message_time DESC" :
            "SELECT DISTINCT 
                u.user_id as other_id,
                u.first_name,
                u.email,
                (SELECT message_content 
                 FROM messages 
                 WHERE (sender_id = ? AND receiver_id = u.user_id) 
                    OR (sender_id = u.user_id AND receiver_id = ?)
                 ORDER BY sent_at DESC 
                 LIMIT 1) as last_message,
                (SELECT sent_at 
                 FROM messages 
                 WHERE (sender_id = ? AND receiver_id = u.user_id) 
                    OR (sender_id = u.user_id AND receiver_id = ?)
                 ORDER BY sent_at DESC 
                 LIMIT 1) as last_message_time
             FROM messages m
             JOIN users u ON (m.sender_id = u.user_id OR m.receiver_id = u.user_id)
             WHERE (m.sender_id = ? OR m.receiver_id = ?)
             AND u.user_id != ?
             AND u.role = 'doctor'
             GROUP BY u.user_id
             ORDER BY last_message_time DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiiiiii", $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get messages between two users
    public function getMessages($user1_id, $user2_id) {
        $query = "SELECT 
                    m.*,
                    sender.first_name as sender_name,
                    receiver.first_name as receiver_name
                 FROM messages m
                 JOIN users sender ON m.sender_id = sender.user_id
                 JOIN users receiver ON m.receiver_id = receiver.user_id
                 WHERE (sender_id = ? AND receiver_id = ?)
                    OR (sender_id = ? AND receiver_id = ?)
                 ORDER BY sent_at ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $user1_id, $user2_id, $user2_id, $user1_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    // Send a new message
    public function sendMessage($sender_id, $receiver_id, $message) {
        $query = "INSERT INTO messages (sender_id, receiver_id, message, sent_at) 
                 VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
        return $stmt->execute();
    }
    
    // Get available doctors/patients for new conversation
    public function getAvailableUsers($user_id, $role) {
        $target_role = $role === 'doctor' ? 'patient' : 'doctor';
        $query = "SELECT user_id, first_name, email 
                 FROM users 
                 WHERE role = ? 
                 AND user_id NOT IN (
                     SELECT IF(sender_id = ?, receiver_id, sender_id)
                     FROM messages
                     WHERE sender_id = ? OR receiver_id = ?
                 )";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siii", $target_role, $user_id, $user_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// Initialize the message manager
$messageManager = new MessageManager($conn);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'send':
                $result = $messageManager->sendMessage(
                    $user_id,
                    $_POST['receiver_id'],
                    $_POST['message']
                );
                if ($result) {
                    $_SESSION['message'] = "Message sent successfully!";
                } else {
                    $_SESSION['error'] = "Failed to send message.";
                }
                break;
        }
        
        if (isset($_POST['receiver_id'])) {
            header("Location: messages.php?user=" . $_POST['receiver_id']);
        } else {
            header("Location: messages.php");
        }
        exit();
    }
}

// Get conversations and selected user messages
$conversations = $messageManager->getConversations($user_id, $role);
$selected_user = isset($_GET['user']) ? $_GET['user'] : null;
$messages = $selected_user ? $messageManager->getMessages($user_id, $selected_user) : null;
$available_users = $messageManager->getAvailableUsers($user_id, $role);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="styles.css"> <!-- If you have a stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdeliver.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<?php include '../config/header.php'; ?>
</div>
</nav>

<div class="message_container container">
    <h1>Messages</h1>
    
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
    
    <div class="row">
    <!-- Conversations List -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Conversations</h5>
                <?php if (!empty($available_users)): ?>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newConversationModal">
                        New Message
                    </button>
                <?php endif; ?>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($conversations as $conv): ?>
                    <a href="?user=<?php echo $conv['other_id']; ?>" 
                       class="list-group-item list-group-item-action <?php echo $selected_user == $conv['other_id'] ? 'active' : ''; ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-1"><?php echo htmlspecialchars($conv['first_name']); ?></h6>
                            <small><?php echo date('M d, g:i a', strtotime($conv['last_message_time'])); ?></small>
                        </div>
                        <small class="text-muted"><?php echo htmlspecialchars(substr($conv['last_message'], 0, 50)) . '...'; ?></small>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Messages Area -->
    <div class="col-md-8">
        <?php if ($selected_user): ?>
            <div class="card">
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <?php foreach ($messages as $msg): ?>
                        <div class="message <?php echo $msg['sender_id'] == $user_id ? 'text-right' : ''; ?> mb-3">
                            <small class="text-muted"><?php echo $msg['sender_id'] == $user_id ? 'You' : htmlspecialchars($msg['sender_name']); ?></small>
                            <div class="message-content p-2 rounded <?php echo $msg['sender_id'] == $user_id ? 'bg-primary text-white' : 'bg-light'; ?>">
                                <?php echo htmlspecialchars($msg['message']); ?>
                            </div>
                            <small class="text-muted"><?php echo date('M d, g:i a', strtotime($msg['sent_at'])); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="card-footer">
                    <form action="messages.php" method="POST">
                        <input type="hidden" name="action" value="send">
                        <input type="hidden" name="receiver_id" value="<?php echo $selected_user; ?>">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted">Select a conversation or start a new one</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- New Conversation Modal -->
<div class="modal fade" id="newConversationModal" tabindex="-1" role="dialog" aria-labelledby="newConversationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newConversationModalLabel">Start a New Conversation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="start_conversation.php" method="POST">
                    <div class="form-group">
                        <label for="recipient">Select User</label>
                        <select name="recipient_id" id="recipient" class="form-control" required>
                            <option value="" disabled selected>Select a user</option>
                            <?php foreach ($available_users as $user): ?>
                                <option value="<?php echo $user['id']; ?>">
                                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="initial_message">Message</label>
                        <textarea name="initial_message" id="initial_message" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Start Conversation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- New Conversation Modal -->
<?php if (!empty($available_users)): ?>
<div class="modal fade" id="newConversationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Start New Conversation</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <?php foreach ($available_users as $user): ?>
                        <a href="?user=<?php echo $user['user_id']; ?>" class="list-group-item list-group-item-action">
                            <h6 class="mb-1"><?php echo htmlspecialchars($user['first_name']); ?></h6>
                            <small class="text-muted">
                                <?php echo htmlspecialchars($user['email']); ?>
                                <?php if (isset($user['specialization'])): ?>
                                    - <?php echo htmlspecialchars($user['specialization']); ?>
                                <?php endif; ?>
                            </small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.message-content {
    display: inline-block;
    max-width: 80%;
    word-wrap: break-word;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../config/footer.php'; ?>

</body>
</html>

