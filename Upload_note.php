<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    $file = $_FILES['note_file'];
    $filename = $file['name'];
    $filepath = 'uploads/' . basename($filename);
    $filetype = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];

    if (in_array($filetype, $allowed)) {
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $stmt = $conn->prepare("INSERT INTO notes (user_id, subject, description, filename) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $subject, $description, $filename);
            $stmt->execute();
            echo "<script>alert('Note uploaded successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to upload file.');</script>";
        }
    } else {
        echo "<script>alert('Only PDF, DOC, PPT files are allowed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3>Upload New Notes</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Subject</label>
      <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label>Select File (PDF, DOC, PPT)</label>
      <input type="file" name="note_file" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>
