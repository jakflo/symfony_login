<?php

namespace App\Forms\MyConstraints;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 */
class IsInt extends Constraint {
    public $message = 'Požadováno celé číslo.';
}
