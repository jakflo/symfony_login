<?php
namespace App\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Models\UserModel;
use App\Security\User;
use App\Form\Makers\ChangePassword as ChangePasswordMaker;
use App\Form\DataObjects\ChangePassword as ChangePasswordDataObj;

class ChangePasswordController extends ExtendedController {
    public function show(UserPasswordEncoderInterface $passwordEncoder, Request $request) {
        /**
         * @var User Description
         */
        $user = $this->getUser();
        
        if ($user === null) {
            $this->addParam('notLogged', true);
            return $this->renderWithParams('changePass.html.twig');
        }
        $changePasswordMaker = new ChangePasswordMaker;
        $changePasswordDataObj = new ChangePasswordDataObj;
        $form = $this->addForm($changePasswordMaker, 'change_password', $changePasswordDataObj, $request);
        if ($form->isSubmitted() && $form->isValid()) {
            $model = new UserModel($this->db);
            $model->updatePassword($passwordEncoder, $user, $changePasswordDataObj->getPlainPassword());
            $this->addFlash('notice', 'heslo změněno');
            return $this->redirectToRoute('change_password');
        }
        return $this->renderWithParams('changePass.html.twig');
    }
}
