<?php
class RegistrationService {
    
    private $userDao;
    
    public function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }
    
    public function createNewUser($userInfo) {
        $userInfo['password'] = hash('sha256', $userInfo["password"]);
        $this->userDao->createNewUser($userInfo);
    }
}