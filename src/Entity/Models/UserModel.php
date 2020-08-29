<?php

namespace App\Entity\Models;
use App\Security\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\utils\ArrayTools;

class UserModel extends Models {
    public function register(User $user) {
        $this->db->sendSQL(
                'insert into users(name, password) value(?, ?)', 
                array($user->getName(), $user->getPassword())
                );
    }
    
    public function getUserByName(string $name) {
        $user = new User;
        $row = $this->db->dotaz_radek(
                'select id, name, password from users where name=?', 
                array($name)
                );
        if (!$row) {
            return false;
        }
        $roles = $this->db->dotaz_sloupec(
                'select r.name from user_has_role ur join roles r on ur.role=r.id where user_id=?', 
                'name', array($row['id'])
                );
        $user->setName($row['name'])->setPassword($row['password'])->setId($row['id']);
        if ($roles) {
            $user->setRoles($roles);
        }
        return $user;
    }
    
    public function userExists(string $name) {
        return $this->db->dotaz_hodnota('select count(*) from users where name=?', array($name)) > 0;
    }
    
    public function userExistsById(int $id) {
        return $this->db->dotaz_hodnota('select count(*) from users where id=?', array($id)) > 0;
    }
    
    public function updatePassword(UserPasswordEncoderInterface $passwordEncoder, User $user, string $newPassword) {
        $newPassEncoded = $passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($newPassEncoded);
        $this->db->sendSQL(
                'update users set password=:pass where id=:id',
                array(':pass' => $newPassEncoded, ':id' => $user->getId())
                );
    }
    
    public function getUserList() {
        $arrayTools = new ArrayTools;
        $users = $this->db->dotaz_vse('SELECT id, name FROM users order by id');
        if (!$users) {
            return false;
        }
        $roles = $this->db->dotaz_vse('select ur.user_id as id, r.id as role_id 
                from user_has_role ur join roles r on ur.role=r.id order by id');
        foreach ($users as $k => &$v) {
            $userHasRole = array_column($arrayTools->searchValue($roles, $v['id'], 'id'), 'role_id');
            if (count($userHasRole) > 0) {
                $v['roles'] = array_merge(array(1), $userHasRole);
            }
            else {
                $v['roles'] = array(1);
            }
        }
        return $users;
    }
}
