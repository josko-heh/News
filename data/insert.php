<?php
//--------------------get form data------------
if(isset($_POST['submit'])){

    $headline = $_POST['headline'];
    $summary = $_POST['summary'];
    $story = $_POST['story'];

    //--image upload
    if(file_exists($_FILES['inputImage']['tmp_name']) || is_uploaded_file($_FILES['inputImage']['tmp_name'])) {
        $target_dir = "../images/";
        $img = $target_dir . basename($_FILES["inputImage"]["name"]);
        
        /*if(file_exists($img)){}
        else{                         -move_uploaded_file will replace old file*/
            if (move_uploaded_file($_FILES['inputImage']['tmp_name'], $img)) {} 
            else {
                mysqli_close($dbc);
                die("Sorry, there was an error uploading your file.");
            }
        /*}*/
    }else{ 
        $img = null; 
    }

    $categoryName = $_POST['category'];
    
    
//-------------------storing article in database-------------
    include 'database.php';

    date_default_timezone_set('Europe/Zagreb');

    //---prepare $img for use in query---
    /*if(is_null($img)){
        $img = "null";  //inserts null
    }else{
        $img ='"' . $img. '"';  //adds '' for use in INSERT...VALUES()
    }*/

    //-----set categoryId------
    $categoryId = NULL;

    $query = "SELECT * FROM categories";
    $result = mysqli_query($dbc, $query);
    
    if($result) {
        $found = false;
        while($row = mysqli_fetch_array($result)){
            if(strcasecmp($categoryName,  $row['name']) == 0){      //tries to find article category(sent from form) in database by name; case insensitive
                $categoryId = $row['id'];
                $found = true; 
            }
        }
        if($found == false){ die("couldn't find category in database"); }
    }else{
        mysqli_close($dbc);
        die("set categoryId query error");
    }
    //------/categoryId-------

    //------set isArchived------
    if(isset($_POST['checkboxArchive'])){
        $isArchived = 1;
    }else { $isArchived = 0; }

    $dateTime = date('Y-m-d H:i:s');


    $query = "INSERT INTO articles (headline, summary, story, image, categoryId, isArchived, dateTime) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($dbc);

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'ssssiis', $headline, $summary, $story, $img, $categoryId, $isArchived, $dateTime);
    if(!mysqli_stmt_execute($stmt)){
        die("insert article query error");
    }
//-------get id from stored article and open it in new page---------
    $query = "SELECT id FROM articles
              ORDER BY dateTime DESC
              LIMIT 1";

    $result = mysqli_query($dbc, $query);
    
    if($result == false){
        //mysqli_close($dbc);
        die("select article id query error" . mysqli_error($dbc));
    }else {
        $row = mysqli_fetch_array($result);
        $articleId = $row['id'];
    }

    mysqli_close($dbc);
    header("Location: ../pages/article.php?id=$articleId");
}
?>