<!DOCTYPE html>
<html lang = "en">
    <head lang = "en">
        <meta charset = "utf-8">

        <!-- Ensures proper rendering and touch zooming -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BookSource</title>

        <!-- JQuery and JavaScript Files -->
        <script src= "http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type = "text/javascript" src = "search.js"></script>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel = "stylesheet" href = "CSS/product.css">

        <!-- Javascript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
    <header>

    <nav class = "navbar navbar-default">
        <div class = "container-fluid">
            <div class="navbar-header navbar-expand-md bg-light">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavBar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>

                <a class = "navbar-brand logo" href = "index.php">
                    <img src = "img/logo.svg" width = "30" height = "30">
                </a>
                <a class="navbar-brand title" href="index.php">BookSource</a>
            </div>
        
            <div class = "collapse navbar-collapse" id = "myNavBar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    </header>
    <div class = "container-fluid">
        <div class = "row">
            <div class = "col-sm-2">
                <div class = "panel panel-default">
                    <div class = "panel-heading"><span class="glyphicon glyphicon-search"></span>Search</div>
                        <div class = "panel-body">
                            <form id = 'searchForm' method = 'POST'>
                                <div class = "form-group nowrap text-center" id = "form-group-search">
                                    <input class = 'form-control' type = 'text' name = 'searchInput' id = 'searchInput' placeholder = 'Search...'>
                                    <br>
                                </div>
                                <div class = "form-group text-center">
                                    <input class = "btn btn-info" type = 'submit' id = 'submit' value = 'Search'>
                                </div>
                            </form>
                        </div>
                </div>

                <?php
                    $host = "cosc499.ok.ubc.ca";
                    $database = "db_project";
                    $user = "webuser";
                    $password = "9UcM0QQcK1BwAXLk";
                    $sql = '';
                
                    $connection = mysqli_connect($host, $user, $password, $database);
                    $error = mysqli_connect_error();

                    $sql = "SELECT COUNT(ISBN) AS cnt, bookcategories.CategoryName FROM bookcategories INNER JOIN bookcategoriesbooks ON bookcategories.categoryID = bookcategoriesbooks.categoryID GROUP BY CategoryName";
                    $results = mysqli_query($connection, $sql);
                    echo "<div class = 'panel panel-default'>";
                    echo "<div class = 'panel-heading'>Search by Category</div>";
                    echo "<div class = 'panel-body' id = 'categoryPanel'>";
                    echo "<div class = 'list-group'>";
                    while($row = mysqli_fetch_assoc($results)){
                        $categoryName = $row['CategoryName'];
                        $count = $row['cnt'];
                        echo "<a class = 'list-group-item' href = '#' onclick = \"searchByCategory('$categoryName')\">$categoryName <span class = 'badge'>($count)</span></a>";
                    }
                    echo "</div></div></div>";
                ?>
                <div class = "panel panel-default">
                    <div class = "panel-heading">Time</div>
                    <div class = "panel-body">
                        <div id="time"></div>
                    </div>
                </div>

                </div>

            <div class = "col-sm-10">
                <div id = 'result'></div>
       
                <?php
                    $filters = Array();
                    $host = "cosc499.ok.ubc.ca";
                    $database = "db_project";
                    $user = "webuser";
                    $password = "9UcM0QQcK1BwAXLk";
                    $sql = '';

                    $connection = mysqli_connect($host, $user, $password, $database);
                    $error = mysqli_connect_error();


                    $product = $_GET['ISBN'];
                    $s = 'GROUP_CONCAT(DISTINCT CONCAT(bookauthors.nameF, \'#\', bookauthors.nameL, \'#\', bookauthors.AuthorID) SEPARATOR \'@\') as Authors';
                    $fil = "bookdescriptions.ISBN LIKE '%$product%'";
                    $sql = "SELECT *, $s FROM bookdescriptions INNER JOIN bookauthorsbooks ON bookdescriptions.ISBN = bookauthorsbooks.ISBN INNER JOIN bookauthors ON bookauthorsbooks.AuthorID = bookauthors.AuthorID INNER JOIN bookcategoriesbooks ON bookdescriptions.ISBN = bookcategoriesbooks.ISBN INNER JOIN bookcategories ON bookcategoriesbooks.CategoryID = bookcategories.CategoryID WHERE $fil";
                    $sql = $sql." GROUP BY bookauthorsbooks.ISBN";
                    $results = mysqli_query($connection, $sql);
                    $authors = '';
                    
                        while($row = mysqli_fetch_assoc($results)){
                            
                            if(!in_array($row['ISBN'],$filters)){
                                $title = $row['title'];
                                echo "<h2>$title</h2>";
                                echo "<div class = authorSeperation>";

                                $authorNames = explode('@', $row['Authors']);
                                $count = count($authorNames);
                                $inc = 1;
                                foreach($authorNames as $authorName){
                                    $fName = explode('#', $authorName)[0];
                                    $lName = explode('#', $authorName)[1];
                                    $id = explode('#', $authorName)[2];
                                    $name = $fName . " " . $lName;
                                    $authors = $authors . $name;
                                    echo "<a class = 'authorLink' href = '#' onclick=\"searchByAuthor('$id')\" id = 'authorLink' value = '$name'>" . $name . "</a>";
                                    
                                    if($inc<$count){
                                        $authors = $authors . " and ";
                                        echo " and ";  
                                    }
                                    $inc++;
                                }
                                echo "</div>";
                                echo "<br>";
                                $imgsrc = $row['ISBN'].".MED.jpg";
                                echo "<img src = img/$imgsrc>";

                                $category = $row['CategoryName'];
                                $publisher = $row['publisher'];
                                $pubdate = $row['pubdate'];
                                $edition = $row['edition'];
                                $pages = $row['pages'];
                                $price = $row['price'];
                                $ISBN = $row['ISBN'];

                                echo "
                                    <div class = 'table-responsive'>
                                    <table class = 'table table-striped table-bordered'>
                                    <tbody>
                                    <tr>
                                        <td>Category</td>
                                        <td>$category</td>
                                    </tr>
                                    <tr>
                                        <td>Author(s)</td>
                                        <td>$authors</td>
                                    </tr>
                                    <tr>
                                        <td>Publisher</td>
                                        <td>$publisher</td>
                                    </tr>
                                    <tr>
                                        <td>Publish Date</td>
                                        <td>$pubdate</td>
                                    </tr>
                                    <tr>
                                        <td>Edition</td>
                                        <td>$edition</td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td>$pages</td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>$price</td>
                                    </tr>
                                    <tr>
                                        <td>ISBN</td>
                                        <td>$ISBN</td>
                                    </tr>
                                    </tbody>
                                
                                </table>
                                </div>";
                                
                                echo $row['description'];
                    }
                    $filters[] = $row['ISBN'];
                    
                }
                    
                ?>
            </div>
        </div>
    </div>

    <footer>
    Copyright Carson Ricca <br><br>
    &copy; 2019-2020 BookSource Inc. <br><br>
    1234 Books Avenue <br><br>
    Kelowna, BC, V1V 3A4 <br><br>
    Phone: (888)-888-8888
    </footer>
    </body>
</html>