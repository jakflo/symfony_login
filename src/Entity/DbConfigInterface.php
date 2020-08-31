<?php

namespace App\Entity;

interface DbConfigInterface {
    public function getServername();
    public function getUsername();
    public function getPassword();
    public function getDbname();
}
