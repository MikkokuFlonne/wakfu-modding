<?php


foreach ($colors as $color) { ?>
    <article>
        <h3> <span><?= $color->id ?></span> </h3>
        <div class="color-sample" style="background-color: rgba(<?= $color->red ?>, <?= $color->green ?>, <?= $color->blue ?>, <?= $color->alpha ?>);"></div>
        <h4>RGBA : <span>(<?= $color->red ?>, <?= $color->green ?>, <?= $color->blue ?>, <?= $color->alpha ?>)</span></h4>
        <h4>Hex : <span><?= sprintf("#%02X%02X%02X%02X", $color->red, $color->green, $color->blue, ($color->alpha*255/100)) ?></span></h4>
    </article>

<?php }




?>