<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Books</h3>
                        <a href="add_book.php" class="btn btn-light mt-3">Add Book</a>
                        <a href="view_books.php" class="btn btn-light mt-3">View Books</a>
                        <!-- Add other actions for managing students -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Members</h3>
                        <a href="add_member.php" class="btn btn-light mt-3">Add Member</a>
                        <a href="view_members.php" class="btn btn-light mt-3">View Members</a>
                        <!-- Add other actions for managing courses -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Borrowings</h3>
                        <a href="add_borrower.php" class="btn btn-light mt-3">Add Borrower</a>
                        <a href="view_borrowings.php" class="btn btn-light mt-3">View Borrowings</a>
                        <!-- Add other actions for managing grading components -->
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
