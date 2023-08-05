<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Book</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="BookName" class="form-label">Book Name</label>
                                <input type="text" class="form-control" id="BookName" name="BookName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="Author" name="Author" required>
                            </div>
                            <div class="mb-3">
                                <label for="Category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="Category" name="Category" required>
                            </div>
                            <div class="mb-3">
                                <label for="PublicationYear" class="form-label">Publication Year</label>
                                <input type="number" class="form-control" id="PublicationYear" name="PublicationYear" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Book</button>
                        </form>

                        <?php
                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("INSERT INTO Book (BookName, Author, Category, PublicationYear) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("sssi", $book_name, $author, $category, $publication_year);

                            // Set parameters and execute
                            $book_name = $_POST["BookName"];
                            $author = $_POST["Author"];
                            $category = $_POST["Category"];
                            $publication_year = $_POST["PublicationYear"];
                    

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Book added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding book. Please try again later.</div>';
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
