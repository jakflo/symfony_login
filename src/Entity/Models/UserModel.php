<?php

namespace App\Entity\Models;
use App\Security\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
                'select name, password from users where name=?', 
                array($name)
                );
        if (!$row) {
            return false;
        }
        $user->setName($row['name'])->setPassword($row['password']);
        return $user;
    }
    
    public function userExists(string $name) {
        return $this->db->dotaz_hodnota('select count(*) from users where name=?', array($name)) > 0;
    }
    
    public function updatePassword(UserPasswordEncoderInterface $passwordEncoder, User $user, string $newPassword) {
        $newPass = $passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($newPass);
        $this->db->sendSQL(
                'update users set password=:pass where name=:name',
                array(':pass' => $newPass, ':name' => $user->getName())
                );        
    }
}
