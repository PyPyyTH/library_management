<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Member</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["MemberName"])) {
                            $member_name = $_GET["MemberName"];

                            // Query to retrieve member information based on MemberName
                            $stmt = $conn->prepare("SELECT MemberName, Address, Email, Phone FROM Member WHERE MemberName = ?");
                            if (!$stmt) {
                                die("Error preparing the statement: " . $conn->error);
                            }
                        
                            if (!$stmt->bind_param("s", $member_name)) {
                                die("Error binding parameters: " . $stmt->error);
                            }
                        
                            // Thực thi truy vấn
                            if (!$stmt->execute()) {
                                die("Error executing the query: " . $stmt->error);
                            }
                            $result = $stmt->get_result();
                            if ($result->num_rows == 1) {
                                $member = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <label for="MemberName" class="form-label">MemberName</label>
                                        <input type="text" class="form-control" id="MemberName" name="MemberName" value="<?php echo $member['MemberName']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="Address" name="Address" value="<?php echo $member['Address']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="Email" name="Email" value="<?php echo $member['Email']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Phone" class="form-label">Phone</label>
                                        <input type="number" class="form-control" id="Phone" name="Phone" value="<?php echo $member['Phone']; ?>" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Member not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Process form data when the form is submitted
                            $member_name = $_POST["MemberName"];
                            $address = $_POST["Address"];
                            $email = $_POST["Email"];
                            $phone = $_POST["Phone"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("UPDATE Member SET MemberName = ?, Address = ?, Email = ?, Phone = ? WHERE MemberName = ?");
                            $stmt->bind_param("sssis", $member_name, $address, $email, $phone, $member_name);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Member updated successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error updating member. Please try again later.</div>';
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