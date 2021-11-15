<?php
set_time_limit(500);

$json = file_get_contents('./theme.json');

$json = json_decode($json);

$colors = $json->colors;

$simplexml= new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><colors/>');


foreach ($colors as $color) { 

$couleur= $simplexml->addChild('color');
$couleur->addAttribute('id', $color->id);
$couleur->addAttribute('color', sprintf("#%02X%02X%02X%02X", $color->red, $color->green, $color->blue, ($color->alpha*255/100)));

}

file_put_contents('colors.xml', $simplexml->asXML());
