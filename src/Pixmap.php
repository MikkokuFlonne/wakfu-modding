<?php
namespace Src;

class Pixmap {

    public $id;
    public $width;
    public $height;
    public $x;
    public $y;
    public $texture;

    public function __construct($id, $width, $height, $x, $y, $texture){
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->x = $x;
        $this->y = $y;
        $this->texture = $texture;

    }
}