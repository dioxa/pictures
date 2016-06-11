<?php

class UserDao {

    private $usersCollection;

    function __construct(\MongoDB\Database $db) {
        $this->usersCollection = $db->selectCollection("users");
    }

    function createNewUser($userInfo) {
        $this->usersCollection->insertOne(["username" => $userInfo['username'], "pass" => $userInfo['password'],
            "name" => $userInfo['firstname'], "lastname" => $userInfo['lastname']]);
    }
    
    function getByUsername($username) {
        $user = $this->usersCollection->findOne(["username" => $username]);
        return $user;
    }

}