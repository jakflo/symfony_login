<?php

namespace App\Form\DataObjects;

class DeleteUser {
    use CheckUserId;
    
    protected $id;

    public function getId() {
    return $this->id;
    }

    public function setId($id) {
    $this->id = $id;
    }   

}
