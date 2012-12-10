<?php
namespace User\Model;

class User {
	public $id;
	private $email;
	public $first_time_seen;
	public $last_time_seen;
	public $is_black_listed;
	private $is_admin;

	public function exchangeArray($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->email = (isset($data['email'])) ? $data['email'] : null;
		$this->first_time_seen = (isset($data['first_time_seen'])) ? $data['first_time_seen'] : null;
		$this->last_time_seen = (isset($data['last_time_seen'])) ? $data['last_time_seen'] : null;
		$this->is_black_listed = (isset($data['is_black_listed'])) ? $data['is_black_listed'] : null;
		$this->is_black_listed = (isset($data['is_admin'])) ? $data['is_admin'] : null;		
	}
}
