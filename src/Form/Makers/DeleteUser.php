<?php

namespace App\Form\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class DeleteUser {
    public function make(FormBuilderInterface $form) {
        return $form->add('id', HiddenType::class)
                ->add('sent', SubmitType::class, [
                    'label' => 'Ano', 
                    'attr' => ['data-button-side' => 'left']
                    ])
                ->add('cancel', ButtonType::class, [
                    'label' => 'Ne', 
                    'attr' => ['data-button-side' => 'right']
                    ])
                ;
    }
}
