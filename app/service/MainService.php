<?php
require_once __DIR__."/../model/PictureDao.php";

class MainService {
    
    private $pictureDao;
    
    function __construct(PictureDao $pictureDao) {
        $this->pictureDao = $pictureDao;
    }
    
    function index() {
        $pictures = $this->pictureDao->getLast(0, 20);
        return $pictures;
    }

    function previewPicture($pictureId) {
        $pictureData =  $this->pictureDao->getById($pictureId);
        if ($pictureData !== null) {
            //PLACEHOLDER
            return "FOUND";
        } else {
            return "NOT FOUND";
        }
    }

}