<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Book</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Include the database connection
                        include 'db_connect.php';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["BookName"])) {
                            $book_name = $_GET["BookName"];
                        
                            // Query to retrieve book information based on BookName
                            $stmt = $conn->prepare("SELECT BookName, Author, Category, PublicationYear FROM Book WHERE BookName = ?");
                            if (!$stmt) {
                                die("Error preparing the statement: " . $conn->error);
                            }
                        
                            if (!$stmt->bind_param("s", $book_name)) {
                                die("Error binding parameters: " . $stmt->error);
                            }
                        
                            // Thực thi truy vấn
                            if (!$stmt->execute()) {
                                die("Error executing the query: " . $stmt->error);
                            }
                            $result = $stmt->get_result();
                        
                            if ($result->num_rows == 1) {
                                $book = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <label for="BookName" class="form-label">BookName</label>
                                        <input type="text" class="form-control" id="BookName" name="BookName" value="<?php echo $book['BookName']; ?>" requỉred>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Author" class="form-label">Author</label>
                                        <input type="text" class="form-control" id="Author" name="Author" value="<?php echo $book['Author']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Category" class="form-label">Category</label>
                                        <input type="text" class="form-control" id="Category" name="Category" value="<?php echo $book['Category']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="PublicationYear" class="form-label">PublicationYear</label>
                                        <input type="number" class="form-control" id="PublicationYear" name="PublicationYear" value="<?php echo $book['PublicationYear']; ?>" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Book not found</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Process form data when the form is submitted
                            $book_name = $_POST["BookName"];
                            $author = $_POST["Author"];
                            $category = $_POST["Category"];
                            $publication_year = $_POST["PublicationYear"];
                        
                            // Include the database connection
                            include 'db_connect.php';
                        
                            // Prepare and bind SQL statement
                            
                            $sql = "UPDATE Book SET BookName = ?, Author = ?, Category = ?, PublicationYear = ? WHERE BookName = ?";
                            $stmt = $conn->prepare($sql);
                            
                            if (!$stmt) {
                                die("Error preparing the statement: " . $conn->error);
                            }
                        
                            if (!$stmt->bind_param("sssis", $book_name, $author, $category, $publication_year, $book_name)) {
                                die("Error binding parameters: " . $stmt->error);
                            }
                        
                            if (!$stmt->execute()) {
                                die("Error executing the query: " . $stmt->error);
                            } else {
                                echo '<div class="alert alert-success mt-3" role="alert">Book updated successfully!</div>';
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

 
</body>
</html>
