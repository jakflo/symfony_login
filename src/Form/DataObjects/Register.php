<?php
namespace App\Form\DataObjects;
use App\Entity\Models\Models;
use App\Entity\Models\UserModel;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\IsFalse;

class Register extends Models {
    use SetPassword;
    
    protected $name;    
    protected $agreeTerms;

    public function getName() {
    return $this->name;
    }    
    public function getAgreeTerms() {
    return $this->agreeTerms;
    }

    public function setName($name) {
    $this->name = $name;
    }
    
    public function setAgreeTerms($agreeTerms) {
    $this->agreeTerms = $agreeTerms;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        SetPassword::loadValidatorMetadata($metadata);
        $metadata->addPropertyConstraint('name', new NotBlank(['message' => 'Zadejte jméno']));
        $metadata->addPropertyConstraint('name', new Length(['max' => 45, 'maxMessage' => 'Jméno může mít nanejvýš 45 znaků']));
        $metadata->addGetterConstraint('userExists', new IsFalse(['message' => 'Tento uživatel již existuje']));        
        $metadata->addPropertyConstraint('agreeTerms', new IsTrue(['message' => 'Musíte souhlasit s podmínkami']));        
    }
    
    public function isUserExists() {
        $model = new UserModel($this->db);
        return $model->userExists($this->name);
    }
}
