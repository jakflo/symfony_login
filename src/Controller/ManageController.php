<?php

namespace App\Controller;
use App\Entity\Models\UserModel;
use App\Entity\Models\UserRoles;
use App\Entity\Models\UpdateUserModel;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DataObjects\ChangeRoles as ChangeRolesDataObj;
use App\Form\Makers\ChangeRoles as ChangeRolesMaker;
use App\Form\DataObjects\DeleteUser as DeleteUserDataObj;
use App\Form\Makers\DeleteUser as DeleteUserMaker;

class ManageController extends ExtendedController {
    protected $title = 'Správa uživatelů';
    
    public function show(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $model = new UserModel($this->db);
        $roleList = new UserRoles($this->db);
        $this->addParam('usersList', $model->getUserList());
        $this->addParam('roleList', $roleList);
        
        $changeRolesDataObj = new ChangeRolesDataObj($model, $this->getUser());
        $changeRolesMaker = new ChangeRolesMaker($roleList);
        $changeRolesForm = $this->addForm($changeRolesMaker, 'change_role', $changeRolesDataObj, $request);
        $deleteUserDataObj = new DeleteUserDataObj($model, $this->getUser());
        $deleteUserMaker = new DeleteUserMaker;
        $deleteUserForm = $this->addForm($deleteUserMaker, 'delete_user', $deleteUserDataObj, $request);
        
        if ($changeRolesForm->isSubmitted() and $changeRolesForm->isValid()) {
            $userUpdater = new UpdateUserModel($this->db, $changeRolesDataObj->getId());
            $userUpdater->updateRoles($changeRolesDataObj->getUserRole());
            $this->addFlash('notice', "Role uživatele {$userUpdater->getName()} změněny.");
            return $this->redirectToRoute('manageUsers');
        }
        
        if ($deleteUserForm->isSubmitted() and $deleteUserForm->isValid()) {
            $userUpdater = new UpdateUserModel($this->db, $deleteUserDataObj->getId());
            $userName = $userUpdater->getName();
            $userUpdater->deleteUser();
            $this->addFlash('notice', "Uživatel {$userName} byl vymazán.");
            return $this->redirectToRoute('manageUsers');
        }
                
        return $this->renderWithParams('manage.html.twig');
    }
}
