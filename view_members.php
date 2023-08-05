<!DOCTYPE html>
<html>
<head>
    <title>View Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">View Members</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by Member Name" name="searchKeyword">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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

                                    // Query to retrieve members from the database based on search keyword
                                    $sql = "SELECT MemberName, Address, Email, Phone FROM Member WHERE MemberName LIKE '%$searchKeyword%'";
                                } else {
                                    // Default query to retrieve all members from the database
                                    $sql = "SELECT MemberName, Address, Email, Phone FROM Member";
                                }

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display member information
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["MemberName"] . '</td>';
                                        echo '<td>' . $row["Address"] . '</td>';
                                        echo '<td>' . $row["Email"] . '</td>';
                                        echo '<td>' . $row["Phone"] . '</td>';
                                        echo '<td>';
                                        echo '<a href="edit_member.php?MemberName=' . $row["MemberName"] . '" class="btn btn-primary btn-sm">Edit</a>'; // Add Edit button with link to edit_member.php
                                        echo '<a href="delete_member.php?MemberName=' . $row["MemberName"] . '" class="btn btn-danger btn-sm ml-2">Delete</a>'; // Add Delete button with link to delete_member.php
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No books found in the database
                                    echo '<tr><td colspan="6" class="text-center">No members found.</td></tr>';
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