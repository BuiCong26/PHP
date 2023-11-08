<?php

namespace App\Models;

use Core\Model;
use PDO;


class User extends Model
{
    private $id;
    private $email;
    private $password;
    private $role;


    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        $this->id = $id;
    }

    function getEmail()
    {
        return $this->email;
    }
    function setEmail($email)
    {
        $this->email = $email;
    }

    function getPwd()
    {
        return $this->password;
    }
    function setPwd($password)
    {
        $this->password = $password;
    }

    function getRole()
    {
        return $this->role;
    }
    function setRole($role)
    {
        $this->role = $role;
    }


    public static function login($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);     
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetch();
    }
}