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
                <input type="search" placeholder="Search book name or author..." name="search">
                <label id="filter">Filter</label>
                <select name="categories" id="categories">
                    <option value="NULL">Select</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='".$row['CategoryDesc']."'>";
                            echo ($row['CategoryDesc']);
                            echo "</option>";
                        }
                        ?>
                </select>
                <button type="submit"><i class="fa fa-search"></i></button><br><br>
                <a href="reservedBooks.php" id='reserved_books'>View All of Your Reserved Books</a>
            </form>
        </div>
        <div class="main">
            <?php
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

            $num_result = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM books");
            $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, category.CategoryDesc, books.Reserved  
                FROM books
                INNER JOIN category ON books.Category=category.CategoryID
                LIMIT $limit_records OFFSET $offset";
            // echo $sql;
            $total_records = mysqli_fetch_array($num_result);
            $total_records = $total_records['total_records'];
            $total_pages = ceil($total_records / $limit_records);

            $result = mysqli_query(
                $conn,
                $sql
            );

            if ($result->num_rows > 0) {
                echo "<h1>All Books</h1>";
                echo "<h3>Displaying $result->num_rows of $total_records result(s)</h3>";
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
            <?php }
                echo "<table class='book-table'>";
                echo "<th>ISBN</th>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Edition</th>
                            <th>Year</th>
                            <th>Category</th>
                            <th>Available</th>";
                while ($row = mysqli_fetch_array($result)) {
                    $isbn = $row['ISBN'];
                    $rflag = $row['Reserved'];
                    echo "<tr><td>";
                    echo ($isbn);
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
                    if ($rflag === "Y") {
                        echo "<td class='yFlag'>";
                        echo "No";
                        echo "</td>";
                    } else {
                        echo "<td class='nFlag'>";
                        echo "Yes";
                        echo "</td>";
                    }
                    echo "<td class='reserve'>";
                    echo "<a href='../scripts/reserve.php?isbn=$isbn&rflag=$rflag' class='submit_button'>";
                    echo "Reserve Book";
                    echo "</a>";
                    // }
                }
                echo "</table>\n";
            } else {
                echo "<h3>Displaying $result->num_rows of $total_records result(s)</h3>";
                echo "0 results";
            }
            ?>
            <ul class="pagination">
                <?php if ($page_num > 1) {
                    echo "<a href='?page_num=1' class='logout'>First Page</a> |";
                } ?>

                <li <?php if ($page_num <= 1) {
                        echo "class='disabled'";
                    } ?>>
                    <a <?php if ($page_num > 1) {
                            echo "href='?page_num=$previous' class='logout'";
                        } ?>>Previous</a> |
                </li>

                <li <?php if ($page_num >= $total_pages) {
                        echo "class='disabled'";
                    } ?>>
                    <a <?php if ($page_num < $total_pages) {
                            echo "href='?page_num=$next' class='logout'";
                        } ?>>Next</a>
                </li>

                <?php if ($page_num < $total_pages) {
                    echo "| <li><a href='?page_num=$total_pages' class='logout'>Last</a></li>";
                } 
                $_SESSION['page_num'] = $page_num;
                ?>
            </ul>
        </div>
        <br>
        <br>
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