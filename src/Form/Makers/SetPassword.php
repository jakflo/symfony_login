<?php
namespace App\Form\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SetPassword {
    public function make(FormBuilderInterface $form) {
        return $form                
                ->add('plainPassword', PasswordType::class, ['label' => 'Heslo'])
                ->add('plainPasswordAgain', PasswordType::class, ['label' => 'Heslo znova'])                
                ;
    }
}
