<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='login.html';</script>";
    exit();
}

// Get user name from session
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Student Notes Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .dashboard-box {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .btn-group-custom a {
      margin: 10px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="dashboard-box">
      <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
      <p>You are successfully logged in.</p>

      <div class="btn-group-custom">
        <a href="upload_notes.php" class="btn btn-success">Upload Notes</a>
        <a href="view_notes.php" class="btn btn-info">View Notes</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>

</body>
</html>
