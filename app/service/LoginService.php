<?php

class LoginService {
     
    private $userDao;
    
    function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }
    
    function index() {
        
    }
}