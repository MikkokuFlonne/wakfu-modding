<?php
$title = "Colors";
$style = './assets/colors.css';

require_once './partials/header.php';


set_time_limit(500);

$json = file_get_contents('./theme.json');

$json = json_decode($json);

$colors = $json->colors;

$simplexml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><colors/>');
if (!empty($_POST)) {

    if (isset($_POST['xml'])) {
        foreach ($_POST as $index => $hexa) {
            if ($index == "xml")
                continue;
            // dump($hexa);
            // dump($hexa['hexacode']);
            // // dump($hexa['alpha']);
            // dump(sprintf("%02X", ($hexa['alpha'])*255));

            $couleur = $simplexml->addChild('color');
            $couleur->addAttribute('id', $index);
            $xmlcolor = $hexa["hexacode"];
            $xmlcolor .= sprintf("%02X", (intval($hexa["alpha"]) * 255));
            $couleur->addAttribute('color',$xmlcolor);
        }
        file_put_contents('colors.xml', $simplexml->asXML());
    } else if (isset($_POST['default'])) {

        $simplexml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><colors/>');


        foreach ($colors as $color) {

            $couleur = $simplexml->addChild('color');
            $couleur->addAttribute('id', $color->id);
            $couleur->addAttribute('color', sprintf("#%02X%02X%02X%02X", $color->red, $color->green, $color->blue, ($color->alpha * 255 / 100)));
        }

        file_put_contents('colors.xml', $simplexml->asXML());
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

                </fieldset>

            <?php }
            ?>
            <button name="xml">Générer fichier XML</button>
            <button name="default">Générer fichier XML par défaut</button>
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
    </script>

</main>


<?php

require_once './partials/footer.php';
