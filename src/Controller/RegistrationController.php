<?php

namespace App\Controller;

use App\Security\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Form\DataObjects\Register;
use App\Form\Makers\Registration;
use App\Entity\Models\UserModel;

class RegistrationController extends ExtendedController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator): Response
    {
        $user = new User();
        $registrationDataObj = new Register($this->db);
        $registrationFormMaker = new Registration;
        $form = $this->addForm($registrationFormMaker, 'registration', $registrationDataObj, $request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setName($registrationDataObj->getName());
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userModel = new UserModel($this->db);
            $userModel->register($user);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        return $this->renderWithParams('registration/register.html.twig');
    }
}
