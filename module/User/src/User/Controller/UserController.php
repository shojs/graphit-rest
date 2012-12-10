<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractRestfulController {
	protected $albumTable;

	public function getList() {
		return new ViewModel(
				array('users' => $this->getUserTable()->fetchAll(),));
	}

	public function get($id) {
		return new ViewModel(
		array('user' => $this->getUserTable()->getUser($id)));
	}

	public function create($data) {
	}

	public function delete($id) {
	}

	public function update($id, $data) {
	}
	
	public function getUserTable() {
		if (!$this->albumTable) {
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('User\Model\UserTable');
		}
		return $this->albumTable;
	}
}
