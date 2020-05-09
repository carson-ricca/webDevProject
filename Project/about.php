<!DOCTYPE html>
<html lang = "en">
<html head = "en">
<meta charset = "utf-8">

    <!-- Ensures proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BookSource</title>
    <!-- JQuery and JavaScript Files -->
    <script src= "http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type = "text/javascript" src = "search.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "CSS/about.css">

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
                    <li><a href = "about.php">About Us</a></li>
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
                    $host = "localhost";
                    $database = "db_project";
                    $user = "root";
                    $password = "";
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

        </div>

    </div>
</div>   
</body>
</html>
