<?php

class LoginService {
     
    private $userDao;
    
    function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }
    
    function index() {
        
    }

    function auth($username, $pass) {
        $user = $this->userDao->getByUsername($username);
        if ($user !== null) {
            $pass = hash('sha256', $pass);
            if ($pass == $user["pass"]) {
                return true;
            }
        }
        return false;
    }
}