<?php
namespace App\Entity;

class DbConfig implements DbConfigInterface {
    protected $servername = 'localhost';
    protected $username = 'root';
    protected $password = '12345';
    protected $dbname = 'users_symf';

    public function getServername() {
    return $this->servername;
    }
    public function getUsername() {
    return $this->username;
    }
    public function getPassword() {
    return $this->password;
    }
    public function getDbname() {
    return $this->dbname;
    }
}
