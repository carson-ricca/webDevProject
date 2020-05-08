<!DOCTYPE html>
<html>
<body>
<head lang = "en">
    <meta charset = "utf-8">
    <title>BookSource</title>
</head>
<?php

    $host = "cosc499.ok.ubc.ca";
    $database = "db_project";
    $user = "webuser";
    $password = "9UcM0QQcK1BwAXLk";
    $sql = '';

    $connection = mysqli_connect($host, $user, $password, $database);
    $error = mysqli_connect_error();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST['searchInput1'])){
            $searchInput ='';
        }
        else{
            $searchInput = $_POST['searchInput1'];
        }
        if(empty($_POST['linkInput1'])){
            $linkInput = '';
        }
        else{
            $linkInput = $_POST['linkInput1'];
        }
        if(empty($_POST['linkInput2'])){
            $authorInput = '';
        }
        else{
            $authorInput = $_POST['linkInput2'];
        }
        if(empty($_POST['all'])){
            $all = null;
        }
        else{
            $all = $_POST['all'];
        }
      }
    if($error != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
      }

    $filters = Array();  
    
    if(isset($all)){
        $s = 'GROUP_CONCAT(DISTINCT CONCAT(bookauthors.nameF, \'#\', bookauthors.nameL, \'#\', bookauthors.AuthorID) SEPARATOR \'@\') as Authors';
        $sql = "SELECT *, $s FROM bookdescriptions INNER JOIN bookauthorsbooks ON bookdescriptions.ISBN = bookauthorsbooks.ISBN INNER JOIN bookauthors ON bookauthorsbooks.AuthorID = bookauthors.AuthorID INNER JOIN bookcategoriesbooks ON bookdescriptions.ISBN = bookcategoriesbooks.ISBN INNER JOIN bookcategories ON bookcategoriesbooks.CategoryID = bookcategories.CategoryID";
        $sql = $sql." GROUP BY bookauthorsbooks.ISBN";

        $results = mysqli_query($connection, $sql);
        
        while($row = mysqli_fetch_assoc($results)){
            if(!in_array($row['ISBN'], $filters)){
                echo "<div class = 'panel panel-default'>";
                $ISBN = $row['ISBN'];
                $title = $row['title'];
                echo "<div class = 'panel-heading'>";
                echo "<a class = 'titleLink' href = 'product.php?ISBN=$ISBN' value = '$title'>" . $title . "</a>";
                echo "</div>";
                $authorNames = explode('@', $row['Authors']);

                echo "<div class = 'panel-body'>";
                $count = count($authorNames);
                $inc = 1;
                foreach($authorNames as $authorName){
                    $fName = explode('#', $authorName)[0];
                    $lName = explode('#', $authorName)[1];
                    $id = explode('#', $authorName)[2];
                    $name = $fName . " " . $lName;
                    echo "<a class = 'authorLink' href = '#' onclick=\"searchByAuthor('$id')\" id = 'authorLink' value = '$name'>" . $name . "</a>";
                    if($inc<$count){
                        echo " and ";
                    }
                    $inc++;
                }
                echo "<br>";
            
                $imgsrc = $row['ISBN'].".THUMB.jpg";
                echo "<img class = 'thumbnailImage' src = img/$imgsrc>";
                
                            
                $shortDesc = substr($row['description'], 0, 250) . " ";             
                echo $shortDesc;
                echo "<a class = 'moreLink' href = 'product.php?ISBN=$ISBN' value = 'More'>" . "More" . "</a><br>";
                echo "</div></div>"; 
            }
            $filters[] = $row['ISBN'];
        }
    }

    if(isset($searchInput) && !empty($searchInput)){
        $s = 'GROUP_CONCAT(DISTINCT CONCAT(bookauthors.nameF, \'#\', bookauthors.nameL, \'#\', bookauthors.AuthorID) SEPARATOR \'@\') as Authors';
        $fil = "title LIKE '%$searchInput%' OR (bookauthors.nameF LIKE '%$searchInput%') OR (bookauthors.nameL LIKE '%$searchInput%') OR bookcategories.CategoryName LIKE '%$searchInput%'";
        $sql = "SELECT *, $s FROM bookdescriptions INNER JOIN bookauthorsbooks ON bookdescriptions.ISBN = bookauthorsbooks.ISBN INNER JOIN bookauthors ON bookauthorsbooks.AuthorID = bookauthors.AuthorID INNER JOIN bookcategoriesbooks ON bookdescriptions.ISBN = bookcategoriesbooks.ISBN INNER JOIN bookcategories ON bookcategoriesbooks.CategoryID = bookcategories.CategoryID WHERE $fil";
        $sql = $sql." GROUP BY bookauthorsbooks.ISBN";

        $results = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($results)){
            if(!in_array($row['ISBN'], $filters)){
                echo "<div class = 'panel panel-default'>";
                $ISBN = $row['ISBN'];
                $title = $row['title'];
                echo "<div class = 'panel-heading'>";
                echo "<a class = 'titleLink' href = 'product.php?ISBN=$ISBN' value = '$title'>" . $title . "</a>";
                echo "</div>";
                $authorNames = explode('@', $row['Authors']);

                echo "<div class = 'panel-body'>";
                $count = count($authorNames);
                $inc = 1;
                foreach($authorNames as $authorName){
                    $fName = explode('#', $authorName)[0];
                    $lName = explode('#', $authorName)[1];
                    $id = explode('#', $authorName)[2];
                    $name = $fName . " " . $lName;
                    echo "<a class = 'authorLink' href = '#' onclick=\"searchByAuthor('$id')\" id = 'authorLink' value = '$name'>" . $name . "</a>";
                    if($inc<$count){
                        echo " and ";
                    }
                    $inc++;
                }
                echo "<br>";
            
                $imgsrc = $row['ISBN'].".THUMB.jpg";
                echo "<img class = 'thumbnailImage' src = img/$imgsrc>";
                
                            
                $shortDesc = substr($row['description'], 0, 250) . " ";             
                echo $shortDesc;
                echo "<a class = 'moreLink' href = 'product.php?ISBN=$ISBN' value = 'More'>" . "More" . "</a><br>";
                echo "</div></div>"; 
            }
            $filters[] = $row['ISBN'];
        }
    }
    if(isset($linkInput) && !empty($linkInput)){
        $s = 'GROUP_CONCAT(DISTINCT CONCAT(bookauthors.nameF, \'#\', bookauthors.nameL, \'#\', bookauthors.AuthorID) SEPARATOR \'@\') as Authors';
        $fil = "bookcategories.CategoryName LIKE '%$linkInput%'";
        $sql = "SELECT *, $s FROM bookdescriptions INNER JOIN bookauthorsbooks ON bookdescriptions.ISBN = bookauthorsbooks.ISBN INNER JOIN bookauthors ON bookauthorsbooks.AuthorID = bookauthors.AuthorID INNER JOIN bookcategoriesbooks ON bookdescriptions.ISBN = bookcategoriesbooks.ISBN INNER JOIN bookcategories ON bookcategoriesbooks.CategoryID = bookcategories.CategoryID WHERE $fil";
        $sql = $sql." GROUP BY bookauthorsbooks.ISBN";
        
        $results = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($results)){
            if(!in_array($row['ISBN'], $filters)){
                echo "<div class = 'panel panel-default'>";
                $ISBN = $row['ISBN'];
                $title = $row['title'];
                echo "<div class = 'panel-heading'>";
                echo "<a class = 'titleLink' href = 'product.php?ISBN=$ISBN' value = '$title'>" . $title . "</a>";
                echo "</div>";
                $authorNames = explode('@', $row['Authors']);

                echo "<div class = 'panel-body'>";
                $count = count($authorNames);
                $inc = 1;
                foreach($authorNames as $authorName){
                    $fName = explode('#', $authorName)[0];
                    $lName = explode('#', $authorName)[1];
                    $id = explode('#', $authorName)[2];
                    $name = $fName . " " . $lName;
                    echo "<a class = 'authorLink' href = '#' onclick=\"searchByAuthor('$id')\" id = 'authorLink' value = '$name'>" . $name . "</a>";
                    if($inc<$count){
                        echo " and ";
                    }
                    $inc++;
                }
                echo "<br>";
            
                $imgsrc = $row['ISBN'].".THUMB.jpg";
                echo "<img class = 'thumbnailImage' src = img/$imgsrc>";
                
                            
                $shortDesc = substr($row['description'], 0, 250) . " ";             
                echo $shortDesc;
                echo "<a class = 'moreLink' href = 'product.php?ISBN=$ISBN' value = 'More'>" . "More" . "</a><br>";
                echo "</div></div>"; 
            }
            $filters[] = $row['ISBN'];
        }
    }
    if(isset($authorInput) && !empty($authorInput)){
        $s = 'GROUP_CONCAT(DISTINCT CONCAT(bookauthors.nameF, \'#\', bookauthors.nameL, \'#\', bookauthors.AuthorID) SEPARATOR \'@\') as Authors';
        $fil = "bookauthors.authorID = $authorInput";
        $sql = "SELECT *, $s FROM bookdescriptions INNER JOIN bookauthorsbooks ON bookdescriptions.ISBN = bookauthorsbooks.ISBN INNER JOIN bookauthors ON bookauthorsbooks.AuthorID = bookauthors.AuthorID INNER JOIN bookcategoriesbooks ON bookdescriptions.ISBN = bookcategoriesbooks.ISBN INNER JOIN bookcategories ON bookcategoriesbooks.CategoryID = bookcategories.CategoryID WHERE $fil";
        $sql = $sql." GROUP BY bookauthorsbooks.ISBN";
        
        $results = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($results)){
            if(!in_array($row['ISBN'], $filters)){
                echo "<div class = 'panel panel-default'>";
                $ISBN = $row['ISBN'];
                $title = $row['title'];
                echo "<div class = 'panel-heading'>";
                echo "<a class = 'titleLink' href = 'product.php?ISBN=$ISBN' value = '$title'>" . $title . "</a>";
                echo "</div>";
                $authorNames = explode('@', $row['Authors']);

                echo "<div class = 'panel-body'>";
                $count = count($authorNames);
                $inc = 1;
                foreach($authorNames as $authorName){
                    $fName = explode('#', $authorName)[0];
                    $lName = explode('#', $authorName)[1];
                    $id = explode('#', $authorName)[2];
                    $name = $fName . " " . $lName;
                    echo "<a class = 'authorLink' href = '#' onclick=\"searchByAuthor('$id')\" id = 'authorLink' value = '$name'>" . $name . "</a>";
                    if($inc<$count){
                        echo " and ";
                    }
                    $inc++;
                }
                echo "<br>";
            
                $imgsrc = $row['ISBN'].".THUMB.jpg";
                echo "<img class = 'thumbnailImage' src = img/$imgsrc>";
                
                            
                $shortDesc = substr($row['description'], 0, 250) . " ";             
                echo $shortDesc;
                echo "<a class = 'moreLink' href = 'product.php?ISBN=$ISBN' value = 'More'>" . "More" . "</a><br>";
                echo "</div></div>"; 
            }
            $filters[] = $row['ISBN'];
        }
    }
?>
</body>
</html>