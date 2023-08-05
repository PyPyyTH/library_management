<!DOCTYPE html>
<html>
<head>
    <title>Edit Borrower</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Borrower</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["BorrowerName"])) {
                            $borrower_name = $_GET["BorrowerName"];

                            // Query to retrieve borrower information based on BorrowerName
                            $stmt = $conn->prepare("SELECT BorrowerName, BookName, BorrowDate, ReturnDate FROM Borrower WHERE BorrowerName = ?");
                            if (!$stmt) {
                                die("Error preparing the statement: " . $conn->error);
                            }
                        
                            if (!$stmt->bind_param("s", $borrower_name)) {
                                die("Error binding parameters: " . $stmt->error);
                            }
                        
                            // Thực thi truy vấn
                            if (!$stmt->execute()) {
                                die("Error executing the query: " . $stmt->error);
                            }
                            $result = $stmt->get_result();
                            if ($result->num_rows == 1) {
                                $borrower = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <label for="BorrowerName" class="form-label">BorrowerName</label>
                                        <input type="text" class="form-control" id="BorrowerName" name="BorrowerName" value="<?php echo $borrower['BorrowerName']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="BookNamee" class="form-label">BookName</label>
                                        <input type="text" class="form-control" id="BookName" name="BookName" value="<?php echo $borrower['BookName']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="BorrowDate" class="form-label">BorrowDate</label>
                                        <input type="text" class="form-control" id="BorrowDate" name="BorrowDate" value="<?php echo $borrower['BorrowDate']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ReturnDate" class="form-label">ReturnDate</label>
                                        <input type="text" class="form-control" id="ReturnDate" name="ReturnDate" value="<?php echo $borrower['ReturnDate']; ?>" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Borrower not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Process form data when the form is submitted
                            $borrower_name = $_POST["BorrowerName"];
                            $book_name = $_POST["BookName"];
                            $borrow_date = $_POST["BorrowDate"];
                            $return_date = $_POST["ReturnDate"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("UPDATE Borrower SET BorrowerName = ?, BookName = ?, BorrowDate = ?, ReturnDate = ? WHERE BorrowerName = ?");
                            $stmt->bind_param("sssss", $borrower_name, $book_name, $borrow_date, $return_date, $borrower_name );

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Borrower updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating borrower. Please try again later.</div>';
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