<?php
require_once __DIR__."/../model/PictureDao.php";
require_once __DIR__."/../view/View.php";

class MainService {

    private $view;
    private $pictureDao;
    
    function __construct(PictureDao $pictureDao) {
        $this->view = new View();
        $this->pictureDao = $pictureDao;
    }
    
    function index() {
        $pictures = $this->pictureDao->getLastPictures(0, 20);
        return $pictures;
    }

    function previewPicture($pictureId) {
        $pictureData =  $this->pictureDao->getPictureById($pictureId);
        if ($pictureData !== null) {
            //PLACEHOLDER
            return "FOUND";
        } else {
            return "NOT FOUND";
        }
    }

}