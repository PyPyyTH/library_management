<!DOCTYPE html>
<html>
<head>
    <title>Delete Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Delete Book</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["BookName"])) {
                            $book_name = $_GET["BookName"];
                            if (!$conn) {
                                die("Kết nối Cơ sở dữ liệu thất bại: " . mysqli_connect_error());
                            }

                            // Query to retrieve book information based on book_name
                            $stmt = $conn->prepare("SELECT BookName FROM Book WHERE BookName = ?");
                            if (!$stmt) {
                                die("Lỗi truy vấn: " . $conn->error);
                            }
                            $stmt->bind_param("s", $book_name);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (!$result) {
                                die("Lỗi truy vấn: " . $stmt->error);
                            }
                        

                            if ($result->num_rows == 1 ) {
                                $book = $result->fetch_assoc();
                                ?>
                               <p>Are you sure you want to delete this book '<?php echo htmlspecialchars($book['BookName']); ?>' ?</p>
                               <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                               <input type="hidden" name="BookName" value="<?php echo htmlspecialchars($book_name); ?>">
                               <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                <a href="view_books.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Book not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                            // Process form data when the delete button is clicked
                            $book_name = $_POST["BookName"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("DELETE FROM Book WHERE BookName = ?");
                            if (!$stmt) {
                                die("Lỗi truy vấn: " . $conn->error);
                            }
                            $stmt->bind_param("s", $book_name);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Book successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error deleting book. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }
                        ini_set('error_log', '/path/to/error.log');
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
