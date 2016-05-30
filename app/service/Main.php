<?php
require_once __DIR__."/../model/Picture.php";
require_once __DIR__."/../view/View.php";

class Main {

    private $view;
    private $picture ;
    
    function __construct() {
        $this->view = new View();
        $this->picture = new Picture();
    }
    
    function index() {
        $pictures = $this->picture->getLastPictures();
        return $this->view->generate('Main.php', $pictures);
    }
}