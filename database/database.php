<?php
$config = require 'config.php';

$dbc = mysqli_connect($config["host"], $config["user"], $config["password"], $config["database"]) 
or die("Error connecting to MySQL server." . mysqli_connect_error());



/**
 * Gets newest articles from database
 * @param string $categoryname Articles from that category will be returned.
 * @param integer $numberOfArticles Number of articles return object will have.
 * @return mysqli_result object containing articles from $cateogryName category(case insensitive), there may be zero articles
 */
function getArticles($dbc, $categoryName, $numberOfArticles){
    $categoryName = strtoupper($categoryName);
    $query = "SELECT articles.* FROM articles
              JOIN categories ON articles.categoryId = categories.id
              WHERE UPPER(categories.name) = '$categoryName' AND isArchived = 0
              ORDER BY dateTime DESC
              LIMIT $numberOfArticles";

    $articles = mysqli_query($dbc, $query);
    
    if($articles == false) {
        mysqli_close($dbc);
        die("getArticles query error");
    }else {
        return $articles;
    }
}

/**
 * @param integer $numberOfCategories Number of categories that function will return.
 */
function getRandomCategoriesNames($dbc, $numberOfCategories){
    $query = "SELECT name FROM categories
              ORDER BY RAND()
              LIMIT $numberOfCategories";
    
    $result = mysqli_query($dbc, $query);

    $categoriesNames = array();

    if($result) {
        while($row = mysqli_fetch_array($result)){
            $categoryName = $row['name'];
            array_push($categoriesNames, $categoryName);
        }
    }else{
        mysqli_close($dbc);
        die("getRandomCategoriesNames query error");
    };

    return $categoriesNames;
}
?>