<!DOCTYPE html>
<?php include_once("../scripts/test_connection.php") ?>
<?php include_once("../scripts/categories.php") ?>
<?php echo "Hello ", $_SESSION['Username'], "<br>"; ?>
<a class="logout" href="../scripts/logout.php">Logout</a>

<?php

if (isset($_SESSION['Username'])) {
    ?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <title>Library</title>
    </head>
    <body>
        <header>
            <h1>Tweedy's Library</h1>
        </header>
        <div class="search-box">
            <form action="searchResult.php" method="GET" class="search-form">
                <a href="library.php" id='reserved_books'>View All Books</a>
            </form>
        </div>
        <div class="main">
            <?php
                $un = $_SESSION['Username'];

                // calculating offset and limit
                if (isset($_GET['page_num']) && $_GET['page_num'] != "") {
                    $page_num = $_GET['page_num'];
                } else {
                    $page_num = 1;
                }
                $limit_records = 5;
                $offset = ($page_num - 1) * $limit_records;
                $previous = $page_num - 1;
                $next = $page_num + 1;

                $sql = "SELECT
                            books.ISBN,
                            books.BookTitle,
                            books.Author,
                            books.Edition,
                            books.Year,
                            category.CategoryDesc,
                            books.Reserved
                        FROM
                            books
                        INNER JOIN
                            category ON books.Category = category.CategoryID
                        WHERE
                            ISBN IN(
                                SELECT
                                    ISBN
                                FROM
                                    reservations
                                JOIN users WHERE reservations.Username = '$un')";
                $result = mysqli_query(
                    $conn,
                    $sql
                );

                if ($result->num_rows > 0) {
                    // output data of each row into a table
                    echo "<h1>Your Reserved Books</h1>";
                    echo "<h3>Displaying $result->num_rows result(s)</h3><br>";
                    echo "<table class='book-table'>";
                    echo "<tr><th>ISBN</th>
                          <th>Book Title</th>
                          <th>Author</th>
                          <th>Edition</th>
                          <th>Year</th>
                          <th>Category</th>";
                          
                    while ($row = $result->fetch_assoc()) {
                        $isbn = $row['ISBN'];
                        echo "<tr><td>";
                        echo ($row['ISBN']);
                        echo "</td><td>";
                        echo ($row['BookTitle']);
                        echo "</td><td>";
                        echo ($row['Author']);
                        echo "</td><td>";
                        echo ($row['Edition']);
                        echo "</td><td>";
                        echo ($row['Year']);
                        echo "</td><td>";
                        echo ($row['CategoryDesc']);
                        echo "</td>";

                        echo "<td class='reserve'>";
                        echo "<a href='../scripts/removeRes.php?isbn=$isbn' class='submit_button'>";
                        echo "Remove reservation";
                        echo "</a></td>";
                    }
                    echo "</table>\n";
                } else {
                    echo "<h1>Your Reserved Books</h1>";
                    echo "<h3>Displaying $result->num_rows result(s)</h3><br>";
                    echo "You currently have 0 books reserved.<br>";
                    echo "Reserve some <a href='library.php' class='logout'>here</a>";
                }
            ?>
        </div>
        <footer>
            <p>&#169;2021 Matthew Tweedy</p>
        </footer>
    </body>
    </html>
<?php 
} else {
    header("location: ../html/index.php?error=*you must be logged in to see this*");
    die();
} 
?>