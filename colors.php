<?php
$title = "Colors";
$style = './assets/colors.css';

$file = 'colors.xml';

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


set_time_limit(500);

$json = file_get_contents('https://wakfu.cdn.ankama.com/gamedata/theme/theme.json');

$json = json_decode($json);

$colors = $json->colors;


$simplexml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><colors/>');



// dump($_POST);

if (!empty($_POST)) {

    if (isset($_POST['xml'])) {
        foreach ($_POST as $index => $hexa) {
            if ($index == "xml")
                continue;
            // dump($hexa);
            // dump($index);
            // dump($hexa['hexacode']);
            // dump($hexa['alpha']);
            // dump(sprintf("%02X", ($hexa['alpha'])*255));
            if ($index !== 'xml') {

                $couleur = $simplexml->addChild('color');
                $couleur->addAttribute('id', $index);
                $xmlcolor = $hexa["hexacode"];
                $xmlcolor .= sprintf("%02X", (intval($hexa["alpha"]) * 255));
                $couleur->addAttribute('color', $xmlcolor);
            }
        }
        file_put_contents('colors.xml', $simplexml->asXML());
        header('Location: colors.php');

    } else if (isset($_POST['default'])) {



        foreach ($colors as $color) {
            if ($color !==  'default') {

                $couleur = $simplexml->addChild('color');
                $couleur->addAttribute('id', $color->id);
                $couleur->addAttribute('color', sprintf("#%02X%02X%02X%02X", $color->red, $color->green, $color->blue, ($color->alpha * 255 / 100)));
            }
        }

        file_put_contents('colors.xml', $simplexml->asXML());
        header('Location: colors.php');

    }
}

?>

<main>
    <section id="colors">
        <h2>Colors</h2>
        <form method="POST">
            <?php
            foreach ($colors as $color) { ?>
                <fieldset>
                    <legend><?= $color->id ?></legend>
                    <div class="color-sample" id="<?= $color->id ?>[color-sample]" style="background-color: rgba(<?= $color->red ?>, <?= $color->green ?>, <?= $color->blue ?>, <?= $color->alpha ?>);"></div>
                    <label for="<?= $color->id ?>[hexacode]">Hexacode</label>

                    <input type="color" name="<?= $color->id ?>[hexacode]" id="<?= $color->id ?>[hexacode]" value="<?= sprintf("#%02X%02X%02X", $color->red, $color->green, $color->blue) ?>" onchange="changeColor(this.value, '<?= $color->id ?>[color-sample]')">

                    <label for="<?= $color->id ?>[alpha]">Alpha</label>

                    <input type="range" id="<?= $color->id ?>[alpha]" name="<?= $color->id ?>[alpha]" min="0" max="1" step="0.1" value="<?= $color->alpha ?>" onchange="updateColorAlpha(this.value, '<?= $color->id ?>[color-sample]')">
                    <button name="reset" class="reset" onclick="resetColor(<?= $color->red ?>, <?= $color->green ?>, <?= $color->blue ?>, '<?= $color->id ?>')"><i class="fa-solid fa-arrow-rotate-right"></i></button>
                </fieldset>

            <?php }
            ?>
            <div class="button">

                <button name="xml">Générer fichier XML</button>
                <button name="default">Générer fichier XML par défaut</button>
            </div>
        </form>



    </section>
    <script>
        function updateColorAlpha(alpha, id) {
            let color = document.getElementById(id).style.backgroundColor
            if (color.slice(0, 4) == 'rgba') {
                color = color.slice(0, -4)
                color = color + (alpha) + ")";
            } else {
                color = color.slice(0, -1);
                color = color + ", " + (alpha) + ")";
            }
            document.getElementById(id).style.backgroundColor = color;
        }

        function changeColor(color, id) {

            let couleur = document.getElementById(id).style.backgroundColor
            console.log(couleur);
            if (couleur.slice(0, 4) == 'rgba') {
                couleur = couleur.slice(0, -4)
            } else {
                couleur = couleur.slice(0, -1);
            }

            var aRgbHex = color.slice(1).match(/.{1,2}/g);
            var aRgb = [
                parseInt(aRgbHex[0], 16),
                parseInt(aRgbHex[1], 16),
                parseInt(aRgbHex[2], 16)
            ];
            let alpha = document.getElementById(id.replace('color-sample', 'alpha')).value;
            aRgb = aRgb.toString()
            document.getElementById(id).style.backgroundColor = 'rgba(' + aRgb + ', ' + alpha + ')';


        }


        let resets = document.getElementsByClassName("reset")

        for (let reset of resets) {
            reset.addEventListener("click", e => {
                e.preventDefault()
            })
        }

        function componentToHex(c) {
            let hex = c.toString(16);
            return hex.length == 1 ? "0" + hex : hex;
        }

        function rgbToHex(r, g, b) {
            return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
        }

        function resetColor(r, g, b, id) {
            let test = document.getElementsByName(id + '[hexacode]')
            console.log(test[0].value);
            test[0].value = rgbToHex(r, g, b)
            let rgb = r + ", " + g + ", " + b
            document.getElementById(id + '[color-sample]').style.backgroundColor = "rgb(" + rgb + ")"
            document.getElementById(id + '[alpha]').value = 100
        }
    </script>

</main>


<?php

require_once './partials/footer.php';
