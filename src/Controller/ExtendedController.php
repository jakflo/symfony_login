<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Models\Db_wrap;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DbConfig;

class ExtendedController extends AbstractController {
    /**
     *
     * @var Db_wrap
     */
    protected $db;
    
    /**
     *
     * @var array
     */
    protected $params;
    protected $title = 'Astromen';
    
    public function __construct() {
        $this->params = array(
            'title' => $this->title, 
            'webroot' => $this->getWebroot()
                );
        $this->db = $this->getDb();
    }

    public function addParam(string $name, $value) {
        $this->params[$name] = $value;
    }
    
    public function renderWithParams(string $twigPath) {
        return $this->render($twigPath, $this->params);
    }
    
    public function getWebroot() {
        $http = isset($_SERVER['HTTPS'])? 'https://' : 'http://';
        return $http.$_SERVER['HTTP_HOST'];
    }
    
    public function addForm($formMaker, string $formName, $formDataObject, Request $request) {
        $form = $formMaker->make($this->createNamedFormBuilder($formName, $formDataObject))->getForm();
        $form->handleRequest($request);
        $formName .= 'Form';
        $this->addParam($formName, $form->createView());
        return $form;        
    }
    
    protected function getDb() {
        $db = new Db_wrap(new DbConfig);
        return $db;
    }
    
    protected function createNamedFormBuilder(string $name, $data = null, array $options = [])
    {
        return $this->container->get('form.factory')->createNamedBuilder($name, FormType::class, $data, $options);
    }
}
