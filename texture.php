<?php

$title = "Texture Pack";
$style = './assets/texture.css';
$file = 'texturePack.zip';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);
    exit;
}


require_once './partials/header.php';

$baseURL = "https://wakfu.cdn.ankama.com/gamedata/";

$json = file_get_contents('https://wakfu.cdn.ankama.com/gamedata/theme/theme.json');

$json = json_decode($json);

$textures = $json->textures;

function createFile($filename, $url){

    file_put_contents($filename . ".png", file_get_contents($url));
}

$myzip = new ZipArchive;

if(isset($_POST["download"])){
    foreach($textures as $texture){
        $path = $texture->path;
        $path = substr($path, 0, -3);
        $path = $path . "png";

        createFile("./texturePack/" . $texture->id, $baseURL . $path);

        if ($myzip->open('texturePack.zip', ZipArchive::CREATE) === TRUE) {
            $myzip->addFile("./texturePack/" . $texture->id . ".png");
        }
    }
    $myzip->close();
    header('Location: texture.php');
}


?>

    <main>
        <section id="textures">
            <h2>Texture Pack</h2>


            <div>

                <?php
                foreach ($textures as $texture) {
                    $path = $texture->path;
                    $path = substr($path, 0, -3);
                    $path = $path . "png";
                ?>
                    <figure>
                        <img src="<?= $baseURL . $path ?>" alt="">
                        <figcaption><?= $texture->id ?>
                            <a href="./texturePack/<?= $texture->id ?>.png" download="<?= $texture->id ?>">
                                <button type="button"><i class="fa-solid fa-download"></i></button>
                            </a>
                        </figcaption>
                    </figure>
            <?php

            }
             ?>
            </div>
            <form action="" method="POST">
                <button name="download">Télécharger l'ensemble des textures </button>

            </form>

        </section>
    </main>

    <?php

    require_once './partials/footer.php';
