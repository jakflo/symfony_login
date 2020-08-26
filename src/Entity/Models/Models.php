<?php

namespace App\Entity\Models;

class Models {
    /**
     *
     * @var Db_wrap 
     */
    protected $db;
    
    public function __construct(Db_wrap $db) {
        $this->db = $db;
    }
}
