<?php

namespace App\Entity\Models;
use App\Entity\Models\Db_wrap;
use App\Exception\RolesException;
use App\utils\ArrayTools;

class UserRoles extends Models {
    protected $roles;

    public function __construct(Db_wrap $db) {
        parent::__construct($db);
        $this->roles = $this->db->dotaz_vse('SELECT * FROM roles');
        if (!$this->roles) {
            throw new RolesException("DB table roles can't be empty");
        }
    }
    
    public function getName(int $roleId) {
        return $this->getRoleRow($roleId)[0]['name'];
    }
    
    public function getCzName(int $roleId) {
        return $this->getRoleRow($roleId)[0]['name_cz'];
    }
    
    protected function getRoleRow(int $roleId) {
        $arrayTools = new ArrayTools;
        $role = $arrayTools->searchValue($this->roles, $roleId, 'id');
        if (count($role) == 0) {
            throw new RolesException("Role id {$roleId} not found in DB table roles");
        }
        return $role;
    }
    
    public function getChoices() {
        $result = array();
        foreach ($this->roles as $role) {
            $result[$role['name_cz']] = $role['id'];
        }
        return $result;
    }
    
    public function idExists(int $id) {
        $validIds = array_column($this->roles, 'id');
        return in_array($id, $validIds);
    }
    
}
