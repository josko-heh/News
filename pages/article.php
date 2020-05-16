<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AMS</title>
    <link rel="icon" href="../favicon.png" type="image/png" sizes="16x16 32x32">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="article.css">
    <link rel="stylesheet" href="style.css">

    <?php
    include '../database/database.php';

    $articleId = $_GET['id'];

    $query =   "SELECT articles.*, categories.name AS cName
                FROM articles
                    JOIN categories ON articles.categoryId = categories.id
                WHERE articles.id = $articleId";

    $result = mysqli_query($dbc, $query);
    
    if($result == false){
        die("select article id query error" . mysqli_error($dbc));
    }else {
        $row = mysqli_fetch_array($result);

        $headline = $row['headline'];
        $summary = $row['summary'];
        $story = $row['story'];
        $img = $row['image'];
        $categoryName = $row['cName'];
    }

    ?>
</head>
<body>
    <header>
        <div class="wrapper">
            <h1><a id="BBClink" href="index.php"><i class="fas fa-globe-europe"></i>AMS</a></h1>
            <nav>
                <ul>
                    <li><a href="category.php?name=Sport"><i class="fas fa-running"></i><span>Sport</span></a></li>
                    <li><a href="category.php?name=Show"><i class="fas fa-money-bill-alt"></i><span>Show</span></a></li>
                    <li><a href="category.php?name=Science"><i class="fas fa-flask"></i><span>Science</span></a></li>
                    <li><a href="newArticle.html"><i class="fas fa-file-alt"></i><span>New article</span></a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="color" id="blue"></div>
    <main>
        <div class="wrapper">
            <h2><?php echo strtoupper($categoryName)?></h2>
            <section>
                <h3><?php echo $headline?></h3>
                <?php
                    if(!is_null($img)){ echo '<img src='.$img. ' alt="'.$headline.'">'; }
                ?>
                <summary><?php echo $summary ?></summary>
                <p><?php echo $story?></p>
            </section>
        </div>
    </main>    
    <footer>
        <div class="line-hr wrapper"></div>
        <div class="text wrapper">
            <b>Copyright © <?php echo date("Y")?> AMS.</b>
            <span>
                The AMS is fictional news site. 
                <a href="#">Our approach...</a>
            </span>
        </div>
    </footer>

    <?php mysqli_close($dbc)?>
</body>
</html>