<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Member</h3>
                        </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="member_name" class="form-label">MemberName</label>
                                <input type="text" class="form-control" id="member_name" name="member_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Member</button>
                        </form>

                        <?php
                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("INSERT INTO Member (MemberName, Address, Email, Phone) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("sssi", $member_name, $address, $email, $phone);

                            // Set parameters and execute
                            $member_name = $_POST["member_name"];
                            $address = $_POST["address"];
                            $email = $_POST["email"];
                            $phone = $_POST["phone"];
                    

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Member added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding member. Please try again later.</div>';
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
