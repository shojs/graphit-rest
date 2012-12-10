<?php
namespace Gi\Controller;

require_once '/vendor/GoogleIdentity/GoogleIdentity.php';
use vendor\GoogleIdentity\GoogleIdentity;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GiController extends AbstractActionController
{
	protected $userTable;
	
    public function loginAction()
    {
    	$gi = new GoogleIdentity();
        $view = new ViewModel(array(
            'gi' => $gi,
            'conf' => GoogleIdentity::$Conf
        ));
        $view->setTerminal(true);
    	return $view;
    }

    public function logoutAction()
    {
    	$gi = new GoogleIdentity();
    	$view = new ViewModel(array(
    	            'gi' => $gi,
    	            'conf' => GoogleIdentity::$Conf
    	));
    	$view->setTerminal(true);
    	return $view;
    }

    public function callbackAction()
    {
    	$gi = new GoogleIdentity();
    	$gi->askGitk();
    	$view = new ViewModel(array(
    	            'gi' => $gi,
    	            'conf' => GoogleIdentity::$Conf
    	));
    	$view->setTerminal(true);
    	return $view;
    }

    public function userStatusAction()
    {
    }
 	
    public function loggedAction()
    {
    	$gi = new GoogleIdentity();
    	$gi->askGitk();
    	$view = new ViewModel(array(
    	    	            'gi' => $gi,
    	    	            'conf' => GoogleIdentity::$Conf
    	));
    	$view->setTerminal(true);
    	return $view;
    }
    
    public function homeAction()
    {
    }
    
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('User\Model\UserTable');
    	}
    	return $this->userTable;
    }
}