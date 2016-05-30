<?php
class Picture {

    private $picture;

    function __construct() {
        $this->picture = [
            '0'=>'/images/1.jpg',
            '1'=>'/images/2.jpg',
            '2'=>'/images/3.jpg',
            '3'=>'/images/4.jpg',
            '4'=>'/images/5.jpg'
        ];
    }

    function getPictureById($id) {
        return $this->picture[$id];
    }

    function getLastPictures() {
        return $this->picture;
    }
}