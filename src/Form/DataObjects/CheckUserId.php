<?php

namespace App\Form\DataObjects;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Forms\MyConstraints\IsInt;
use App\Entity\Models\UserModel;
use App\Security\User;
use App\utils\StringTools;

trait CheckUserId {
    /**
     * 
     * @var UserModel
     */
    protected $userModel;
        
    /**
     *
     * @var User
     */
    protected $user;
    
    public function __construct(UserModel $userModel, User $user) {
        $this->userModel = $userModel;
        $this->user = $user;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('id', new NotBlank(['message' => 'Id uživatele nenalezeno']));
        $metadata->addPropertyConstraint('id', new IsInt(['message' => 'Id uživatele nenalezeno']));
        $metadata->addGetterConstraint('notLogged', new IsTrue(['message' => 'Nemožno editovat současně přihlášeného uživatele']));
        $metadata->addGetterConstraint('idExists', new IsTrue(['message' => 'Id uživatele nenalezeno']));        
    }
    
    public function isIdExists() {
        $stringTools = new StringTools;
        if (!$stringTools->isInt($this->id)) {
            return true;
        }
        return $this->userModel->userExistsById($this->id);
    }
    
    public function isNotLogged() {
        return $this->id != $this->user->getId();
    }
}
