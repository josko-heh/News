<?php
if(isset($_POST['submit'])){ //check if works
    $errorMsg = "";

    $headline = $_POST['headline'];
    $summary = $_POST['summary'];
    $story = $_POST['story'];

    /*image upload*/
   /* $isUploaded = false;*/
    if(file_exists($_FILES['inputImage']['tmp_name']) || is_uploaded_file($_FILES['inputImage']['tmp_name'])) {
        $isUploaded = true;
        $target_dir = "images/";
        $img = $target_dir . basename($_FILES["inputImage"]["name"]);
        
        /*if(file_exists($img)){}
        else{                         -move_uploaded_file will replace old file*/
            if (move_uploaded_file($_FILES['inputImage']['tmp_name'], $img)) {} 
            else {
                $errorMsg = "Sorry, there was an error uploading your file.";
            }
        /*}*/
    }else{ $isUploaded = false; }

    $category = $_POST['category'];
    //if(isset($_POST['checkboxShow'])
    //$btnReset = ['reset'];
    //$btnSubmit = ['submit']
}
?>