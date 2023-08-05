<!DOCTYPE html>
<html>
<head>
    <title>Delete Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Delete Member</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["MemberName"])) {
                            $member_name = $_GET["MemberName"];
                            if (!$conn) {
                                die("Kết nối Cơ sở dữ liệu thất bại: " . mysqli_connect_error());
                            }

                            // Query to retrieve member information based on MemberName
                            $stmt = $conn->prepare("SELECT MemberName FROM Member WHERE MemberName = ?");
                            if (!$stmt) {
                                die("Lỗi truy vấn: " . $conn->error);
                            }
                            $stmt->bind_param("s", $member_name);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (!$result) {
                                die("Lỗi truy vấn: " . $stmt->error);
                            }

                            if ($result->num_rows == 1) {
                                $member = $result->fetch_assoc();
                                ?>
                                <p>Are you sure you want to delete this member ? '<?php echo $member['MemberName']; ?>' ?</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="MemberName" value="<?php echo $member_name; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                    <a href="view_members.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Member not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
                            // Process form data when the delete button is clicked
                            $member_name = $_POST["MemberName"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("DELETE FROM Member WHERE MemberName = ?");
                            $stmt->bind_param("s", $member_name);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Member deleted successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error deleting member. Please try again later.</div>';
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

