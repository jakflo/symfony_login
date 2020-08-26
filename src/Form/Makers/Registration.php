<?php
namespace App\Form\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Makers\SetPassword;

class Registration {
    public function make(FormBuilderInterface $form) {
        $setPasswordMaker = new SetPassword;
        $form->add('name', TextType::class, ['label' => 'Jméno']);
        return $setPasswordMaker->make($form)            
            ->add('agreeTerms', CheckboxType::class, ['label' => 'Souhlasím s podmínkami'])
            ->add('sent', SubmitType::class, ['label' => 'Registrovat'])                
            ;
        
    }
}
