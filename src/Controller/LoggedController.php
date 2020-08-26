<?php

namespace App\Controller;

class LoggedController extends ExtendedController {
    public function show() {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        return $this->renderWithParams('logged.html.twig');
    }
}
