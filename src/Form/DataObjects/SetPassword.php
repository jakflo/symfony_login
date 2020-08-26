<?php

namespace App\Form\DataObjects;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Mapping\ClassMetadata;

trait SetPassword {
    protected $plainPassword;
    protected $plainPasswordAgain;
    
    public function getPlainPassword() {
    return $this->plainPassword;
    }
    public function getPlainPasswordAgain() {
    return $this->plainPasswordAgain;
    }
    
    public function setPlainPassword($plainPassword) {
    $this->plainPassword = $plainPassword;
    }
    public function setPlainPasswordAgain($plainPasswordAgain) {
    $this->plainPasswordAgain = $plainPasswordAgain;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {        
        $metadata->addPropertyConstraint('plainPassword', new NotBlank(['message' => 'Zadejte heslo']));
        $metadata->addPropertyConstraint('plainPassword', new Length([
            'min' => 6,
            'max' => 1024,
            'minMessage' => 'Heslo musí mít nejméně 6 znaků',
            'maxMessage' => 'Heslo může mít nanejvýš 1024 znaků'
        ]));        
        $metadata->addGetterConstraint('passwordsMatches', new IsTrue(['message' => 'Hesla se neshodují']));
        $metadata->addPropertyConstraint('plainPasswordAgain', new NotBlank(['message' => 'Potvrďte heslo']));                
    }
    
    public function isPasswordsMatches() {
        return $this->plainPassword == $this->plainPasswordAgain;
    }
}
