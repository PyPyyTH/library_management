<!DOCTYPE html>
<html>
<head>
    <title>Delete Borrower</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Delete Borrower</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["BorrowerName"])) {
                            $borrower_name = $_GET["BorrowerName"];
                            if (!$conn) {
                                die("Kết nối Cơ sở dữ liệu thất bại: " . mysqli_connect_error());
                            }

                            // Query to retrieve borrower information based on BorrowerName
                            $stmt = $conn->prepare("SELECT BorrowerName FROM Borrower WHERE BorrowerName = ?");
                            if (!$stmt) {
                                die("Lỗi truy vấn: " . $conn->error);
                            }
                            $stmt->bind_param("s", $borrower_name);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (!$result) {
                                die("Lỗi truy vấn: " . $stmt->error);
                            }

                            if ($result->num_rows == 1) {
                                $borrower = $result->fetch_assoc();
                                ?>
                                <p>Are you sure you want to delete this borrower '<?php echo $borrower['BorrowerName']; ?>' ?</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="BorrowerName" value="<?php echo $borrower_name; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                    <a href="view_borrowings.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Borrower not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                            // Process form data when the delete button is clicked
                            $borrower_name = $_POST["BorrowerName"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("DELETE FROM Borrower WHERE BorrowerName = ?");
                            $stmt->bind_param("s", $borrower_name);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Borrower deleted successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error deleting borrower. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>

