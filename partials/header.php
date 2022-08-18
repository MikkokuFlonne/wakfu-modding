<?php
require_once "./vendor/autoload.php";


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/bedc8cf35d.js" crossorigin="anonymous"></script>
    <title>Wakfu Modding | <?php
                                if (isset($title)) {
                                    echo $title;
                                }
                                ?></title>
    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./assets/style.css">
    <?php
    if (isset($style)) {
        echo '<link rel="stylesheet" href="' . $style . '">';
    }

    ?>



</head>

<body>
    <div class="container">

        <header>
            <h1>Wakfu Modding Tools</h1>
            <nav>
                <ul>
                    <li><a href="./colors.php">Colors</a></li>
                    <li><a href="./pixmap.php">Pixmap</a></li>
                    <li><a href="./texture.php">Texture Pack</a></li>
                </ul>
            </nav>

        </header>