<?php
namespace App\Form\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Makers\SetPassword;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePassword {
    public function make(FormBuilderInterface $form) {
        $setPasswordMaker = new SetPassword;
        return $setPasswordMaker->make($form)
                ->add('sent', SubmitType::class, ['label' => 'Změnit'])                                
                ;
    }
}
