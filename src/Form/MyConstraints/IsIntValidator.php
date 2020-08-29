<?php

namespace App\Forms\MyConstraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\utils\StringTools;

class IsIntValidator extends ConstraintValidator {
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        $stringTools = new StringTools;
        if (!$stringTools->isInt($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }        
    }    
}
