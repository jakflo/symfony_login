<?php

namespace App\Form\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Models\UserRoles;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangeRoles {
    /**
     * @var UserRoles
     */
    protected $userRoles;
    
    public function __construct(UserRoles $userRoles) {
        $this->userRoles = $userRoles;
    }
    
    public function make(FormBuilderInterface $form) {
        return $form->add('id', HiddenType::class)
                ->add('userRole', ChoiceType::class, [
                    'label' => 'role', 
                    'choices' => $this->userRoles->getChoices(), 
                    'multiple' => true, 
                    'expanded' => true, 
                    'choice_attr' => function($choice, $key, $value) {
                        if ($value == 1) {
                            return ['checked' => '', 'disabled' => ''];
                        }
                        return [];        
                    }
                ])
                ->add('sent', SubmitType::class, [
                    'label' => 'Potvrdit', 
                    'attr' => ['data-button-side' => 'left']
                    ])
                ->add('cancel', ButtonType::class, [
                    'label' => 'Zrušit', 
                    'attr' => ['data-button-side' => 'right']
                    ])
                ;
    }
}
