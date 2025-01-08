
<?php 
if(isset($_SESSION['user_id'])){ ?>
    <a href="../views/logout.php" class="cta-btn d-none d-sm-block">Logout</a>
<?php } else { ?>
    <div class="d-flex align-items-center ms-4 user">
    <a class="cta-btn d-none d-sm-block" href="../views/login.php">Sign_In</a>
  <a class="cta-btn d-none d-sm-block" href="../views/register.php">Sign_Up</a>
</div>
<?php } ?>