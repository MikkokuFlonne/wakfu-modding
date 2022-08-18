<?php
use Src\Pixmap;

$title = "Pixmap";

require_once './partials/header.php';

$json = file_get_contents('./theme.json');

$json = json_decode($json);

$themeElements = $json->themeElement;
$themeEl = [];


foreach ($themeElements as $themeElement) {
    $element = [];

    if ($themeElement->specificPixmaps == [] && $themeElement->childrenThemeElements == []) {
    } else if ($themeElement->specificPixmaps != []) {

        $specificPixmaps = $themeElement->specificPixmaps;
        $data = ["id" => $themeElement->id];
        $width = 0;
        $height = 0;
        $texture = "";
        $x = 0;
        $y = 0;

        foreach ($specificPixmaps as $sPix) {
            dump($sPix);
            $width += $sPix->width;
            $height += $sPix->height;
            if($texture == null){
                $texture = $sPix->texture;
            }
            if (count($specificPixmaps) > 1) {
                $x = $sPix->x;
                $y = $sPix->y;
            } else if ($sPix->position == "NORTH_WEST") {
                $x = $sPix->x;
                $y = $sPix->y;
            }
        }
        $pix = new Pixmap($themeElement->id, $width, $height, $x, $y, $texture);
        $data[] = ["width" => $width];
        $data[] = ["height" => $height];
        $themeEl[] = $pix;
    } else if ($themeElement->specificPixmaps == []) {
        $themeEl[] = $themeElement;
    }
}

$myJSON = json_encode($themeEl);

file_put_contents("themeEl.json", $myJSON);

?>

<?php

require_once './partials/footer.php';
