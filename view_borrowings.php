<!DOCTYPE html>
<html>
<head>
    <title>View Borrowers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">View Borrowers</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by Borrower Name" name="searchKeyword">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Borrower Name</th>                                    
                                    <th>Book Name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Action</th> <!-- Add Action column header -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Include the database connection
                                include 'db_connect.php';

                                // Process form data when the form is submitted
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $searchKeyword = $_POST["searchKeyword"];

                                    // Query to retrieve borrowers from the database based on search keyword
                                    $sql = "SELECT BorrowerName, BookName, BorrowDate, ReturnDate FROM Borrower WHERE BorrowerName LIKE '%$searchKeyword%'";
                                } else {
                                    // Default query to retrieve all borrowers from the database
                                    $sql = "SELECT BorrowerName, BookName, BorrowDate, ReturnDate FROM Borrower";
                                }

                                $result = $conn->query($sql);

                                if ($result === false) {
                                    die("Error executing the query: " . $conn->error);
                                }

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display borrower information
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["BorrowerName"] . '</td>';
                                        echo '<td>' . $row["BookName"] . '</td>';
                                        echo '<td>' . $row["BorrowDate"] . '</td>';
                                        echo '<td>' . $row["ReturnDate"] . '</td>';
                                        echo '<td>';
                                        echo '<a href="edit_borrower.php?BorrowerName=' . $row["BorrowerName"] . '" class="btn btn-primary btn-sm">Edit</a>'; // Add Edit button with link to edit_borrowerphp
                                        echo '<a href="delete_borrower.php?BorrowerName=' . $row["BorrowerName"] . '" class="btn btn-danger btn-sm ml-2">Delete</a>'; // Add Delete button with link to delete_borrower.php
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No books found in the database
                                    echo '<tr><td colspan="6" class="text-center">No borrowers found.</td></tr>';
                                }

                                // Close connection
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>