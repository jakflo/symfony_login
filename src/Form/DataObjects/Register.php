<?php
namespace App\Form\DataObjects;
use App\Entity\Models\Models;
use App\Entity\Models\UserModel;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
        $metadata->addConstraint(new Callback('userExists'));        
        $metadata->addPropertyConstraint('agreeTerms', new IsTrue(['message' => 'Musíte souhlasit s podmínkami']));        
    }
    
    public function userExists(ExecutionContextInterface $context) {
        $model = new UserModel($this->db);
        if ($model->userExists($this->name)) {
            $context->buildViolation('Tento uživatel již existuje')
                    ->atPath('name')->addViolation();
        }       
    }
}
