<!-- add_grading_component.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Borrower</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Borrower</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="BorrowerName" class="form-label">BorrowerName</label>
                                <input type="text" class="form-control" id="BorrowerName" name="BorrowerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="BookName" class="form-label">BookName</label>
                                <input type="text" class="form-control" id="BookName" name="BookName" required>
                            </div>
                            <div class="mb-3">
                                <label for="BorrowDate" class="form-label">BorrowDate</label>
                                <input type="text" class="form-control" id="BorrowDate" name="BorrowDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="ReturnDate" class="form-label">ReturnDate</label>
                                <input type="text" class="form-control" id="ReturnDate" name="ReturnDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Borrower</button>
                        </form>

                        <?php
                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("INSERT INTO Borrower (BorrowerName, BookName, BorrowDate, ReturnDate) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $borrower_name, $book_name, $borrow_date, $return_date);

                            // Set parameters and execute
                            $borrower_name = $_POST["BorrowerName"];
                            $book_name = $_POST["BookName"];
                            $borrow_date = $_POST["BorrowDate"];
                            $return_date = $_POST["ReturnDate"];
                    

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Borrower added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding Borrower. Please try again later.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
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