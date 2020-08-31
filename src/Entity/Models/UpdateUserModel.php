<?php

namespace App\Entity\Models;
use App\utils\Protected_in;
use App\Entity\Models\Db_wrap;

class UpdateUserModel extends Models {
    /**
     *
     * @var int
     */
    protected $userId;
    
    public function __construct(Db_wrap $db, int $id) {
        parent::__construct($db);
        $this->userId = $id;
    }
    
    public function updateRoles(array $roles) {
        $this->deleteRoles();
        $roles = array_unique($roles);        
        if (count($roles) == 0) {
            return;
        }
        
        $protectedIn = new Protected_in;
        $c = 0;
        $values = array();
        foreach ($roles as $role) {
            $protectedIn->add_array("r{$c}", array($this->userId, $role));
            $values[] = "({$protectedIn->get_tokens("r{$c}")})";
            $c++;
        }
        $values = implode(',', $values);        
        $this->db->sendSQL(
                "insert into user_has_role(user_id, role) value {$values}", 
                        $protectedIn->get_data()                        
                );
    }
    
    public function deleteUser() {
        $this->db->sendSQL('delete from users where id=?', array($this->userId));
        $this->deleteRoles();
    }
    
    public function deleteRoles() {
        $this->db->sendSQL('delete from user_has_role where user_id=?', array($this->userId));        
    }
    
    public function updatePassword(string $newPassEncoded) {
        $this->db->sendSQL(
                'update users set password=:pass where id=:id',
                array(':pass' => $newPassEncoded, ':id' => $this->userId)
                );
    }
    
    public function getName() {
        return $this->db->dotaz_hodnota(
                'SELECT name FROM users where id=?', 
                array($this->userId)
                );        
    }
}
