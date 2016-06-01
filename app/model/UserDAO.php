<?php

class UserDao {

    private $usersCollection;

    function __construct(\MongoDB\Database $db) {
        $this->usersCollection = $db->selectCollection("users");
    }

    function getByUsername($username) {
        $user = $this->usersCollection->findOne(["username" => $username]);
        return $user;
    }

}