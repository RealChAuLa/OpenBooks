<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Search</title>
</head>
<body>
    <form method="post">
        <input id="input" name="query" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
        <button type="submit">Get books!</button>
    </form>
    <br>
    <div id="output">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['query'])) {
            $query = urlencode($_POST['query']);
            $url = "http://openlibrary.org/search.json?q=" . $query;
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (isset($data['docs']) && count($data['docs']) > 0) {
                for ($i = 0; $i < min(5, count($data['docs'])); $i++) {
                    $title = htmlspecialchars($data['docs'][$i]['title']);
                    $author = htmlspecialchars($data['docs'][$i]['author_name'][0]);
                    $year = htmlspecialchars($data['docs'][$i]['first_publish_year']);
                    $isbn = htmlspecialchars($data['docs'][$i]['isbn'][0]);
                    $imgUrl = "http://covers.openlibrary.org/b/isbn/" . $isbn . "-M.jpg";

                    echo "<h2>" . $title . "</h2>";
                    echo $author . "<br>";
                    echo $isbn . "<br>";
                    echo $year . "<br>";
                    echo "<img src='" . $imgUrl . "'><br>";
                }
            } else {
                echo "No results found.";
            }
        }
        ?>
    </div>
</body>
</html>
//check one