<?php

namespace App\Form\DataObjects;

class ChangeRoles {
    use CheckUserId;
    
    protected $id;
    protected $userRole;   

    public function getId() {
    return $this->id;
    }
    public function getUserRole() {
    return $this->userRole;
    }

    public function setId($id) {
    $this->id = $id;
    }
    public function setUserRole($userRole) {
    $this->userRole = $userRole;
    }    
}
