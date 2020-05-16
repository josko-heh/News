<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AMS</title>
    <link rel="icon" href="../favicon.png" type="image/png" sizes="16x16 32x32">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="category.css">
    <link rel="stylesheet" href="style.css">

    <?php
include '../database/database.php';
$categoryName = $_GET['name'];

function displayArticles($dbc, $categoryName){
    $showArticles = 2; //number of articles per row

    function tab($num){
        $tabs = "";
        for ($i = 0; $i < $num; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    $articles = getArticles($dbc, $categoryName, 20);

    $articleCounter = 0;
    for ($i=0; $i < mysqli_num_rows($articles); $i++) {
        
        if($articleCounter == 0){
            echo
                tab(4) . '<div class="row">' . "\r\n";
        }

        if($article = mysqli_fetch_array($articles)){   //if there are articles left in $articles
            echo
                tab(5) . '<article class="col">' . "\r\n" .
                    tab(6) . '<a href="article.php?id=' . $article['id'] . '">' . "\r\n" .
                        tab(7) . '<div>' . "\r\n" .
                            tab(8) . '<div>' . "\r\n" .
                                tab(9) . '<img src="' . $article['image'] . '">' . "\r\n" .
                            tab(8) . '</div>' . "\r\n" .
                        tab(7) . '</div>' . "\r\n" .
                        tab(7) . '<h4>' . $article['headline'] . '</h4>' . "\r\n" .
                        tab(7) . '<p>' . $article['summary'] . '</p>' . "\r\n" .
                    tab(6) . '</a>' . "\r\n" .
                tab(5) . '</article>' . "\r\n";
                
            $articleCounter++;
        }

        if ($articleCounter == $showArticles) {
            echo
                tab(4) . '</div>' . "\r\n";
                $articleCounter = 0;
        }
    }
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
            <h2><?php echo strtoupper($categoryName)?></h2>                <!-- set name GET[] $categoryName-->
            <?php displayArticles($dbc, $categoryName) ?>
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

    <script type="text/javascript">
    {
        let j = 0;
        let row = null;
        while(row = document.querySelector("main div[class='row']:nth-of-type("+(j+1)+")")){

            let i=0;
            let img = null;
            while (img = row.querySelector("article:nth-of-type("+(i+1)+") img")) {
                if(img.naturalWidth >= img.naturalHeight){
                    img.classList.add("horizontal")

                    maxWidth = 200 * img.naturalWidth / img.naturalHeight;
                    maxWidth = maxWidth.toFixed(2);
                    img.style.maxWidth = maxWidth.toString() + "px";
                }else{
                    img.classList.add("vertical")
                }

                i++;
            }

            j++;
        }
    }
    </script>
</body>
</html>